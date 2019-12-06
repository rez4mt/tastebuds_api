<?php
/**
 * Created by PhpStorm.
 * User: r_mot
 * Date: 8/30/2018
 * Time: 10:44 PM
 */


function __autoload($class_name)
{

    if(strhas("Controller",$class_name))
    {
        str_rm("Controller",$class_name);
        classify($class_name);
        if(is_file(__DIR__ . "/../mvc/controller/$class_name.php") )
        {
            include_once (__DIR__ . "/../mvc/controller/$class_name.php");
            return;
        }
        //load controller
        output('error',['message'=>'501']);
    }
    if(strhas("View",$class_name))
    {
        str_rm("View",$class_name);
        classify($class_name);

        //load controller
        if(is_file(__DIR__ . "/../mvc/view/$class_name.php"))
        {
            include_once (__DIR__ . "/../mvc/view/$class_name.php");
            return;
        }
        output('error',['message'=>'501']);
    }

    if(strhas("Module",$class_name))
    {
        str_rm("Module",$class_name);
        classify($class_name);
        //load controller
        if(is_file(__DIR__ . "/../mvc/module/$class_name.php"))
        {
            include_once __DIR__ . "/../mvc/module/$class_name.php";
            return;
        }
        output('error',['message'=>'501']);
    }

    //classify($class_name);

    if(file_exists(__DIR__."/../plugins/$class_name.php"))
    {
        include __DIR__."/../plugins/$class_name.php";
        return;
    }

    output('error',['message'=>'500']);


}

