<?php

namespace App\Libraries;


class Respon
{


    // success

    public function success($value)
    {
        $data = [
            "status" => 200,
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
}
