<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AlumniModel;
use App\Models\Admin\TahunModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AlumniController extends Controller
{
    function __construct()
    {
        $this->alumni_model = new AlumniModel();
        $this->tahun_model = new TahunModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Alumni';
        $data['data'] = $this->alumni_model->list_alumni();
        return view('admin.alumni.index', $data);
    }

    function tambah_alumni()
    {     
        $data['title'] = 'Tambah Alumni';
        $data['tahun'] = $this->tahun_model->list_tahun();
        return view('admin.alumni.form_tambah', $data);
    }

    function simpan_alumni(Request $request)
    {
        $request->validate([
            'id_tahun' => 'required|numeric',
            'jml_l' => 'required|numeric',
            'jml_p' => 'required|numeric',
        ]);

        $data = [
            'id_tahun' => $request->input('id_tahun'),
            'jml_l' => $request->input('jml_l'),
            'jml_p' => $request->input('jml_p'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $q = $this->alumni_model->simpan_alumni($data);
        if($q)
        {
            return redirect()->route('backend/alumni')->with(['success' => 'Data Berhasil Disimpan!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    function edit_alumni($id)
    {   
        $cek = $this->alumni_model->cek_alumni($id);
        if($cek)
        {
            $data['title'] = 'Edit Alumni';
            $data['data'] = $this->alumni_model->get_alumni($id);
            $data['tahun'] = $this->tahun_model->list_tahun();
            return view('admin.alumni.form_edit', $data);
        }else
        {
            abort(404);
        }
    } 

    function update_alumni(Request $request, $id)
    {
        $request->validate([
            'id_tahun' => 'required|numeric',
            'jml_l' => 'required|numeric',
            'jml_p' => 'required|numeric',
        ]);

        $data = [
            'id_tahun' => $request->input('id_tahun'),
            'jml_l' => $request->input('jml_l'),
            'jml_p' => $request->input('jml_p'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $q = $this->alumni_model->update_alumni($data, $id);
        if($q)
        {
            return redirect()->route('backend/alumni')->with(['success' => 'Data Berhasil Diupdate!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    function hapus_alumni($id)
    {   
        $cek = $this->alumni_model->cek_alumni($id);
        if($cek)
        {
            $q = $this->alumni_model->hapus_alumni($id);
            if($q)
            {
                return redirect()->route('backend/alumni')->with(['success' => 'Data Berhasil Dihapus!']);
            }else
            {
                return redirect()->route('backend/alumni')->with(['error' => 'Data Gagal Dihapus!']);
            }
        }else
        {
            abort(404);
        }
    } 

    function penelusuran_alumni()
    {     
        $data['title'] = 'Penelusuran Alumni';
        $data['data'] = $this->alumni_model->list_isialumni();
        return view('admin.alumni.penelusuran_alumni', $data);
    }

    function lihat_alumni($id)
	{ 
        $data = $this->alumni_model->get_isialumni($id);
        return response()->json($data);  
    }

    function status($id)
	{ 
        $data = $this->alumni_model->get_isialumni($id);
        return response()->json($data);  
    }

    function save_status(Request $request)
	{   
        $id = $request->input('id');
        
        $data = [
            'status' => $request->input('status')
        ];

        $q = $this->alumni_model->update_isialumni($data, $id);
        return response()->json($q);  	
    }

    function hapus_penelusuran_alumni($id)
    {
        $cek = $this->alumni_model->cek_isialumni($id);
        if($cek)
        {   
            if(File::exists("img/alumni/$cek->gambar"))
            {
                File::delete("img/alumni/$cek->gambar");
            }

            $q = $this->alumni_model->hapus_isialumni($id);
            if($q)
            {
                return redirect()->route('backend/penelusuran-alumni')->with(['success' => 'Data Berhasil Dihapus!']);
            }else
            {
                return redirect()->route('backend/penelusuran-alumni')->with(['error' => 'Data Gagal Dihapus!']);
            }
        }else
        {
            abort(404);
        }
    }  

}