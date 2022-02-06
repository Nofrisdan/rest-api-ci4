<?php

namespace App\Controllers\Api;

// use App\Controllers\BaseController;
use App\Libraries\Tes;
use App\Models\Tb_user;

// library Api
use CodeIgniter\RESTful\ResourceController;

class Contact extends ResourceController
{
    protected
        $library,
        $tb_user;

    protected $format = 'json';

    public function __construct()
    {
        $this->library = new Tes();
        $this->tb_user = new Tb_user();
    }


    public function index()
    {
        // echo $this->library->index();

        return $this->respond($this->tb_user->getData());
    }

    public function getUser($id)
    {
        return $this->respond($this->tb_user->getData($id));
    }
}
