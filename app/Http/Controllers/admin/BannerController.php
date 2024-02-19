<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\BannerModel;

class BannerController extends Controller
{
    function __construct()
    {
        $this->banner_model = new BannerModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Banner';
        $data['data'] = $this->banner_model->list_banner();
        return view('admin.banner.index', $data);
    }

    function tambah_banner()
    {     
        $data['title'] = 'Tambah Banner';
        return view('admin.banner.form_tambah', $data);
    }

    function simpan_banner(Request $request)
    {   
        $request->validate([
            'is_active' => 'required',
        ]);
            
        $nama_gambar = '';
        $gambar = $request->file('gambar');
        if($gambar != '')
        {
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/banner'), $nama_gambar);
        }
        
        $data = [
            'gambar' => $nama_gambar,
            'judul' => $request->input('judul'),
            'keterangan' => $request->input('keterangan'),
            'link' => $request->input('link'),
            'button' => $request->input('button'),
            'is_active' => $request->input('is_active'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $q = $this->banner_model->simpan_banner($data);
        if($q)
        {
            return redirect()->route('backend/banner')->with(['success' => 'Data Berhasil Disimpan!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    function edit_banner($id)
    {
        $cek = $this->banner_model->cek_banner($id);
        if($cek)
        {   
            $data['title'] = 'Edit Banner';
            $data['data'] = $this->banner_model->get_banner($id);
            return view('admin.banner.form_edit', $data);
        }else
        {
            abort(404);
        }
    }

    function update_banner(Request $request, $id)
    {   
        $request->validate([
            'is_active' => 'required',
        ]);
            
        $get = $this->banner_model->cek_banner($id);
        $nama_gambar = '';
        $gambar = $request->file('gambar');
        if($gambar != '')
        {
            if($get->gambar == '' OR $get->gambar == null)
            {        
                $nama_gambar = time().'_'.$gambar->hashName();
                $gambar->move(public_path('img/banner'), $nama_gambar);
            }elseif($get->gambar != '' AND $get->gambar != null)
            {
                $nama_gambar = time().'_'.$gambar->hashName();
                $gambar->move(public_path('img/banner'), $nama_gambar);
                unlink("img/banner/$get->gambar");
            }else
            {
                $nama_gambar = '';
            }
        }else
        {
            $nama_gambar = $get->gambar;
        }
        
        $data = [
            'gambar' => $nama_gambar,
            'judul' => $request->input('judul'),
            'keterangan' => $request->input('keterangan'),
            'link' => $request->input('link'),
            'button' => $request->input('button'),
            'is_active' => $request->input('is_active'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $q = $this->banner_model->update_banner($data, $id);
        if($q)
        {
            return redirect()->route('backend/banner')->with(['success' => 'Data Berhasil Diupdate!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    function hapus_banner($id)
    {
        $cek = $this->banner_model->cek_banner($id);
        if($cek)
        {   
            if($cek->gambar != '' AND file_exists("img/banner/$cek->gambar"))
            {
                unlink("img/banner/$cek->gambar");
            }

            $q = $this->banner_model->hapus_banner($id);
            if($q)
            {
                return redirect()->route('backend/banner')->with(['success' => 'Data Berhasil Dihapus!']);
            }else
            {
                return redirect()->route('backend/banner')->with(['errors' => 'Data Gagal Dihapus!']);
            }
        }else
        {
            abort(404);
        }
    } 

}