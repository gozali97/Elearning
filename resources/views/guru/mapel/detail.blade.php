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
        <div class="col-12">
            <a href="/listajar" class="btn btn sm btn-outline-secondary d-inline-flex mb-3"><i class="bi bi-arrow-left mt-1 d-inline-flex"></i>Kembali</a>
            <div class="card">
                <div class="card-header">
                    <h4 class="d-inline-flex">Daftar Materi - {{ $jadwal->nama_mapel }}</h4>

                    <button data-bs-toggle="modal" data-bs-target="#insertModal"
                        class="btn btn-success d-inline-flex float-end">Tambah Materi</button>
                </div>
                <div class="card-body">
                    @foreach ($data as $index => $d)
                    <div class="mt-4">
                        <h5 class="d-inline-flex fw-bold">{{ $d->nama_materi }}</h5>
                        <div class="float-end">
                            <button type="button" class="btn btn-sm btn-outline-danger d-inline-flex"
                                onclick="event.preventDefault(); confirmDelete('{{ $d->id_materi }}');"><i
                                    class="bi bi-trash-fill"></i></button>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#viewModal{{ $d->id_materi }}"
                                class="btn btn-sm mx-1 btn-outline-primary d-inline-flex float-end"><i
                                    class="bi bi-pencil my-0.5"></i></button>
                        </div>
                        <p class="text-muted">
                            {{ $d->deskripsi }}
                        </p>
                        <a href="{{ asset('assets/dokumen/' . $d->path_file) }}" download>Download Materi</a>
                        <div class="buttons mt-2">
                            @if($d->id_tugas)
                            <a href="#" class="btn btn-info d-inline-flex align-items-center"><i class="bi bi-info-circle-fill me-1"></i>Lihat Tugas</a>
                        @else
                            <button type="button" class="btn btn-primary d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#tugasModal{{ $d->id_materi }}"><i class="bi bi-clipboard-plus me-1"></i>Input Tugas</button>
                        @endif
                        </div>
                        <hr>
                    </div>

                    <!-- Modal view -->
                    <div class="modal fade text-left" id="viewModal{{ $d->id_materi }}" tabindex="-1"
                        aria-labelledby="myModalLabel33{{ $d->id_materi }}" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel33{{ $d->id_materi }}">Edit
                                        Materi </h4>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                </div>
                                <form id="editForm{{ $d->id_materi }}" method="POST"
                                    action="{{ route('guru.listajar.update', $d->id_materi) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <label for="nama">Nama Materi: </label>
                                        <div class="form-group mt-2">
                                            <input type="hidden" name="jadwal_id" value="{{ $jadwal->kode_jadwal }}">
                                            <input id="nama" name="nama" type="text" placeholder="Nama Materi"
                                                value="{{ $d->nama_materi }}" class="form-control">
                                        </div>
                                        <label for="floatingTextarea">Deskripsi</label>
                                        <div class="form-group mt-2">
                                            <textarea class="form-control" name="deskripsi"
                                                placeholder="Leave a comment here"
                                                id="floatingTextarea">{{ $d->deskripsi }}</textarea>
                                        </div>
                                        <label>Upload File materi: </label>
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group mb-3">
                                                    <label class="input-group-text" for="gambar-input"><i
                                                            class="bi bi-upload"></i></label>
                                                    <input type="file" class="form-control" name="file"
                                                        id="gambar-input">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                            <i class="bx bx-x d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Close</span>
                                        </button>
                                        <button type="submit" class="btn btn-primary ml-1">
                                            <i class="bx bx-check d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Simpan</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!--Insert Modal Tugas -->
                    <div class="modal fade text-left" id="tugasModal{{ $d->id_materi }}" tabindex="-1" aria-labelledby="tugasModal{{ $d->id_materi }}"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="tugasModal{{ $d->id_materi }}">
                                        Input Tugas
                                    </h4>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                </div>
                                <form action="{{ route('guru.listajar.storeTugas') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <label for="nama">Nama Tugas : </label>
                                        <div class="form-group mt-2">
                                            <input type="hidden" name="materi_id" value="{{ $d->id_materi }}">
                                            <input type="hidden" name="jadwal_id" value="{{ $d->jadwal_id }}">
                                            <input id="nama" name="nama" type="text" placeholder="Nama Tugas"
                                                class="form-control">
                                        </div>
                                        <label for="floatingTextarea">Deskripsi</label>
                                        <div class="form-group mt-2">
                                            <textarea class="form-control" name="deskripsi"
                                                placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                                        </div>
                                        <label>Upload File materi: </label>
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group mb-3">
                                                    <label class="input-group-text" for="gambar-input"><i
                                                            class="bi bi-upload"></i></label>
                                                    <input type="file" class="form-control" name="file"
                                                        id="gambar-input">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label>Tanggal Mulai: </label>
                                                <input id="tanggal_mulai" name="tanggal_mulai" type="date" class="form-control"
                                                onchange="setTanggalSelesaiMin(this.value, {{ $index }})">
                                            </div>
                                            <div class="col">
                                                <label>Tanggal Selesai: </label>
                                                <input id="tanggal_selesai" name="tanggal_selesai" type="date" class="form-control"
                                                onchange="setTanggalMulaiMax(this.value, {{ $index }})">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                            <i class="bx bx-x d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Close</span>
                                        </button>
                                        <button type="submit" class="btn btn-primary ms-1">
                                            <i class="bx bx-check d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Tambah</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!--Insert Modal -->
<div class="modal fade text-left" id="insertModal" tabindex="-1" aria-labelledby="insertModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="insertModal">
                    Tambah Materi
                </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <form action="{{ route('guru.listajar.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <label for="nama">Nama Materi: </label>
                    <div class="form-group mt-2">
                        <input type="hidden" name="jadwal_id" value="{{ $jadwal->kode_jadwal }}">
                        <input id="nama" name="nama" type="text" placeholder="Nama Materi" class="form-control">
                    </div>
                    <label for="floatingTextarea">Deskripsi</label>
                    <div class="form-group mt-2">
                        <textarea class="form-control" name="deskripsi" placeholder="Leave a comment here"
                            id="floatingTextarea"></textarea>
                    </div>
                    <label>Upload File materi: </label>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="gambar-input"><i class="bi bi-upload"></i></label>
                                <input type="file" class="form-control" name="file" id="gambar-input">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary ms-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tambah</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
   function setTanggalSelesaiMin(tanggalMulaiValue, index) {
        var tanggalMulai = new Date(tanggalMulaiValue);
        var tanggalSelesaiInput = document.getElementsByName("tanggal_selesai")[index];
        var tanggalSelesaiValue = tanggalSelesaiInput.value;
        var tanggalSelesai = new Date(tanggalSelesaiValue);
        if (tanggalMulai > tanggalSelesai) {
            tanggalSelesaiInput.value = tanggalMulaiValue;
        }
        tanggalSelesaiInput.min = tanggalMulaiValue;
    }

    function setTanggalMulaiMax(tanggalSelesaiValue, index) {
        var tanggalSelesai = new Date(tanggalSelesaiValue);
        var tanggalMulaiInput = document.getElementsByName("tanggal_mulai")[index];
        var tanggalMulaiValue = tanggalMulaiInput.value;
        var tanggalMulai = new Date(tanggalMulaiValue);
        if (tanggalSelesai < tanggalMulai) {
            tanggalMulaiInput.value = tanggalSelesaiValue;
        }
        tanggalMulaiInput.max = tanggalSelesaiValue;
    }

    function confirmDelete(id) {
    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect ke route untuk menghapus data dengan ID yang telah ditentukan
            window.location.href = "/listajar/destroy/" + id;
        }
    });
}
</script>
@endsection
