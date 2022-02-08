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
    protected $tb_user, $lib, $validasi;
    public function __construct()
    {
        $this->tb_user = new Tb_user();
        $this->lib = new Respon();
        $this->validasi = service("validation");
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
    public function create()
    {

        // validation
        if (!$this->validate([
            "nama_user" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Harap Masukkan Parameter Nama User"
                ]
            ],
            "email" => [
                "rules" => "required|is_unique[tb_user.email]",
                "errors" => [
                    "required" => "Harap Masukkan Parameter email",
                    "is_unique" => "Alamat Email Yang anda masukkan sudah terdaftar"

                ]
            ],
            "wa" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Harap Masukkan parameter wa"
                ]
            ],
            "password" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Harap Masukkan Parameter Password"
                ]
            ],
        ])) {

            $data = $this->lib->Error($this->validasi->getErrors());

            return  $this->respond($data);
        }

        $data = $this->lib->success($this->request->getVar());

        return $this->respond($data);
    }
}
