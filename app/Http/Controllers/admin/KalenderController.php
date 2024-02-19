<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\KalenderModel;

class KalenderController extends Controller
{
    function __construct()
    {
        $this->kalender_model = new KalenderModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Kalender';
        $data['data'] = $this->kalender_model->get_kalender();
        return view('admin.kalender.index', $data);
    }

    function update_kalender(Request $request)
    {   
        $request->validate([
            'file' => 'max:5120'
        ]);
            
        $get = $this->kalender_model->get_kalender();
        $nama_gambar = '';
        $gambar = $request->file('file');
        if($gambar != '')
        {
            if($get->kalender == '' OR $get->kalender == null)
            {        
                $nama_gambar = time().'_'.$gambar->getClientOriginalName();
                $gambar->move(public_path('img/kalender'), $nama_gambar);
            }elseif($get->kalender != '' AND $get->kalender != null)
            {
                $nama_gambar = time().'_'.$gambar->getClientOriginalName();
                $gambar->move(public_path('img/kalender'), $nama_gambar);
                unlink("img/kalender/$get->kalender");
            }else
            {
                $nama_gambar = '';
            }
        }else
        {
            $nama_gambar = $get->kalender;
        }
        
        $data = [
            'kalender' => $nama_gambar,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $q = $this->kalender_model->update_kalender($data);
        if($q)
        {
            return redirect()->route('backend/kalender')->with(['success' => 'Data Berhasil Diupdate!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    
}