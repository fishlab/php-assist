<?php
/**
 * Date: 17-4-13
 * Time: 下午4:52
 */

namespace PhpAssist\Doc;

use PhpParser\Error;
use PhpParser\ParserFactory;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Use_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Throw_;

use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\ClassMethod;

class ThrowableParser extends BasicParser
{

    function parse($code){

        $this->parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP5);

        $stmts = $this->parser ->parse($code);
        $result= new ThrowableParseResult();
        $aliasMapping = [ ];

        $namespaceStmt = $this->findFirstStmt($stmts,Namespace_::class);
        $useStmts = null;
        $classStmt = null;
        $namespace = null;
        if ($namespaceStmt){
            $namespace = $namespaceStmt->name->toString();
            $result->setNamespace($namespace);
            $useStmts = $this->findStatements($namespaceStmt->stmts,Use_::class);
            $classStmt = $this->findFirstStmt($namespaceStmt->stmts,Class_::class);
        }else{
            $classStmt = $this->findFirstStmt($stmts,Class_::class);
            $useStmts = $this->findStatements($stmts,Use_::class);

        }
        foreach($useStmts as $useStmt) {
            $use = $useStmt->uses[0];
            $fullClassName =  strval( $use->name);
            $aliasClassName = $use->alias;
            $aliasMapping[$aliasClassName ] = $fullClassName;
        }

        if ($classStmt) {
            $result->setClassName($classStmt->name);
        }
        $classMethods = $this->findStatements($classStmt->stmts,ClassMethod::class);
        foreach($classMethods as $classMethod) {
            $throwStmts  = $this->statementsIterator($classMethod->stmts,function($s){
                return $s instanceof Throw_;
            });
            $throws = array_map( function($throwStmt) use($namespace,$aliasMapping){
                return $this->parseThrowStatement( $throwStmt,$namespace,$aliasMapping );
            } ,$throwStmts);
            $result->setMethodThrowables( $classMethod->name , $throws );

        }

        return $result;
    }

    public function parseThrowStatement($throwStat,$namespace,$aliasMapping){
        $class = $throwStat->expr->class;
        $className = null;
        if ( $class instanceof FullyQualified){
            $className =  implode('\\',$class->parts );
        }else{
            $namePartsCount =  count($class->parts);
            if ($namePartsCount){
                if ($namePartsCount>1) {
                    if ($namespace) {
                        $className = $namespace . '\\' . implode('\\', $class->parts);
                    } else {
                        $className = implode('\\', $class->parts);
                    }
                }elseif (  array_key_exists( $class->parts[0] ,$aliasMapping) ){
                    $className =  $aliasMapping [$class->parts[0] ];
                }
            }

        }
        $arguments = $throwStat->expr->args;
        $t = new  Throwable($className,$arguments);
        return $t;

    }


}