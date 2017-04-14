<?php

/**
 * Date: 17-4-13
 * Time: 下午4:55
 */

use PhpParser\ParserFactory;

use PhpAssist\Doc\ThrowableParser;

use Tests\Sample\Exception\FooException;

class TestThrowableParser extends \TestCase
{

    public function testPhpParser(){
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP5);
        $code = file_get_contents(__DIR__ . '/../Sample/SampleClass.php');
        $stmts = $parser->parse($code);
        print_r( $stmts );

    }

    public function test(){
        $parser = (new ThrowableParser);

        $code = file_get_contents(__DIR__ . '/../Sample/SampleClass.php');

        $reuslt = $parser->parse($code);

        print_r( $reuslt->getMethodThrowable('fun',\Exception::class) );



    }


}