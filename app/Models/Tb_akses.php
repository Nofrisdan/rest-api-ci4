<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class Tb_akses extends Model
{

    protected $table = "tb_akes";
    protected $allowedFields = ['token', 'ip_addres', 'id_user'];
    // protected $useTimestamps = true;

    public function getData($token = false)
    {
        if ($token == false) {
            return $this->select("id_user,token,ip_addres")
                ->findAll();
        } else {
            $this->select("id_user,token,ip_addres")
                ->where("token", $token)
                ->first();
        }
    }


    public function getIdUser($id)
    {
        $data = $this->where("id_user", $id)->first();

        if (!$data) {
            throw new Exception("Data Tidak Tersedia");
        }
        return $data;
    }
}
