<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\PengaduanModel;

class PengaduanController extends Controller
{
    function __construct()
    {
        $this->pengaduan_model = new PengaduanModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Pengaduan';
        $data['data'] = $this->pengaduan_model->list_pengaduan();
        return view('admin.pengaduan.index', $data);
    }

    function lihat_pengaduan($id)
	{ 
        $cek = $this->pengaduan_model->cek_pengaduan($id);
        if($cek)
        {
            $data = $this->pengaduan_model->get_pengaduan($id);
            echo json_encode($data);
        }else
        {
            abort(404);
        }
    }

    function hapus_pengaduan($id)
    {
        $cek = $this->pengaduan_model->cek_pengaduan($id);
        if($cek)
        {
            $q = $this->pengaduan_model->hapus_pengaduan($id);
            if($q)
            {
                return redirect()->route('backend/pengaduan')->with(['success' => 'Data Berhasil Dihapus!']);
            }else
            {
                return redirect()->route('backend/pengaduan')->with(['errors' => 'Data Gagal Dihapus!']);
            }
        }else
        {
            abort(404);
        }
    }  

}