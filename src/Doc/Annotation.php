<?php
/**
 * Date: 17-3-3
 * Time: 上午10:48
 */

namespace PhpAssist\Doc;


final class Annotation
{
    private $name;
    private $arguments;

    /**
     * Annotation constructor.
     * @param $name
     * @param $arguments
     */
    public function __construct($name, $arguments)
    {
        $this->name = $name;
        $this->arguments = $arguments;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getArguments()
    {
        return $this->arguments;
    }



}