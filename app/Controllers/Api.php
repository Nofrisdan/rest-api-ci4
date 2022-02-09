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


        // header access
        Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
        Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
        Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); //method allowed

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
    // menggunakan body form-data 
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

        $data = [
            "nama_user" => $this->request->getVar("nama_user"),
            "email" => $this->request->getVar("email"),
            "wa" => $this->request->getVar("wa"),
            "password" => md5($this->request->getVar("password"))
        ];

        // inserting data 
        $insert = $this->tb_user->insert($data, true);

        if (is_numeric($insert)) {
            return $this->respond($this->lib->success("Data Anda Berhasil Ditambahkan"));
        }
    }

    // =============== delete(Delete) ======
    public function delete($id)
    {
        $cek = $this->tb_user->cek_id($id);
        if (!empty($cek)) {
            $delete = $this->tb_user->where("id_user", $id)->delete();

            if ($delete) {
                return $this->respond($this->lib->success("Data Berhasil Dihapus"));
            }
        } else {
            return $this->respond($this->lib->Error("Data Tidak Tersedia"));
        }
    }


    // update data

    // menggunakan body ww-x-urlencode
    public function update()
    {
        // $id = $this->request->getVar("id");

        // validationa
        if (!$this->validate([
            "id" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Parameter tidak lengkap"
                ]
            ],
            "nama_user" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Parameter tidak lengkap"
                ]
            ],
            "email" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Parameter tidak lengkap"
                ]
            ],
            "wa" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Parameter tidak lengkap"
                ]
            ]
        ])) {

            // return $this->respond());
            // $data = $this->lib->Error($this->validasi->getErrors());
            return $this->fail($this->validasi->getErrors());
        }

        // update
        // $id = $this->request->getVar("id");
        $dataUpdate = $this->request->getRawInput();
        $id = $dataUpdate['id'];
        $data = [
            "nama_user" => $dataUpdate['nama_user'],
            "email" => $dataUpdate['email'],
            "wa" => $dataUpdate['wa']
        ];


        $update = $this->tb_user->where("id_user", $id)->set($data)->update();
        if ($update) {
            return $this->respond($this->lib->success("Data dengan id $id Berhasil Diubah"));
        }
        // return $this->respond($this->lib->success($data));
    }
}
