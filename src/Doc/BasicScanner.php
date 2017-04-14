<?php
/**
 * Date: 17-4-14
 * Time: 上午10:23
 */

namespace PhpAssist\Doc;


class BasicScanner
{


    private $fileSystemIterator;
    private $parser;
    /**
     * AnnotationScanner constructor.
     */
    public function __construct($fileSystemIterator,$parserClass)
    {
        $this->fileSystemIterator = $fileSystemIterator;
        $this->parser = new $parserClass();
    }


    public function scan(){
        $results = [] ;
        foreach ($this->fileSystemIterator as $filename => $current) {
            $code = file_get_contents($filename);
            $results [] = $this->parser->parse($code);
        }

        return $results;

    }

}