<?php


class UserController{
    public function login($username , $password)
    {
        if(!UserModule::isCredOk($username , $password))
            output('error' , UserModule::getErrorCode());
        if(!UserModule::updateToken($username , randomStr(10)))
            output('error' , UserModule::getErrorCode());
        $data = UserModule::getUserInfo($username);
        output('ok' , $data);
    }
    public function register($username , $password , $name)
    {
        $data = UserModule::getUserInfo($username);
        if($data)
            output('error' ,'Username already exists.');
        if(!UserModule::register($username , $password , $name))
            output('error' , UserModule::getErrorCode());
        output('ok',UserModule::getUserInfo($username));
    }

    public function profile($username)
    {
        $info = UserModule::getUserInfo($username);
        if(!$info)
            output('error' , UserModule::getErrorCode());

        $list = UserModule::extraInfo();
        $idx = -1;
        for($i = 0 ; $i < sizeof($list) ; $i++)
        {
            if($list[$i]['username'] == $username)
            {
                $idx = $i+1;
                break;
            }
        }
        if($idx == -1)
            output('error','invalid username');
        $info->rank = $idx;
        output('ok' , $info);
    }
    public function videos($id)
    {
        $list = UserModule::getVideos($id);
        if($list === false)
            output('error' , UserModule::getErrorCode());
        output('ok' , $list);
    }
}