<?php
/**
 * Created by PhpStorm.
 * User: r_mot
 * Date: 8/31/2018
 * Time: 4:41 PM
 */

class ImageController
{
    public function get($id,$as_img = false)
    {
        if(!$id)
        {
            output('error',['message'=>'2']);
            return;
        }

        if($image = ImageModule::getImage($id))
        {
            //show the image
            if($as_img)
            {
                echo $image;
                die;
            }
            output('success',['payload'=>$image]);
        }
    }
}