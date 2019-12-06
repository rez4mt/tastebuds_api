<?php
/**
 * Created by PhpStorm.
 * User: r_mot
 * Date: 8/30/2018
 * Time: 10:55 PM
 */


include (__DIR__ . "/Config.php");
include (__DIR__ . "/commons.php");
include (__DIR__ . "/core.php");

spl_autoload_register("__autoload");
/*
global $request;
$request = RequestConverter::setup(file_get_contents("php://input"));

if($request->isValidRequest())
    output("error",['message'=>$request->getError()]);
*/
