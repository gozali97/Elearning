@extends('layouts.app')

@section('content')

@include('layouts.alerts')
<style>
  img {
    width: 70px;
    border-radius: 10%;
  }
</style>
<div class="col-12 col-lg-12">
  <div class="row">
    <h2 class="mb-2">Daftar Mata Pelajaran</h2>
    @foreach ($data as $d)
    <div class="col-md-4 col-sm-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            <div class="row">
              <div class="col-md-8 col-sm-8">
                <h4 class="card-title">{{ $d->nama_kelas }}</h4>
                <p class="card-text text-truncate">
                  {{$d->deskripsi}}
                </p>
                <p class="card-text">
                  {{$d->nama_mapel}}
                </p>
              </div>
              <div class="col-md-4 mt-4 col-sm-4">
                <img src="{{ url('/assets/img/study.png') }}" alt="">
              </div>
            </div>
            <a href="{{  url('listajar/view', $d->kode_jadwal) }}" class="btn btn-primary mt-2 block d-inline-flex"><i
                class="bi bi-pencil d-inline-flex mt-1"></i></a>
            <a href="{{  url('listajar/listsiswa', $d->kode_mapel) }}"
              class="btn btn-success mt-2 block d-inline-flex"><i class="bi bi-person d-inline-flex mt-1"></i></a>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
