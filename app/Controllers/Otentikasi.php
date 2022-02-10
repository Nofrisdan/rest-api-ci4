<?php

namespace App\Controllers;

use App\Models\Tb_user;
use App\Models\Tb_kontak;
use App\Controllers\BaseController;
use App\Models\Tb_akses;
use App\Libraries\Respon;
use CodeIgniter\API\ResponseTrait;
use Config\Services;

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

    // public function index()
    // {
    //     $data = $this->lib->success($this->tb_user->findAll());

    //     return $this->respond($data);
    // }

    public function registrasi()
    {
        // validasi
        if (!$this->validate([
            "nama_user" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Paramater Tidak Terpenuhi"
                ]
            ],
            "email" => [
                "rules" => "required|valid_email|is_unique[tb_user.email]",
                "errors" => [
                    "required" => "Paramater Tidak Terpenuhi",
                    "valid_email" => "Email Tidak Valid",
                    "is_unique" => "Email Sudah Terdaftar, Silahkan Login"
                ]
            ],
            "wa" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Paramater Tidak Terpenuhi"
                ]
            ],
            "password" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Paramater Tidak Terpenuhi"
                ]
            ],

        ])) {

            return $this->fail(Services::validation()->getErrors());
        }

        // create data
        $data = [
            'nama_user' => $this->request->getVar("nama_user"),
            'email' => $this->request->getVar("email"),
            'wa' => $this->request->getVar("wa"),
            'password' => md5($this->request->getVar("password"))
        ];

        $insert = $this->tb_user->insert($data, true);

        if (is_numeric($insert)) {
            $data = $this->lib->success("Akun Berhasil Terdaftar");
            return $this->respond($data);
        }
    }


    public function login()
    {
        $email = $this->request->getVar("email");
        $pass = $this->request->getVar("password");

        // get data 
        $user = $this->tb_user->select("id_user,email,password")
            ->where("email", $email)
            ->first();

        // cek apakah email yang dimasukkan terdaftar
        if (!empty($user)) {

            // cek pass
            if (md5($pass) == $user['password']) {

                // cek apakah id_user tersedia di tb_akses jika tersedia kembalikan token
                if ($this->tb_akses->cek_id_user($user['id_user']) == true) { // id user tidak tersedia
                    // load helper jwt
                    helper("jwt");

                    // insert to tb_akses
                    $data = [
                        'token' => createJWT($email),
                        'ip_addres' => $this->lib->getIPAddress(),
                        'id_user' => $user['id_user']
                    ];
                    $this->tb_akses->insert($data);
                    return $this->respond($this->lib->success($data));
                } else {
                    $data = $this->lib->success($this->tb_akses->cek_id_user($user['id_user']));

                    return $this->respond($data);
                }
            } else {
                // forbidden
                return $this->failForbidden("Anda Tidak Memiliki Akses");
            }
        } else {
            // error
            return $this->failNotFound("Akun Anda Tidak Terdaftar");
        }
    }
}
