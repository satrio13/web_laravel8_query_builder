<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class ProfilModel
{
    protected $table = 'tb_profil';

    function get_profil($select = '*')
    {
        return DB::table($this->table)->select($select)->find(1);
    }

    function update_profil($data)
    {
        return DB::table($this->table)->where('id', 1)->update($data);
    }

}