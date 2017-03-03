<?php

namespace  PhpAssist\FileSystem;

/**
 * Date: 17-3-3
 * Time: 下午12:06
 */

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;


final class FileSystemIteratorFactory
{

    public static function regexFileSystemIterator($baseDir, $regex =  '/^.+\.php$/i'){
        $directoryIterator = new RecursiveDirectoryIterator( $baseDir );
        $iterator = new RecursiveIteratorIterator($directoryIterator);
        $regexIterator = new RegexIterator($iterator, $regex, RecursiveRegexIterator::GET_MATCH);
        return $regexIterator;
    }

}