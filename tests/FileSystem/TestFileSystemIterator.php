<?php

/**
 * Date: 17-3-2
 * Time: 下午4:11
 */
namespace Tests\FileSystem;

use PhpAssist\FileSystem\FileSystemIteratorFactory;

class TestFileSystemIterator extends \TestCase
{

    public function testRegexIterator(){

        $dir =  realpath( __DIR__ . '/../files' );

        $iterator = FileSystemIteratorFactory::regexFileSystemIterator($dir);

        $f  = [];
        foreach ($iterator as $info => $current) {
            $f [] =$info;
        }
        print_r($f);
    }

}
