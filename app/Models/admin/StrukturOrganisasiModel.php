<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class StrukturOrganisasiModel
{
    protected $table = 'tb_struktur_organisasi';

    function get_struktur_organisasi()
    {
        return DB::table($this->table)->find(1);
    }

    function update_struktur_organisasi($data)
    {
        return DB::table($this->table)->where('id', 1)->update($data);
    }

}