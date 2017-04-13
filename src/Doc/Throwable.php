<?php
/**
 * Date: 17-4-13
 * Time: 下午5:54
 */

namespace PhpAssist\Doc;


class Throwable
{
    private $namespace;
    private $className;
    private $arguments;

    /**
     * Throwable constructor.
     * @param $className
     * @param $arguments
     */
    public function __construct($className, $arguments)
    {
        $this->className = $className;
        $this->arguments = $arguments;
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
     * @return mixed
     */
    public function getArguments()
    {
        return $this->arguments;
    }




}