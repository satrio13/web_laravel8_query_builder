<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\KurikulumModel;

class KurikulumController extends Controller
{
    function __construct()
    {
        $this->kurikulum_model = new KurikulumModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Kurikulum';
        $data['data'] = $this->kurikulum_model->list_kurikulum();
        return view('admin.kurikulum.index', $data);
    }

    function tambah_kurikulum()
    {     
        $data['title'] = 'Tambah Kurikulum';
        return view('admin.kurikulum.form_tambah', $data);
    }

    function simpan_kurikulum(Request $request)
    {
        $request->validate([
            'mapel' => 'required|max:50',
            'alokasi' => 'required|numeric',
            'kelompok' => 'required|max:5',
            'no_urut' => 'required|numeric',
            'is_active' => 'required|numeric'
        ]);

        $data = [
            'mapel' => $request->input('mapel'),
            'alokasi' => $request->input('alokasi'),
            'kelompok' => $request->input('kelompok'),
            'no_urut' => $request->input('no_urut'),
            'is_active' => $request->input('is_active'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $q = $this->kurikulum_model->simpan_kurikulum($data);
        if($q)
        {
            return redirect()->route('backend/kurikulum')->with(['success' => 'Data Berhasil Disimpan!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    function edit_kurikulum($id)
    {   
        $cek = $this->kurikulum_model->cek_kurikulum($id);
        if($cek)
        {
            $data['title'] = 'Edit Kurikulum';
            $data['data'] = $this->kurikulum_model->get_kurikulum($id);
            return view('admin.kurikulum.form_edit', $data);
        }else
        {
            abort(404);
        }
    }  

    function update_kurikulum(Request $request, $id)
    {
        $request->validate([
            'mapel' => 'required|max:50',
            'alokasi' => 'required|numeric',
            'kelompok' => 'required|max:5',
            'no_urut' => 'required|numeric',
            'is_active' => 'required|numeric'
        ]);

        $data = [
            'mapel' => $request->input('mapel'),
            'alokasi' => $request->input('alokasi'),
            'kelompok' => $request->input('kelompok'),
            'no_urut' => $request->input('no_urut'),
            'is_active' => $request->input('is_active'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $q = $this->kurikulum_model->update_kurikulum($data, $id);
        if($q)
        {
            return redirect()->route('backend/kurikulum')->with(['success' => 'Data Berhasil Diupdate!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    function hapus_kurikulum($id)
    {   
        $cek = $this->kurikulum_model->cek_kurikulum($id);
        if($cek)
        {
            $q = $this->kurikulum_model->hapus_kurikulum($id);
            if($q)
            {
                return redirect()->route('backend/kurikulum')->with(['success' => 'Data Berhasil Dihapus!']);
            }else
            {
                return redirect()->route('backend/kurikulum')->with(['errors' => 'Data Gagal Dihapus!']);
            }
        }else
        {
            abort(404);
        }
    }  

}