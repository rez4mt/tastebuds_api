<?php
/**
 * Created by PhpStorm.
 * User: r_mot
 * Date: 8/31/2018
 * Time: 4:59 PM
 */

class Device
{
    private $_category,$_model,$_size,$_uid,$_os,$_type,$_notification_id;

    public function __construct($data)
    {
        $this->_category = $data->category;
        $this->_model = $data->model;
        $this->_size = $data->size;
        $this->_uid = $data->uid;
        $this->_os = $data->os;
        $this->_type = $data->type;
        $this->_notification_id = $data->notification_id;
    }


    /* @return string*/
    public function getCategory()
    {
        return $this->_category;
    }
    /* @return string*/
    public function getModel()
    {
        return $this->_model;
    }
    /* @return string*/
    public function getSize()
    {
        return $this->_size;
    }
    /* @return string*/
    public function getUniqueId()
    {
        return $this->_uid;
    }
    /* @return string*/
    public function getOsName()
    {
        return $this->_os->name;
    }
    /* @return string*/
    public function getOsVersion()
    {
        return $this->_os->version;
    }
    /* @return string*/
    public function getType()
    {
        return $this->_type;
    }
    /* @return string*/
    public function getNotificationId()
    {
        return $this->_notification_id;
    }

}