<?php
/**
 * Created by PhpStorm.
 * User: r_mot
 * Date: 8/30/2018
 * Time: 11:56 PM
 */
class HomeController
{
    public function error()
    {

        output('error',['message'=>'501']);
    }
    public function addVideo($token , $url  , $category_id)
    {
        if(!UserModule::authenticated($token))
            output('error' , UserModule::getErrorCode());
        $owner = UserModule::getId($token);
        $url = urldecode($url);
        if(strhas($url,"youtu.be"))
        {
            $split = explode("/",$url);
            $key = $split[sizeof($split)-1];
            $url = "https://www.youtube.com/watch?v=".$key;
        }
        $data_url = "https://www.youtube.com/oembed?url=".urlencode($url)."&format=json";
        $data = json_decode(@file_get_contents($data_url));
        if(!$data || !isset($data->title))
            output('error' , 'invalid url');
        $title = $data->title;
        if(!HomeModule::addVideo($url ,$owner , $title , $category_id))
            output('error' , HomeModule::getErrorCode());
        output('ok' ,null);
    }
    public function getCategories()
    {
        output('ok' , HomeModule::getCategories());
    }
    public function getVideo($category_id)
    {
        $list = HomeModule::getRandVideo($category_id);
        foreach ($list as &$l)
        {
            $l['owner'] = UserModule::getUserInfo($l['owner']);
        }
        output('ok' , $list);
    }
    public function vote($video_id)
    {
        if(!HomeModule::voteVideo($video_id))
            output('error' , HomeModule::getErrorCode());
        output('ok' , null);
    }
}