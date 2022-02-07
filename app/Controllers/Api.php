<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;


// db
use App\Models\Tb_user;

// library
use App\Libraries\Respon;

class Api extends BaseController
{
    use ResponseTrait;
    protected $tb_user, $lib;
    public function __construct()
    {
        $this->tb_user = new Tb_user();
        $this->lib = new Respon();
    }


    // ====================== GET DATA =================================
    public function index()
    {
        $data = $this->lib->success($this->tb_user->findAll());

        return $this->respond($data);
    }

    public function find($id)
    {
        $data = $this->lib->success($this->tb_user->where("id_user", $id)->first());

        return $this->respond($data);
    }


    // ================== end======================


    // ============= CREATE ==================

}
