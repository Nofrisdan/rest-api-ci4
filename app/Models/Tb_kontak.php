<?php

namespace App\Models;

use CodeIgniter\Model;

class Tb_kontak extends Model
{
    protected $table = "base_kontak";
    protected $allowedFields = [
        'nama_kontak',
        'email_kontak',
        'wa_kontak'
    ];
    // protected $useTimestamps = true;

    public function getData($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        } else {
            return $this->where("id_kontak", $id)
                ->first();
        }
    }
}
