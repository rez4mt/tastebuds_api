<?php
/**
 * Created by PhpStorm.
 * User: r_mot
 * Date: 8/30/2018
 * Time: 4:05 PM
 */

function getConn()
{
    if(Config::$DB !== null)
        return Config::$DB;

    try{
        Config::$DB = new PDO(
            "mysql:host=localhost;dbname=".Config::DB['name'],
            Config::DB['username'],
            Config::DB['password'],
            Config::DB['config']
        );
    }catch (Exception $e){
        echo ($e->getTraceAsString());
        die;
    }
    return getConn();
}



function strhas($string, $search, $caseSensitive = false)
{
    if ($caseSensitive) {
        return strpos($string, $search) !== false;
    } else {
        return (strpos(strtolower($string), strtolower($search)) !== false || strpos(strtolower($search), strtolower($string)) !== false);
    }
}
function str_rep($old,$new,&$str){
    $str = str_replace($old,$new,$str);
}
function str_rm($word,&$str){
    $str = str_replace($word,"",$str);
}
function classify(&$name,$return = false){
    if(!$return)
    {
        $name = ucfirst(strtolower($name));
        return true;
    }
    else return $name;
}
function getRequestUri()
{
    global $_SERVER;
    return $_SERVER['REQUEST_URI'];
}
function getBaseUrl()
{
    return Config::SITE['base_url'];
}

function randomStr($length = 16)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function output($status,$data)
{
    $output_data = [
        'status' => $status
    ];

    if(isset($data['message']))
    {
        if(Errors::exists($data['message']))
            $output_data['message'] = Errors::getErrorMsg($data['message']);
        else
            $output_data['message'] = $data['message'];
    }else if(isset($data['payload']))
        $output_data['payload'] = $data['payload'];
    else if($status == 'ok')
    {
        $output_data['payload'] = $data;
    }else if($status == "error")
    {
        $output_data['message'] = Errors::getErrorMsg($data);
    }
    echo json_encode($output_data);
    die;

}