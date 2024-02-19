<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SiswaModel;

class SiswaController extends Controller
{
    function __construct()
    {
        $this->siswa_model = new SiswaModel();
    }

    function index()
    {     
        $data['titleweb'] = 'Peserta Didik - '.title();
		$data['title'] = 'Peserta Didik';
        $data['data'] = $this->siswa_model->list_siswa();
        return view('siswa.index', $data);
    }

}