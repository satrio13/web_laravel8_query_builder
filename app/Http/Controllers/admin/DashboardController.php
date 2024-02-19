<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\AlumniModel;

class DashboardController extends Controller
{
    function __construct()
    {   
        $this->alumni_model = new AlumniModel();
    }

    function index()
    {
        $data['title'] = 'Hasil Penelusuran Alumni';
        $data['data'] = $this->alumni_model->list_isialumni();
        return view('admin.alumni.penelusuran_alumni', $data);
    }
    
}