<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\ProfilModel;

class ProfilController extends Controller
{
    function __construct()
    {
        $this->profil_model = new ProfilModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Profil Website';
        $data['data'] = $this->profil_model->get_profil('*');
        return view('admin.profil.index', $data);
    }

    function edit_profil_web()
    {
        $data['title'] = 'Edit Profil Website';
        $data['data'] = $this->profil_model->get_profil('*');
        return view('admin.profil.form_profil', $data);
    }

    function update_profil_web(Request $request)
    {
        $request->validate([
            'nama_web' => 'required|max:100',
            'jenjang' => 'required|numeric',
            'meta_description' => 'required|max:300',
            'meta_keyword' => 'required|max:200',
            'alamat' => 'required|max:300',
            'email' => 'required|email|max:100',
            'telp' => 'required|max:20',
            'fax' => 'required|max:20',
            'whatsapp' => 'max:20',
            'akreditasi' => 'max:5',
            'kurikulum' => 'required|max:30',
            'nama_kepsek' => 'required|max:100',
            'nama_operator' => 'required|max:100',
            'instagram' => 'max:200',
            'facebook' => 'max:200',
            'twitter' => 'max:200',
            'youtube' => 'max:200'
        ]);
        
        $data = [
            'nama_web' => $request->input('nama_web'),
            'jenjang' => $request->input('jenjang'),
            'meta_description' => $request->input('meta_description'),
            'meta_keyword' => $request->input('meta_keyword'),
            'profil' => $request->input('profil'),
            'alamat' => $request->input('alamat'),
            'email' => $request->input('email'),
            'telp' => $request->input('telp'),
            'fax' => $request->input('fax'),
            'whatsapp' => $request->input('whatsapp'),
            'akreditasi' => $request->input('akreditasi'),
            'kurikulum' => $request->input('kurikulum'),
            'nama_kepsek' => $request->input('nama_kepsek'),
            'nama_operator' => $request->input('nama_operator'),
            'instagram' => $request->input('instagram'),
            'facebook' => $request->input('facebook'),
            'twitter' => $request->input('twitter'),
            'youtube' => $request->input('youtube'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $q = $this->profil_model->update_profil($data);
        if($q)
        {
            return redirect()->route('backend/profil-web')->with(['success' => 'Data Berhasil Disimpan!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    function logo_web()
    {
        $data['title'] = 'Edit Logo Website';
        $data['data'] = $this->profil_model->get_profil('logo_web');
        return view('admin.profil.form_logo_web', $data);
    }

    function update_logo_web(Request $request)
    {
        $request->validate([
            'logo_web' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
        
        $get = $this->profil_model->get_profil('logo_web');
        $gambar = $request->file('logo_web');
        $nama_gambar = '';
        if($gambar != '')
        {
            if($get->logo_web == '' OR $get->logo_web == null)
            {
                $nama_gambar = time().'_'.$gambar->hashName();
                $gambar->move(public_path('img/logo'), $nama_gambar);
            }elseif($get->logo_web != '' AND $get->logo_web != null)
            {
                $nama_gambar = time().'_'.$gambar->hashName();
                $gambar->move(public_path('img/logo'), $nama_gambar);
                if(file_exists("img/logo/$get->logo_web"))
                {
                    unlink("img/logo/$get->logo_web");
                }
            }else
            {
                $nama_gambar = '';
            }
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Anda belum memilih file yang akan diupload!']);
        }

        $data = [
            'logo_web' => $nama_gambar
        ];
        
        $q = $this->profil_model->update_profil($data);
        if($q)
        {
            return redirect()->route('backend/profil-web')->with(['success' => 'Data Berhasil Diupdate!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'File Gagal Diupdate, silahkan coba lagi!']);
        }
    }

    function favicon()
    {
        $data['title'] = 'Edit Favicon';
        $data['data'] = $this->profil_model->get_profil('favicon');
        return view('admin.profil.form_favicon', $data);
    }

    function update_favicon(Request $request)
    {
        $request->validate([
            'favicon' => 'max:100'
        ]);
        
        $get = $this->profil_model->get_profil('favicon');
        $gambar = $request->file('favicon');
        $nama_gambar = '';
        if($gambar != '')
        {
            if($get->favicon == '' OR $get->favicon == null)
            {
                $nama_gambar = time().'_'.$gambar->hashName();
                $gambar->move(public_path('img/logo'), $nama_gambar);
            }elseif($get->favicon != '' AND $get->favicon != null)
            {
                $nama_gambar = time().'_'.$gambar->hashName();
                $gambar->move(public_path('img/logo'), $nama_gambar);
                if(file_exists("img/logo/$get->favicon"))
                {
                    unlink("img/logo/$get->favicon");
                }
            }else
            {
                $nama_gambar = '';
            }
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Anda belum memilih file yang akan diupload!']);
        }

        $data = [
            'favicon' => $nama_gambar
        ];
        
        $q = $this->profil_model->update_profil($data);
        if($q)
        {
            return redirect()->route('backend/profil-web')->with(['success' => 'Data Berhasil Diupdate!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'File Gagal Diupdate, silahkan coba lagi!']);
        }
    }

    function logo_admin()
    {
        $data['title'] = 'Edit Logo Login Admin';
        $data['data'] = $this->profil_model->get_profil('logo_admin');
        return view('admin.profil.form_logo_admin', $data);
    }

    function update_logo_admin(Request $request)
    {
        $request->validate([
            'logo_admin' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
        
        $get = $this->profil_model->get_profil('logo_admin');
        $gambar = $request->file('logo_admin');
        $nama_gambar = '';
        if($gambar != '')
        {
            if($get->logo_admin == '' OR $get->logo_admin == null)
            {
                $nama_gambar = time().'_'.$gambar->hashName();
                $gambar->move(public_path('img/logo'), $nama_gambar);
            }elseif($get->logo_admin != '' AND $get->logo_admin != null)
            {
                $nama_gambar = time().'_'.$gambar->hashName();
                $gambar->move(public_path('img/logo'), $nama_gambar);
                if(file_exists("img/logo/$get->logo_admin"))
                {
                    unlink("img/logo/$get->logo_admin");
                }
            }else
            {
                $nama_gambar = '';
            }
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Anda belum memilih file yang akan diupload!']);
        }

        $data = [
            'logo_admin' => $nama_gambar
        ];
        
        $q = $this->profil_model->update_profil($data);
        if($q)
        {
            return redirect()->route('backend/profil-web')->with(['success' => 'Data Berhasil Diupdate!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'File Gagal Diupdate, silahkan coba lagi!']);
        }
    }

    function gambar_profil()
    {
        $data['title'] = 'Edit Gambar Profil';
        $data['data'] = $this->profil_model->get_profil('gambar');
        return view('admin.profil.form_gambar_profil', $data);
    }

    function update_gambar_profil(Request $request)
    {
        $request->validate([
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
        
        $get = $this->profil_model->get_profil('gambar');
        $gambar = $request->file('gambar');
        $nama_gambar = '';
        if($gambar != '')
        {
            if($get->gambar == '' OR $get->gambar == null)
            {
                $nama_gambar = time().'_'.$gambar->hashName();
                $gambar->move(public_path('img/logo'), $nama_gambar);
            }elseif($get->gambar != '' AND $get->gambar != null)
            {
                $nama_gambar = time().'_'.$gambar->hashName();
                $gambar->move(public_path('img/logo'), $nama_gambar);
                if(file_exists("img/logo/$get->gambar"))
                {
                    unlink("img/logo/$get->gambar");
                }
            }else
            {
                $nama_gambar = '';
            }
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Anda belum memilih file yang akan diupload!']);
        }

        $data = [
            'gambar' => $nama_gambar
        ];
        
        $q = $this->profil_model->update_profil($data);
        if($q)
        {
            return redirect()->route('backend/profil-web')->with(['success' => 'Data Berhasil Diupdate!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'File Gagal Diupdate, silahkan coba lagi!']);
        }
    }

    function file()
    {
        $data['title'] = 'Edit File';
        $data['data'] = $this->profil_model->get_profil('file');
        return view('admin.profil.form_file', $data);
    }

    function update_file(Request $request)
    {
        $request->validate([
            'file' => 'mimes:pdf|max:5120'
        ]);
        
        $get = $this->profil_model->get_profil('file');
        $file = $request->file('file');
        $nama_file = '';
        if($file != '')
        {
            if($get->file == '' OR $get->file == null)
            {
                $nama_file = time().'_'.$file->hashName();
                $file->move(public_path('file'), $nama_file);
            }elseif($get->file != '' AND $get->file != null)
            {
                $nama_file = time().'_'.$file->hashName();
                $file->move(public_path('file'), $nama_file);
                if(file_exists("file/$get->file"))
                {
                    unlink("file/$get->file");
                }
            }else
            {
                $nama_file = '';
            }
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Anda belum memilih file yang akan diupload!']);
        }

        $data = [
            'file' => $nama_file
        ];
        
        $q = $this->profil_model->update_profil($data);
        if($q)
        {
            return redirect()->route('backend/profil-web')->with(['success' => 'Data Berhasil Diupdate!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'File Gagal Diupdate, silahkan coba lagi!']);
        }
    }

}