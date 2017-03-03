<?php

/**
 * Date: 17-3-2
 * Time: 下午12:13
 */
namespace Tests\Doc;

use PhpAssist\Doc\AnnotationScanner;
use PhpAssist\FileSystem\FileSystemIteratorFactory;

class TestAnnotationScanner extends \TestCase
{

    public function testScan(){

        $dir =  realpath( __DIR__ . '/../files' );

        $scanner =  new AnnotationScanner( FileSystemIteratorFactory::regexFileSystemIterator($dir) );

        $results = $scanner->scan();

        print_r($results);

    }

}