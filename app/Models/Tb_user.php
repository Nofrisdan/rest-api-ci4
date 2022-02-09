<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class Tb_user extends Model
{

    protected $table = "tb_user";
    protected $allowedFields = [
        'nama_user',
        'email',
        'wa',
        'password'
    ];


    // protected $useTimestamps = true;
    public function getData($id = false)
    {
        if ($id == false) {
            return $this->select("nama_user,email,wa")->findAll();
        } else {
            return $this->where("id_user", $id)
                ->first();
        }
    }

    public function cek_id($id)
    {
        return $this->where("id_user", $id)->first();
    }

    public function cekEmail($email)
    {
        $data = $this->select("id_user")->where("email", $email)->first();

        if (empty($data)) {
            return false;
        }

        return $data['id_user'];
    }
}
