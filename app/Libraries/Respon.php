<?php

namespace App\Libraries;


class Respon
{

    protected $request;
    public function __construct()
    {
        $this->request = service("request");
    }

    // success
    public function success($value)
    {
        $data = [
            "status" => 200,
            "ip_address" => $this->getIPAddress(),
            "values" => $value
        ];


        return $data;
    }
    // error
    public function Error($value)
    {
        $data = [
            "status" => 401,
            "values" => $value
        ];


        return $data;
    }

    // private
    public function getIPAddress()
    {
        //whether ip is from the share internet  
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        //whether ip is from the proxy  
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $getIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
            $exp = explode(",", $getIp);

            $ip = $exp[0];
        }
        //whether ip is from the remote address  
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}
