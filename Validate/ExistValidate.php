<?php

namespace App\Validate;

class ExistValidate implements ValidatorInterface
{
    public static function handle(array $item) :bool
    {

        if (isset($item[1])){

            $table = $item[1];

            if(intval($item[0]) && is_int(intval($item[0]))){
                $db = \Phalcon\Di::getDefault()->get('db');
                $sql = "SHOW TABLES LIKE ?;";
                $result = $db->execute($sql, [$table]);
                if($result) {
                    $sql2 = "SELECT COUNT(*) as num FROM $table where id = ?;";
                    $result2 = $db->fetchOne($sql2, \Phalcon\Db::FETCH_ASSOC, [$item[0]]);
                    return $result2['num'] > 0;
                }
            }
        }

        return false;
    }
}