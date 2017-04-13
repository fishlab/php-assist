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
            $throws = $this->statementsIterator($classMethod->stmts,function($s){
                return $s instanceof Throw_;
            });

            $result->setMethodThrowables( $classMethod->name , $throws );

        }

        return $result;
    }


}