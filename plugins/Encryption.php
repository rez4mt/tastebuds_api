<?php
/**
 * Created by PhpStorm.
 * User: r_mot
 * Date: 7/12/2018
 * Time: 3:45 PM
 */

class Encryption
{

    const PRIVATE = 0;
    const PUBLIC = 1;
    const RSA_MAX_LEN = 256;
    static $_RSA_KEY_CONF = [
        "digest_alg" => "sha512",
        "private_key_bits" => 2048,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    ];

    static $_key ;
    static $_iv ;

    static $_pub_key;
    static $_prv_key;

    static function getKey()
    {
        return self::$_key;
    }
    static function getIV()
    {
        return self::$_iv;
    }
    static function getEncodedKey()
    {
        return base64_encode(self::getKey());
    }
    static function getEncodedIV()
    {
        return base64_encode(self::getIV());
    }

    static function getPrivateKey()
    {
        return self::$_prv_key;
    }
    static function getPublicKey()
    {
        return self::$_pub_key;
    }
    static function getEncodedPrivateKey()
    {
        return base64_encode(self::$_prv_key);
    }
    static function getEncodedPublicKey()
    {
        return base64_encode(self::$_pub_key);
    }

    static function generateRSAKey()
    {
        $res = openssl_pkey_new(self::$_RSA_KEY_CONF);
        var_dump($res);

    }

    static function AES256Decrypt($text,$pass,$iv)
    {
        if(strlen($pass)!=32)
        {
            $pass = base64_decode($pass);
            if(strlen($pass)!=32)
                return false;
        }
        if(strlen($iv)!=16)
        {
            $iv = base64_decode($iv);
            if(strlen($iv)!=16)
                return false;
        }
        return openssl_decrypt(base64_decode($text), "aes-256-cbc", $pass, OPENSSL_RAW_DATA, $iv);
    }
    static function AES256Encrypt($text,$pass=null,$iv=null)
    {

        if($pass == null)
            $pass = random_bytes(32);
        if($iv == null)
            $iv =random_bytes(16);

        self::$_iv = $iv;
        self::$_key = $pass;

        return base64_encode(openssl_encrypt($text,"aes-256-cbc",$pass,OPENSSL_RAW_DATA,$iv));
    }

    static function RSAEncrypt($source,$type = Encryption::PUBLIC,$key = null)
    {
        if($key == null)
        {
            self::generateRSAKey();
            var_dump(openssl_error_string());

            die;
        }
        $output = "";

        while($source)
        {
            $input = substr($source,0,self::RSA_MAX_LEN);
            $enc = "";
            $source = substr($source,self::RSA_MAX_LEN);
            if($type == Encryption::PRIVATE)
            {
                $ok=openssl_private_encrypt($input,$enc,$key);
            }elseif($type == Encryption::PUBLIC)
            {
                $ok=openssl_public_encrypt($input,$enc,$key);
            }else return false;
            $output.=$enc;
        }
        return base64_encode($output);
    }
    static function RSADecrypt($data,$decrypted,$key,$type = Encryption::PRIVATE)
    {
        if($type == Encryption::PRIVATE)
            return openssl_private_decrypt($data,$decrypted,$key,OPENSSL_NO_PADDING);
        else if($type == Encryption::PUBLIC)
            return openssl_public_decrypt($data,$decrypted,$key,OPENSSL_NO_PADDING);
        else return false;
    }



}