<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
// db
// use App\Models\Tb_user;
use App\Models\Tb_kontak;

// library
use App\Libraries\Respon;

class Api extends BaseController
{
    use ResponseTrait;
    protected $tb_kontak, $lib, $validasi;
    public function __construct()
    {
        $this->tb_kontak = new Tb_kontak();
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
        $data = $this->lib->success($this->tb_kontak->findAll());

        return $this->respond($data);
    }

    public function find($id)
    {
        $data = $this->lib->success($this->tb_kontak->where("id_kontak", $id)->first());

        return $this->respond($data);
    }


    // ================== end======================


    // ============= CREATE ==================
    // menggunakan body form-data 
    public function create()
    {

        // validation
        if (!$this->validate([
            "nama_kontak" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Harap Masukkan Parameter Nama kontak"
                ]
            ],
            "email" => [
                "rules" => "required|is_unique[base_kontak.email_kontak]",
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
        ])) {

            $data = $this->lib->Error($this->validasi->getErrors());

            return  $this->respond($data);
        }

        $data = [
            "nama_kontak" => $this->request->getVar("nama_kontak"),
            "email_kontak" => $this->request->getVar("email"),
            "wa_kontak" => $this->request->getVar("wa")
        ];

        // inserting data 
        $insert = $this->tb_kontak->insert($data, true);

        if (is_numeric($insert)) {
            return $this->respond($this->lib->success("Data Anda Berhasil Ditambahkan"));
        }
    }

    // =============== delete(Delete) ======
    public function delete($id)
    {
        $cek = $this->tb_kontak->cek_id($id);
        if (!empty($cek)) {
            $delete = $this->tb_kontak->where("id_kontak", $id)->delete();

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
            "nama_kontak" => [
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

        // cek apakah data dengan id tersebut sudah terdaftar
        $data_exists = $this->tb_kontak->where("id_kontak", $id)->first();

        if (!empty($data_exists)) {
            $data = [
                "nama_kontak" => $dataUpdate['nama_kontak'],
                "email" => $dataUpdate['email'],
                "wa" => $dataUpdate['wa']
            ];


            $update = $this->tb_kontak->where("id_kontak", $id)->set($data)->update();
            if ($update) {
                return $this->respond($this->lib->success("Data dengan id $id Berhasil Diubah"));
            }
        } else {
            return $this->failNotFound("Data Tidak Tersedia");
        }

        // return $this->respond($this->lib->success($data));
    }
}
