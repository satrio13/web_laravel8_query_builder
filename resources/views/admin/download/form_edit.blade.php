@extends('admin.layouts.app')
@section('content')
    @php
        $is_active = old('is_active') ?? $data->is_active;
    @endphp
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('backend') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend/download') }}">Download</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="row">
                <div class="col-12">
                    @if(session('error'))
                        {!! pesan_gagal(session('error')) !!}
                    @endif
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">FORM {{ strtoupper($title) }}</h3>
                        </div>
                        <form method="POST" action="{{ route('backend/update-download', $data->id) }}" enctype="multipart/form-data" id="form">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">NAMA FILE <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" name="nama_file" maxlength="100" value="{{ old('nama_file', $data->nama_file) }}" class="form-control" placeholder="NAMA FILE" required>
                                        <small class="text-danger">
                                            {{ ($errors->first('nama_file')) ? $errors->first('nama_file') : '' }}
                                        </small>
                                        <br>
                                        File Sekarang : <small><a href="/file/{{ $data->file }}" target="_blank">{{ $data->file }}</a></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">FILE <span class="text-danger">*</span></label>
                                    <div class="col-sm-5">
                                        <input type='file' class='form-control' name='file'>
                                        <small class="text-danger"> *) FORMAT FILE: JPG/JPEG/PNG/PDF/XLS/XLSX/PPT/DOCX/RAR/ZIP max 7 MB</small>
                                        <small class="text-danger">
                                            {{ ($errors->first('file')) ? $errors->first('file') : '' }}
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">STATUS AKTIF <span class="text-danger">*</span></label>
                                    <div class="col-sm-5">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="is_active" value="1" id="radioPrimary1" {{ ($is_active == '1') ? 'checked' : '' }} required> 
                                            <label for="radioPrimary1">Aktif</label> 
                                            &nbsp;&nbsp;&nbsp; 
                                        </div>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="is_active" value="0" id="radioPrimary2" {{ ($is_active == '0') ? 'checked' : '' }} required> 
                                            <label for="radioPrimary2">Non Aktif</label>
                                        </div>
                                        <br><label for="is_active" class="error"></label>
                                        <small class="text-danger">
                                            {{ ($errors->first('is_active')) ? $errors->first('is_active') : '' }}
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <span class="text-danger"><b>*</b></span>) Field Wajib Diisi
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" name="submit" value="Submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> SIMPAN</button>
                                <a href="{{ route('backend/download') }}" class="btn btn-danger btn-sm float-right"><i class="fa fa-arrow-left"></i> BATAL</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            handle_validate();
        });

        function handle_validate()
        {
            $("#form").validate();
        }
    </script>
@endsection