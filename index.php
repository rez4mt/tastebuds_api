<?php
/**
 * Created by PhpStorm.
 * User: r_mot
 * Date: 7/12/2018
 * Time: 4:16 PM
 */

include __DIR__ . "/system/loader.php";

$uri = getRequestUri();
str_rm(getBaseUrl(),$uri);
$queryString = $_SERVER['QUERY_STRING'];

if (strlen($queryString)>0){
    $qvars = explode('&', $queryString);
    foreach ($qvars as $qvar){
        list($key, $value) = explode('=', $qvar);
        $_GET[$key] = $value;
    }
    str_rm('?' . $queryString, $uri);
}
$uri = urldecode($uri);
foreach (Config::SITE['route'] as $alias=>$target)
{
    $alias = '^'.$alias;
    str_rep('/',"\/",$alias);
    str_rep('*',"(.*)",$alias);
    if(preg_match("/".$alias."/",$uri))
    {
        $uri = preg_replace("/".$alias."/",$target,$uri);
    }
}

$parts = explode("/",$uri);
$controller = $parts[1];
if(strlen($controller) == 0 )
    $controller = "home";

if(count($parts)>2)
    $method = $parts[2];
else
    $method = 'error';
$params = [];
for($i = 3 ; $i<count($parts); $i++)
    $params[] = $parts[$i];

str_rep("-","_",$method);

$controllerClassName = $controller."Controller";
try {
    if (class_exists($controllerClassName)) {
        $controllerInstance = new $controllerClassName();
        if (method_exists($controllerInstance, $method)) {
            call_user_func_array(array($controllerInstance, $method), $params);
        } else {
            $controllerInstance = new HomeController();
            $controllerInstance->error();
        }
    } else {
        $controllerInstance = new HomeController();
        $controllerInstance->error();
    }
}catch (Exception $ex)
{
    $controllerInstance = new HomeController();
    $controllerInstance->error();
}
