<?php
/**
 * Created by PhpStorm.
 * User: r_mot
 * Date: 8/30/2018
 * Time: 4:01 PM
 */

class Config{
    /* @var array*/
    const DB = [
        'name'=>'',
        'username'=>'',
        'password'=>'',
        'config'=>[
            PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
        ]
    ];
    /* @var string*/
    const DATE_FORMAT = "yyyyMMddHHmmss";

    /* @var PDO*/
    public static $DB = null;
    /* @var array*/
    const SITE = [
        'base_url'=>'/s/Base',
        'route'=>[

        ]
    ];
}