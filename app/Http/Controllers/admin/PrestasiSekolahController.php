<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\PrestasiSekolahModel;
use App\Models\Admin\TahunModel;

class PrestasiSekolahController extends Controller
{
    function __construct()
    {
        $this->prestasi_sekolah_model = new PrestasiSekolahModel();
        $this->tahun_model = new TahunModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Prestasi Sekolah';
        $data['data'] = $this->prestasi_sekolah_model->list_prestasi_sekolah();
        return view('admin.prestasi_sekolah.index', $data);
    }

    function tambah_prestasi_sekolah()
    {     
        $data['title'] = 'Tambah Prestasi Sekolah';
        $data['tahun'] = $this->tahun_model->list_tahun();
        return view('admin.prestasi_sekolah.form_tambah', $data);
    }

    function simpan_prestasi_sekolah(Request $request)
    {   
        $request->validate([
            'id_tahun' => 'required|numeric',
            'jenis' => 'required|numeric',
            'nama' => 'required|max:100',
            'prestasi' => 'required|max:100',
            'tingkat' => 'required|numeric',
            'keterangan' => 'max:100',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
            
        $nama_gambar = '';
        $gambar = $request->file('gambar');
        if($gambar != '')
        {
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/prestasi_sekolah'), $nama_gambar);
        }
        
        $data = [
            'id_tahun' => $request->input('id_tahun'),
            'nama' => $request->input('nama'),
            'prestasi' => $request->input('prestasi'),
            'tingkat' => $request->input('tingkat'),
            'jenis' => $request->input('jenis'),
            'keterangan' => $request->input('keterangan'),
            'gambar' => $nama_gambar,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $q = $this->prestasi_sekolah_model->simpan_prestasi_sekolah($data);
        if($q)
        {
            return redirect()->route('backend/prestasi-sekolah')->with(['success' => 'Data Berhasil Disimpan!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit_prestasi_sekolah($id)
    {   
        $cek = $this->prestasi_sekolah_model->cek_prestasi_sekolah($id);
        if($cek)
        {
            $data['title'] = 'Edit Prestasi Sekolah';
            $data['data'] = $this->prestasi_sekolah_model->get_prestasi_sekolah($id);
            $data['tahun'] = $this->tahun_model->list_tahun();
            return view('admin.prestasi_sekolah.form_edit', $data);
        }else
        {
            abort(404);
        }
    }

    function update_prestasi_sekolah(Request $request, $id)
    {   
        $request->validate([
            'id_tahun' => 'required|numeric',
            'jenis' => 'required|numeric',
            'nama' => 'required|max:100',
            'prestasi' => 'required|max:100',
            'tingkat' => 'required|numeric',
            'keterangan' => 'max:100',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
            
        $get = $this->prestasi_sekolah_model->cek_prestasi_sekolah($id);
        $nama_gambar = '';
        $gambar = $request->file('gambar');
        if($gambar != '')
        {
            if($get->gambar == '' OR $get->gambar == null)
            {        
                $nama_gambar = time().'_'.$gambar->hashName();
                $gambar->move(public_path('img/prestasi_sekolah'), $nama_gambar);
            }elseif($get->gambar != '' AND $get->gambar != null)
            {
                $nama_gambar = time().'_'.$gambar->hashName();
                $gambar->move(public_path('img/prestasi_sekolah'), $nama_gambar);
                unlink("img/prestasi_sekolah/$get->gambar");
            }else
            {
                $nama_gambar = '';
            }
        }else
        {
            $nama_gambar = $get->gambar;
        }
        
        $data = [
            'id_tahun' => $request->input('id_tahun'),
            'nama' => $request->input('nama'),
            'prestasi' => $request->input('prestasi'),
            'tingkat' => $request->input('tingkat'),
            'jenis' => $request->input('jenis'),
            'keterangan' => $request->input('keterangan'),
            'gambar' => $nama_gambar,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $q = $this->prestasi_sekolah_model->update_prestasi_sekolah($data, $id);
        if($q)
        {
            return redirect()->route('backend/prestasi-sekolah')->with(['success' => 'Data Berhasil Diupdate!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function hapus_prestasi_sekolah($id)
    {   
        $cek = $this->prestasi_sekolah_model->cek_prestasi_sekolah($id);
        if($cek)
        {
            if($cek->gambar != '' AND file_exists("img/prestasi_sekolah/$cek->gambar"))
            {
                unlink("img/prestasi_sekolah/$cek->gambar");
            }

            $q = $this->prestasi_sekolah_model->hapus_prestasi_sekolah($id);
            if($q)
            {
                return redirect()->route('backend/prestasi-sekolah')->with(['success' => 'Data Berhasil Dihapus!']);
            }else
            {
                return redirect()->route('backend/prestasi-sekolah')->with(['errors' => 'Data Gagal Dihapus!']);
            }
        }else
        {
            abort(404);
        }
    }

}