<?php
/**
 * Date: 17-3-2
 * Time: 下午5:32
 */

namespace PhpAssist\Doc;

use PhpParser\Error;
use PhpParser\ParserFactory;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\ClassMethod;

class AnnotationParser {

    static $grep_annotation = "/@(\\S+)\\s*(.*)/";

    /**
     * constructor.
     */
    public function __construct()
    {
        $this->parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP5);
    }

    private function explodeLines($docString){
//      $lines = explode(PHP_EOL , $docString);
        $lines = preg_split('/\n|\r\n?/', $docString);
        return $lines;
    }

    /**
     * parse line and returns comment name and its arguments
     * @return Annotation
     * */
    public function parseLine($line){
        if (preg_match(static::$grep_annotation,$line,$result)){
            return  new Annotation( $result[1] ,$this->parseArguments($result[2]));
        }
    }

    /**
     * @return mixed
    */
    public function parseArguments($argString){
        $arguments =[];
        $chars =[];
        $quote_amount = 0;
        $blank_amount = 0;
        $is_quote    = function($ch){
            return $ch=='\'' || $ch == '"';
        };
        for ($i=0; $i < strlen( $argString );$i++){
            $ch = $argString[$i];
            if ($is_quote($ch)){
                $quote_amount ++;
                if ($quote_amount==2){
                    $arguments [] = implode('',$chars);
                    $chars = [];
                    $quote_amount=0;
                }
            }else if ($ch == ' '){
                $blank_amount ++;

                if ($blank_amount==1){

                    if ($quote_amount==0 && count($chars)) {
                        $arguments [] = implode('', $chars);
                        $chars = [];
                        $blank_amount = 0;
                    }else if ($quote_amount==1){
                        $chars[] = $ch;
                    }

                }
            }else{
                $chars [] = $ch;
                $blank_amount = 0;
            }
        }
        if (count($chars)){
            $arguments [] = implode('',$chars);
        }

        return $arguments;
    }


    /**
     *@return AnnotationParseResult
    */
    public function parse($code){
        $result = new AnnotationParseResult();

        $stmts = $this->parser ->parse($code);
        $findStmts = function ($stmts,$type){
            return array_values(array_filter($stmts,function($stmt) use($type){
                    return $stmt instanceof $type;
                })
            );
        };

        $findFirstStmt = function($stmts,$type) use($findStmts){
            $fond = $findStmts($stmts,$type);
            if (count($fond)){
                return $fond[0];
            }
        };

        $namespaceStmt = $findFirstStmt($stmts,Namespace_::class);
        $classStmt = null;
        if ($namespaceStmt){
            $namespace = $namespaceStmt->name->toString();
            $result->setNamespace($namespace);
            $classStmt = $findFirstStmt($namespaceStmt->stmts,Class_::class);
        }else{
            $classStmt = $findFirstStmt($stmts,Class_::class);
        }

        if ($classStmt) {
            $result->setClassName($classStmt->name);
            $classDoc = $classStmt->getDocComment();
            $classDocLines = $this->explodeLines($classDoc) ;

            foreach ($classDocLines as $classDocLine){
                $anno  = $this->parseLine($classDocLine);
                if ($anno) {
                    $result->addClassAnnotation($anno);
                }

            }
            $classMethods = $findStmts($classStmt->stmts,ClassMethod::class);
            foreach($classMethods as $classMethod) {

                $doc = $classMethod->getDocComment();
                foreach ( $this->explodeLines($doc) as $line ){
                    $anno = $this->parseLine($line);
                    if ($anno) {
                        $result->addMethodAnnotation($classMethod->name , $anno);
                    }
                }

            }

        }

        return $result;

    }


}