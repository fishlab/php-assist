<?php
/**
 * Date: 17-3-2
 * Time: 下午5:46
 */

namespace Tests\Doc;

use PhpAssist\Doc\AnnotationParser;

class TestAnnotationParser extends  \TestCase
{

    public function testParseArguments(){
        $p = new AnnotationParser();

        $arguments = $p->parseArguments('');
        $this->assertEquals([],$arguments);

        $arguments = $p->parseArguments('  ');
        $this->assertEquals([],$arguments);

        $arguments = $p->parseArguments('arg1 arg2');
        $this->assertEquals(['arg1','arg2'],$arguments);

        $arguments = $p->parseArguments('  arg1 arg2  ');
        $this->assertEquals(['arg1','arg2'],$arguments);

        $arguments = $p->parseArguments(' 中文  "a quote argument" test     参数3 ');
        $this->assertEquals(['中文','a quote argument','test','参数3'],$arguments);
    }

    public function testParseLine(){
        $p = new AnnotationParser();

        $anno1  = $p->parseLine(" anno");
        $this->assertEquals(null,$anno1);
        unset($anno1);

        $anno2  = $p->parseLine(" @anno");
        $this->assertEquals('anno',$anno2->getName() );
        $this->assertEquals( [], $anno2->getArguments()  );
        unset($anno2);

        $anno3 = $p->parseLine(" * @anno arg1 \"arg 2\"");
        $this->assertEquals('anno',$anno3->getName() );
        $this->assertEquals( [ 'arg1' ,'arg 2' ], $anno3->getArguments()  );
        unset($anno3);

        $anno3 = $p->parseLine("@anno arg1 \"arg 2\"");
        $this->assertEquals('anno',$anno3->getName() );
        $this->assertEquals( [ 'arg1' ,'arg 2' ], $anno3->getArguments()  );
        unset($anno3);


    }

    public function testParse1(){
        $par = new AnnotationParser();

        $code = file_get_contents(__DIR__ . '/../files/TestParser1.php');

        $r  =$par ->parse( $code );

//        print_r($r);

        $classAnnotations = $r->getClassAnnotations();

        $this->assertEquals( 2, count($classAnnotations ) );

        $this->assertEquals('anno1'  ,$classAnnotations[0]->getName() );

        $this->assertNotNull( $r->getClassAnnotation('anno1'));

        $this->assertNotNull( $r->getMethodAnnotation('methodA','mAnno0'));
        $this->assertNotNull( $r->getMethodAnnotation('methodA','mAnno'));


    }

    public function testParse2(){
        $par = new AnnotationParser();

        $code = file_get_contents(__DIR__ . '/../files/TestParser2.php');

        $r  = $par ->parse( $code );

        $classAnnotations = $r->getClassAnnotations();

        $this->assertEquals( 0, count($classAnnotations ) );

//        $this->assertEquals('anno1'  ,$classAnnotations[0]->getName() );

        $this->assertNull($r->getMethodAnnotation('methodA_','mAnno'));

        $this->assertNull($r->getMethodAnnotation('methodA','mAnno_'));

        $this->assertNotNull($r->getMethodAnnotation('methodA','mAnno'));



    }

    public function testParse3(){
        $parser = new AnnotationParser();

        $code = "<?php 
        
        namespace Foo;
        
        /**
        * @class_annotation arg1 arg2
        */
        class Bar
        {
        
            /** @my_annotation arg1
             * */
            public function methodA(){
        
            }
            /** @another_annotation
            */
            public function methodB(){
        
            }
        
        }
        ";

        $result  = $parser ->parse( $code );

        print_r($result);

    }

}