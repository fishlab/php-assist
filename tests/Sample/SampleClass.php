<?php

namespace Tests\Sample;

/**
 * Date: 17-4-13
 * Time: 下午4:57
 */

use Tests\Sample\Exception\BarException as BAE;
use Tests\Sample\Exception\FooException;


class SampleClass{

    public function fun($a){

        if ($a == 1){
            throw new \Exception('a_equal_1');
        };

        if ($a == 2){
            throw new SampleException('a_equal_2');
        };

        if ($a==3){
            throw new \Tests\Sample\Exception\BarException ('a_qual_3');
        }

        if ($a==33){
            throw new BAE('a_equal_33');
        }

        if ( $a==4){
            throw new FooException('a_equal_4');
        }

        if ($a>5){
            if ($a<10){
                throw new FooException('hehe');
            }
        }



    }

}