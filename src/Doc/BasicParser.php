<?php
/**
 * Date: 17-4-13
 * Time: 下午5:33
 */

namespace PhpAssist\Doc;


class BasicParser
{


    function findFirstStmt($stmts, $type)
    {
        $fond = $this->findStatements($stmts, $type);
        if (count($fond)) {
            return $fond[0];
        }
    }

    function findStatements($stmts, $type)
    {
        return array_values(array_filter($stmts, function ($stmt) use ($type) {
                return $stmt instanceof $type;
            })
        );
    }


    function statementsIterator( $stmts,$filter = null){
        $stack =  array_merge([] ,$stmts  );
        $results  = [];
        while( count( $stack)){
            $stmt = array_pop($stack);
            if (!$filter || call_user_func($filter,$stmt)) {
                $results[] = $stmt;
            }

            if (property_exists ($stmt,'stmts') && count($stmt->stmts )){
                foreach ($stmt->stmts as $s){
                    array_push($stack,$s);
                }
            }

        }

        return $results;

    }
}