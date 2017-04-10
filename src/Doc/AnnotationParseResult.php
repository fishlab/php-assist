<?php

/**
 * Date: 17-3-2
 * Time: 下午6:25
 */

namespace PhpAssist\Doc;


class AnnotationParseResult
{
    private $namespace;
    private $className;

    private $classAnnotations;

    private $methodAnnotationsMapping;


    /**
     * AnnotationParseResult constructor.
     */
    public function __construct()
    {
        $this->classAnnotations = [];
        $this->methodAnnotationsMapping =[];
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
     * @return array
     */
    public function getClassAnnotations()
    {
        return $this->classAnnotations;
    }

    private function findAnnotation($annotations,$annotationName){
        $found = null;
        foreach ($annotations as $annotation){
            if (  $annotationName == $annotation->getName() ){
                $found = $annotation;
                break;
            }
        }
        return $found;
    }

    public function getClassAnnotation($annotationName)
    {
        return $this->findAnnotation( $this->classAnnotations,$annotationName);
    }



    public function addClassAnnotation(Annotation $annotation){
        $this->classAnnotations[] = $annotation;
    }


    /**
     * @return array
     */
    public function getMethodAnnotationsMapping()
    {
        return $this->methodAnnotationsMapping;
    }



    public function addMethodAnnotation($methodName,Annotation $annotation ){
        if ( array_key_exists($methodName,$this->methodAnnotationsMapping)){
            $annotations =  & $this->methodAnnotationsMapping[$methodName];
            $annotations [] = $annotation;
        }else{
            $this->methodAnnotationsMapping[$methodName] = [$annotation];
        }
    }

    public function getMethodAnnotation($methodName,$annotationName){
        $annotations = $this->getMethodAnnotations($methodName);
        $found = null;
        if ($annotations) {
            $found = $this->findAnnotation($annotations, $annotationName);
        }
        return $found;
    }


    public function getMethodAnnotations($methodName ){
        if ( array_key_exists($methodName,$this->methodAnnotationsMapping)){
            $annotations =  $this->methodAnnotationsMapping[$methodName];
            return $annotations;
        }
        return null;
    }


}