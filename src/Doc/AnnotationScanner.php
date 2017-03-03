<?php

namespace PhpAssist\Doc;


class AnnotationScanner {



    private $fileSystemIterator;
    private $parser;
    /**
     * AnnotationScanner constructor.
     */
    public function __construct($fileSystemIterator)
    {
        $this->fileSystemIterator = $fileSystemIterator;
        $this->parser = new AnnotationParser();
    }


    public function scan(){
        $results = [] ;
        foreach ($this->fileSystemIterator as $filename => $current) {
//            $files [] = $filename;
            $code = file_get_contents($filename);
            $results [] = $this->parser->parse($code);
        }

        return $results;

    }



}