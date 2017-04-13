<?php
/**
 * Date: 17-4-13
 * Time: 下午5:46
 */

namespace PhpAssist\Doc;


class ThrowableParseResult
{
    private $namespace;
    private $className;

    private $methodThrowableMapping;


    private function findThrowable($throwables,$throwableClassName){
        $found = null;
        foreach ($throwables as $throwable){
            if (  $throwableClassName == $throwable->getClassName() ){
                $found = $throwable;
                break;
            }
        }
        return $found;
    }

    public function addMethodThrowable($methodName,Throwable $throwable ){
        if ( array_key_exists($methodName,$this->methodThrowableMapping)){
            $throwables =  & $this->methodThrowableMapping[$methodName];
            $throwables [] = $throwable;
        }else{
            $this->methodThrowableMapping[$methodName] = [$throwable];
        }
    }

    public function getMethodThrowable($methodName,$throwableName){
        $throwables = $this->getMethodThrowables($methodName);
        $found = null;
        if ($throwables) {
            $found = $this->findThrowable($throwables, $throwableName);
        }
        return $found;
    }


    public function getMethodThrowables($methodName ){
        if ( array_key_exists($methodName,$this->methodThrowableMapping)){
            $throwables =  $this->methodThrowableMapping[$methodName];
            return $throwables;
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param mixed $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param mixed $className
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * @return mixed
     */
    public function getMethodThrowableMapping()
    {
        return $this->methodThrowableMapping;
    }

    /**
     * @param mixed $methodThrowableMapping
     */
    public function setMethodThrowableMapping($methodThrowableMapping)
    {
        $this->methodThrowableMapping = $methodThrowableMapping;
    }


    public function setMethodThrowables($methodName,$throwables){
        $this->methodThrowableMapping[$methodName] = $throwables;

    }




}