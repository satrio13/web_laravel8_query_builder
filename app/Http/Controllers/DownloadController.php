<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DownloadModel;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    function __construct()
    {
        $this->download_model = new DownloadModel();
    }

    function index()
    {
        $data['titleweb'] = 'Download - '.title();
		$data['title'] = 'Download';
        $data['data'] = $this->download_model->list_download();
        return view('download/index', $data);
    }

    function hits($file)
    {
        $cek = $this->download_model->cek_download($file);
        if($cek)
        {
            $upd = [
                'hits' => $cek->hits + 1
            ];

            $this->download_model->update_dibaca($upd, $file);
            $path = "file/$cek->file";
            if(!file_exists($path))
            {
                return abort(404, 'File not found');
            }else
            {
                return response()->download($path);
            }
        }else
        {
            abort(404);
        }
    }

}