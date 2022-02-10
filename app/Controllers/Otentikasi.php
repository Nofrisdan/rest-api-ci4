<?php

namespace App\Controllers;

use App\Models\Tb_user;
use App\Models\Tb_kontak;
use App\Controllers\BaseController;
use App\Models\Tb_akses;
use App\Libraries\Respon;
use CodeIgniter\API\ResponseTrait;

class Otentikasi extends BaseController
{
    use ResponseTrait;
    protected
        $tb_user,
        $tb_akses,
        $lib;

    public function __construct()
    {
        $this->lib = new Respon();
        $this->tb_user = new Tb_user();
        $this->tb_akses = new Tb_akses();
    }

    public function index()
    {
        $data = $this->lib->success($this->tb_user->findAll());

        return $this->respond($data);
    }
}
