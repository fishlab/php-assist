<?php

/**
 * Date: 17-4-13
 * Time: 下午4:55
 */

use PhpParser\ParserFactory;

use PhpAssist\Doc\ThrowableParser;

use Tests\Sample\Exception\FooException;
use PhpParser\Node\Expr\ClassConstFetch;

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

        $result = $parser->parse($code);

//        print_r( $result->getMethodThrowable('fun',FooException::class) );


        print_r($result);


    }

    public function testGetConstants(){
        print constant( 'Tests\\Sample\\Constants'  . '::status_error' );
    }


}