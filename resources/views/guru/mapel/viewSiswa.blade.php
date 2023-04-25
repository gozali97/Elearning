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
                    <h4 class="d-inline-flex">Daftar Siswa</h4>
                </div>
                <div class="card-body">
                    <div class="container p-3">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>No Handphone</th>
                                    <th>Email</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no = 1;
                                @endphp
                                @foreach ($data as $d)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $d->name }}</td>
                                    <td>{{ $d->no_hp }}</td>
                                    <td>{{ $d->email }}</td>
                                    <td>{{ $d->alamat }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-warning"
                                            data-bs-toggle="modal" data-bs-target="#inlineForm{{ $d->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <a href="#" class="btn btn-sm btn-outline-danger"
                                            onclick="event.preventDefault(); confirmDelete({{ $d->id }});"><i
                                                class="bi bi-trash-fill"></i></a>
                                    </td>
                                </tr>

                                <div class="modal fade text-left" id="inlineForm{{ $d->id }}" tabindex="-1"
                                    aria-labelledby="myModalLabel33{{ $d->id }}" aria-hidden="true"
                                    style="display: none;">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                        role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel33{{ $d->id }}">Edit Guru </h4>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                            <form id="editForm{{ $d->id }}" method="POST"
                                                action="{{ route('manageGuru.update', $d->id) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <label for="nama">Nama Guru: </label>
                                                    <div class="form-group mt-2">
                                                        <input id="nama" name="nama" type="text" placeholder="Nama Guru" class="form-control" value="{{ $d->name }}">
                                                    </div>
                                                    <label for="nama">Gender: </label>
                                                    <fieldset class="form-group mt-1">
                                                        <select name="gender" class="form-select" id="basicSelect">
                                                            <option>pilih</option>
                                                            <option value="L" {{ $d->jenis_kelamin == "L" ? 'selected' : ''
                                                            }}>Laki-Laki</option>
                                                            <option value="P" {{ $d->jenis_kelamin == "P" ? 'selected' : ''
                                                            }}>Perempuan</option>
                                                        </select>
                                                    </fieldset>
                                                    <label for="email">Email: </label>
                                                    <div class="form-group mt-2">
                                                        <input id="email" name="email" type="email" placeholder="alamat Email" class="form-control" value="{{ $d->email }}">
                                                    </div>
                                                    <label for="no_hp">No HP: </label>
                                                    <div class="form-group mt-2">
                                                        <input id="no_hp" name="no_hp" type="number" placeholder="No HP" class="form-control" value="{{ $d->no_hp }}">
                                                    </div>
                                                    <label for="alamat">Alamat Rumah: </label>
                                                    <div class="form-group mt-2">
                                                        <input id="alamat" name="alamat" type="text" placeholder="Alamat Rumah" class="form-control" value="{{ $d->alamat }}">
                                                    </div>
                                                    <label>Gambar: </label>
                                                    <div class="form-group">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group mb-3">
                                                                <label class="input-group-text"
                                                                    for="inputGroupFile01"><i
                                                                        class="bi bi-upload"></i></label>
                                                                <input type="file" class="form-control"
                                                                    id="inputGroupFile01" name="gambar">
                                                            </div>
                                                        </div>
                                                        <div class="avatar avatar-xl">
                                                            <img id="preview" src="assets/img/{{ $d->gambar }}"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Close</span>
                                                    </button>
                                                    <button type="submit" class="btn btn-primary ml-1"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-check d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Simpan</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
