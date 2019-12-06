<?php
/**
 * Created by PhpStorm.
 * User: r_mot
 * Date: 3/7/2019
 * Time: 10:00 AM
 */

class ParentClass
{
    static $ErrorCode = 0;
    public static function getErrorCode()
    {
        return self::$ErrorCode;
    }
    public static function setCode($code)
    {
        self::$ErrorCode = $code;
    }

}