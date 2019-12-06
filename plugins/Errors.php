<?php
/**
 * Created by PhpStorm.
 * User: r_mot
 * Date: 8/31/2018
 * Time: 5:18 PM
 */
class Errors{

    private static $_Errors = [

        '0'=>   'invalid_format',
        '1'=>   'invalid_time',
        '2'=>   'missing_parameter',
        '500'=> 'internal_error',
        '501'=> 'missing_method',
        'unk'=> 'unknown_error'
        ];

    static function exists($code)
    {
        return isset(self::$_Errors[$code]);
    }

    static function getErrorMsg($error)
    {
        if(isset(self::$_Errors[$error]))
            return self::$_Errors[$error];
        else
            return self::$_Errors['unk'];
    }
}