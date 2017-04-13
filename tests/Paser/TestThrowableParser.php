<?php

/**
 * Date: 17-4-13
 * Time: 下午4:55
 */

use PhpParser\ParserFactory;

use PhpAssist\Doc\ThrowableParser;


class TestThrowableParser extends \TestCase
{

    public function test(){
        $this->parser = (new ThrowableParser);
//        $this->parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP5);

        $code = file_get_contents(__DIR__ . '/../Sample/SampleClass.php');

        $stmts = $this->parser->parse($code);

        print_r( $stmts );




    }


}