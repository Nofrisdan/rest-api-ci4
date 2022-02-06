<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Libraries\Tes;

class Contact extends BaseController
{
    protected $library;

    public function __construct()
    {
        $this->library = new Tes();
    }


    public function index()
    {
        echo $this->library->index();
    }
}
