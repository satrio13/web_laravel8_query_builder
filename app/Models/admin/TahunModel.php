<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class TahunModel
{
    protected $table = 'tb_tahun';

    function list_tahun()
    {
        return DB::table($this->table)->orderBy('id_tahun','desc')->get();
    }

    function cek_tahun($id)
    {
        return DB::table($this->table)->select('id_tahun')->where('id_tahun', $id)->first();
    }

    function get_tahun($id)
    {
        return DB::table($this->table)->where('id_tahun', $id)->first();
    }

    function simpan_tahun($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_tahun($data, $id)
    {
        return DB::table($this->table)->where('id_tahun', $id)->update($data);
    }

    function hapus_tahun($id)
    {
        return DB::table($this->table)->where('id_tahun', $id)->delete();
    }

}