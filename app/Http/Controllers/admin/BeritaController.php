<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\BeritaModel;

class BeritaController extends Controller
{
    function __construct()
    {
        $this->berita_model = new BeritaModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Berita';
        $data['data'] = $this->berita_model->list_berita();
        return view('admin.berita.index', $data);
    }

    function tambah_berita()
    {     
        $data['title'] = 'Tambah Berita';
        return view('admin.berita.form_tambah', $data);
    }

    function simpan_berita(Request $request)
    {   
        $request->validate([
            'nama' => 'required|max:100',
            'isi' => 'required',
            'is_active' => 'required',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
            
        $nama_gambar = '';
        $gambar = $request->file('gambar');
        if($gambar != '')
        {
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/berita'), $nama_gambar);
        }
        
        $data = [
            'nama' => $request->input('nama'),
            'isi' => $request->input('isi'),
            'gambar' => $nama_gambar,
            'dibaca' => 0,
            'id_user' => session('id_user'),
            'is_active' => $request->input('is_active'),
            'hari' => hari_ini_indo(),
            'tgl' => tgl_jam_simpan_sekarang(),
            'slug' => slug($request->input('nama')),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $q = $this->berita_model->simpan_berita($data);
        if($q)
        {
            return redirect()->route('backend/berita')->with(['success' => 'Data Berhasil Disimpan!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    function edit_berita($id)
    {
        $cek = $this->berita_model->cek_berita($id);
        if($cek)
        {   
            $data['title'] = 'Edit Berita';
            $data['data'] = $this->berita_model->get_berita($id);
            return view('admin.berita.form_edit', $data);
        }else
        {
            abort(404);
        }
    }

    function update_berita(Request $request, $id)
    {   
        $request->validate([
            'nama' => 'required|max:100',
            'isi' => 'required',
            'is_active' => 'required',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
            
        $get = $this->berita_model->cek_berita($id);
        $nama_gambar = '';
        $gambar = $request->file('gambar');
        if($gambar != '')
        {
            if($get->gambar == '' OR $get->gambar == null)
            {        
                $nama_gambar = time().'_'.$gambar->hashName();
                $gambar->move(public_path('img/berita'), $nama_gambar);
            }elseif($get->gambar != '' AND $get->gambar != null)
            {
                $nama_gambar = time().'_'.$gambar->hashName();
                $gambar->move(public_path('img/berita'), $nama_gambar);
                unlink("img/berita/$get->gambar");
            }else
            {
                $nama_gambar = '';
            }
        }else
        {
            $nama_gambar = $get->gambar;
        }
        
        $data = [
            'nama' => $request->input('nama'),
            'isi' => $request->input('isi'),
            'gambar' => $nama_gambar,
            'id_user' => session('id_user'),
            'is_active' => $request->input('is_active'),
            'hari' => hari_ini_indo(),
            'tgl' => tgl_jam_simpan_sekarang(),
            'slug' => slug($request->input('nama')),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $q = $this->berita_model->update_berita($data, $id);
        if($q)
        {
            return redirect()->route('backend/berita')->with(['success' => 'Data Berhasil Diupdate!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    function hapus_berita($id)
    {
        $cek = $this->berita_model->cek_berita($id);
        if($cek)
        {   
            if($cek->gambar != '' AND file_exists("img/berita/$cek->gambar"))
            {
                unlink("img/berita/$cek->gambar");
            }

            $q = $this->berita_model->hapus_berita($id);
            if($q)
            {
                return redirect()->route('backend/berita')->with(['success' => 'Data Berhasil Dihapus!']);
            }else
            {
                return redirect()->route('backend/berita')->with(['errors' => 'Data Gagal Dihapus!']);
            }
        }else
        {
            abort(404);
        }
    }  

}