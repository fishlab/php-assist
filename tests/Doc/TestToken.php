<?php
/**
 * Date: 17-3-2
 * Time: 下午5:35
 */

namespace Tests\Doc;


class TestToken extends \TestCase
{

    public function testGetAllToken(){
        $tokens = token_get_all('"hello"  world;');

        print_r($tokens);
    }

}