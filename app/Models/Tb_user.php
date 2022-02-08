<?php

namespace App\Models;

use CodeIgniter\Model;


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
}
