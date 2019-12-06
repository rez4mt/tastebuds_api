<?php
/**
 * Created by PhpStorm.
 * User: r_mot
 * Date: 8/31/2018
 * Time: 4:47 PM
 */

class RequestConverter{
    private $_valid_request = false;
    private $_time,$_payload,$_token,$_device,$_ver;
    private $_error = 0 ;

    static function setup($data)
    {
        return new RequestConverter($data);
    }

    private function __construct($data)
    {
        if(!isset($data->time,$data->payload,$data->target,$data->token,$data->device,$data->version))
        {
            $this->_valid_request = false;
            return;
        }

        $this->_time = $data->time;
        $this->_payload = $data->payload;
        $this->_token = $data->token;
        $this->_device = $data->device;
        $this->_ver = $data->version;

        if(!isset($this->_device->category,$this->_device->model,$this->_device->size,
            $this->_device->uid,$this->_device->os,$this->_device->os->version,
            $this->_device->os->name,$this->_device->type))
        {
            $this->_valid_request = false;
            return;
        }

        $this->_device = new Device($this->_device);
        if((time() - strtotime($this->_time)) > 10)
        {
            $this->_error = 1;
            return;
        }

        $this->_valid_request = true;

    }

    /* @return bool*/
    public function isValidRequest()
    {
        return $this->_valid_request;
    }
    /* @return string*/
    public function getTime()
    {
        return $this->_time;
    }
    /* @return array*/
    public function getPayload()
    {
        return $this->_payload;
    }
    /* @return string*/
    public function getToken()
    {
        return $this->_token;
    }
    /* @return Device*/
    public function getDevice()
    {
        return $this->_device;
    }
    /* @return string*/
    public function getVersion()
    {
        return $this->_ver;
    }

    /* @return string*/
    public function getError()
    {
        return Errors::getErrorMsg($this->_error);
    }

}