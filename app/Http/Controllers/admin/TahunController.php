<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\TahunModel;

class TahunController extends Controller
{
    function __construct()
    {
        $this->tahun_model = new TahunModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Tahun Akademik';
        $data['data'] = $this->tahun_model->list_tahun();
        return view('admin.tahun.index', $data);
    }

    function tambah_tahun()
    {     
        $data['title'] = 'Tambah Tahun Akademik';
        return view('admin.tahun.form_tambah', $data);
    }

    function simpan_tahun(Request $request)
    {
        $request->validate([
            'tahun' => 'required|max:10'
        ]);

        $data = [
            'tahun' => $request->input('tahun'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $q = $this->tahun_model->simpan_tahun($data);
        if($q)
        {
            return redirect()->route('backend/tahun')->with(['success' => 'Data Berhasil Disimpan!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    function edit_tahun($id)
    {   
        $cek = $this->tahun_model->cek_tahun($id);
        if($cek)
        {
            $data['title'] = 'Edit Tahun Akademik';
            $data['data'] = $this->tahun_model->get_tahun($id);
            return view('admin.tahun.form_edit', $data);
        }else
        {
            abort(404);
        }
    }  

    function update_tahun(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required|max:10'
        ]);

        $data = [
            'tahun' => $request->input('tahun'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $q = $this->tahun_model->update_tahun($data, $id);
        if($q)
        {
            return redirect()->route('backend/tahun')->with(['success' => 'Data Berhasil Diupdate!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    function hapus_tahun($id)
    {
        $cek = $this->tahun_model->cek_tahun($id);
        if($cek)
        {
            $q = $this->tahun_model->hapus_tahun($id);
            if($q)
            {
                return redirect()->route('backend/tahun')->with(['success' => 'Data Berhasil Dihapus!']);
            }else
            {
                return redirect()->route('backend/tahun')->with(['errors' => 'Data Gagal Dihapus!']);
            }
        }else
        {
            abort(404);
        }
    }  
    
}