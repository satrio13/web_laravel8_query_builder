@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ekstrakurikuler') }}">Ekstrakurikuler</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-9 text-break">
                <h3><b>{{ $title }}</b></h3>
            </div>
        <div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-9 text-break">
                <div class="row">
                    @if($data->gambar != '' AND file_exists("img/ekstrakurikuler/$data->gambar"))
                        <div class="col-md-12">
                            <a href="/img/ekstrakurikuler/{{ $data->gambar }}" class="image-link">
                                <img src="/img/ekstrakurikuler/{{ $data->gambar }}" class="img img-fluid">
                            </a>
                        </div>
                    @endif
                    <div class="col-md-12">
                        <br>{!! htmlspecialchars_decode($data->keterangan) !!}
                    </div>
                </div>
            </div>
            
            
@endsection