@extends('admin.layouts.app')
@section('content')
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
                            <li class="breadcrumb-item"><a href="{{ route('backend/link') }}">Link Terkait</a></li>
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
                        <form method="POST" action="{{ route('backend/simpan-link') }}" id="form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">NAMA HALAMAN <span class="text-danger">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="text" name="nama" maxlength="100" value="{{ old('nama') }}" class="form-control" placeholder="NAMA HALAMAN" required>
                                        <small class="text-danger">
                                            {{ ($errors->first('nama')) ? $errors->first('nama') : '' }} 
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">LINK URL <span class="text-danger">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="url" name="link" value="{{ old('link') }}" class="form-control" placeholder="LINK URL" required>
                                        <small class="text-danger">
                                            {{ ($errors->first('link')) ? $errors->first('link') : '' }} 
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">STATUS AKTIF <span class="text-danger">*</span></label>
                                    <div class="col-sm-5">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="is_active" value="1" id="radioPrimary1" {{ old('is_active') == '1' ? 'checked' : '' }} required> 
                                            <label for="radioPrimary1">Aktif</label> 
                                            &nbsp;&nbsp;&nbsp; 
                                        </div>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="is_active" value="0" id="radioPrimary2" {{ old('is_active') == '0' ? 'checked' : '' }} required> 
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
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> SIMPAN</button>
                                <a href="{{ route('backend/link') }}" class="btn btn-danger btn-sm float-right"><i class="fa fa-arrow-left"></i> BATAL</a>
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