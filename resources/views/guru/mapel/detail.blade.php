@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ url('/assets/css/theme.min.css') }}">
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
                            <button data-bs-toggle="modal" data-bs-target="#full-scrn{{ $d->id_materi }}" class="btn btn-info d-inline-flex align-items-center"><i class="bi bi-info-circle-fill me-1"></i>Lihat Tugas</button>
                            <a href="{{ route('guru.listajar.viewTugas', $d->id_tugas) }}" class="btn btn-warning d-inline-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf mx-1 d-inline-flex" viewBox="0 0 16 16">
                                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                                    <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
                                  </svg>
                                Tugas Siswa</a>
                            <a href="{{ route('guru.diskusi.index', $d->id_materi) }}" class="btn btn-primary d-inline-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-dots me-2" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                    <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                  </svg>
                                Forum Diskusi</a>
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

                      <!-- Modal view Tugas -->
                      <div class="modal fade text-left w-100" id="full-scrn{{ $d->id_materi }}" tabindex="-1"
                        aria-labelledby="myModalLabel20{{ $d->id_materi }}" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                </div>
                                    <div class="modal-body">
                                        <embed type="application/pdf" src="{{ url('/assets/tugas/', $d->file_tugas) }}" width="1090" height="800"></embed>
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
