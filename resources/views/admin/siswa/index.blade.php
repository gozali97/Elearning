@extends('layouts.app')

@section('content')
    @include('layouts.alerts')

    <style>
        img {
            width: 70px;
            border-radius: 50%;
        }
    </style>

    <div class="col-12 col-lg-12">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Data Siswa
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mt-2">
                            <div class="">
                                <button data-bs-toggle="modal" data-bs-target="#exampleModalCenter"
                                    class="btn icon icon-left btn-outline-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-file-earmark-medical" viewBox="0 0 16 16">
                                        <path
                                            d="M7.5 5.5a.5.5 0 0 0-1 0v.634l-.549-.317a.5.5 0 1 0-.5.866L6 7l-.549.317a.5.5 0 1 0 .5.866l.549-.317V8.5a.5.5 0 1 0 1 0v-.634l.549.317a.5.5 0 1 0 .5-.866L8 7l.549-.317a.5.5 0 1 0-.5-.866l-.549.317V5.5zm-2 4.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 2a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5z" />
                                        <path
                                            d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                                    </svg> Import Siswa</button>

                                <div class="modal fade" id="exampleModalCenter" tabindex="-1"
                                    aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                        role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalCenterTitle">
                                                    Import Siswa
                                                </h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-x">
                                                        <line x1="18" y1="6" x2="6" y2="18">
                                                        </line>
                                                        <line x1="6" y1="6" x2="18" y2="18">
                                                        </line>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('admin.manageSiswa.importSiswa') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="excel_file">File Excel</label>
                                                        <input type="file" class="form-control" id="excel_file"
                                                            name="excel_file">
                                                        @error('excel_file')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <a class="text-info"
                                                            href="{{ url('/assets/dokumen/template.xlsx') }}"
                                                            download="">Download Template</a>
                                                    </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light-secondary"
                                                    data-bs-dismiss="modal">
                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Close</span>
                                                </button>
                                                <button type="submit" class="btn btn-primary ms-1">
                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Import</span>
                                                </button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn mx-1 btn-outline-success" data-bs-toggle="modal"
                                    data-bs-target="#insertModal" class="btn icon icon-left btn-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-person-plus-fill d-inline-flex mx-1"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                        <path fill-rule="evenodd"
                                            d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                                    </svg>Tambah</button>
                            </div>
                        </div>

                        <div class="container p-3">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Siswa</th>
                                        <th>Email</th>
                                        <th>Foto</th>
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
                                            <td>{{ $d->email }}</td>
                                            <td>
                                                <div class="avatar avatar-xl">
                                                    @if (!$d->gambar)
                                                        <img src="assets/images/faces/user.png" alt="">
                                                    @else
                                                        <img src="assets/img/{{ $d->gambar }}" alt="">
                                                    @endif
                                                </div>

                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-warning d-inline-flex"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#inlineForm{{ $d->id }}">
                                                    <i class="bi bi-pencil-square mt-1"></i>Edit
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-info d-inline-flex"
                                                    data-bs-toggle="modal" data-bs-target="#resetForm{{ $d->id }}">
                                                    <i class="bi bi-key-fill mt-1"></i>Reset
                                                </button>
                                                <a href="#" class="btn btn-sm btn-outline-danger d-inline-flex"
                                                    onclick="event.preventDefault(); confirmDelete({{ $d->id }});"><i
                                                        class="bi bi-trash-fill mt-1"></i>Hapus</a>
                                            </td>
                                        </tr>

                                        <!--Update Modal -->
                                        <div class="modal fade text-left" id="inlineForm{{ $d->id }}"
                                            tabindex="-1" aria-labelledby="inlineForm{{ $d->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="inlineForm{{ $d->id }}">
                                                            Perbarui Data Siswa
                                                        </h4>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-x">
                                                                <line x1="18" y1="6" x2="6"
                                                                    y2="18"></line>
                                                                <line x1="6" y1="6" x2="18"
                                                                    y2="18"></line>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('admin.manageSiswa.update', $d->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <label for="nama">Nama Siswa: </label>
                                                            <div class="form-group mt-2">
                                                                <input id="nama" name="nama"
                                                                    value="{{ $d->name }}" type="text"
                                                                    placeholder="Nama Siswa" class="form-control">
                                                            </div>
                                                            <label for="nama">Gender: </label>
                                                            <fieldset class="form-group mt-1">
                                                                <select name="gender" class="form-select"
                                                                    id="basicSelect">
                                                                    <option>pilih</option>
                                                                    <option value="L"
                                                                        {{ $d->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                                                        Laki-Laki</option>
                                                                    <option value="P"
                                                                        {{ $d->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                                                        Perempuan</option>
                                                                </select>
                                                            </fieldset>
                                                            <label for="nama">Kelas: </label>
                                                            <fieldset class="form-group mt-1">
                                                                <select name="kelas" class="form-select"
                                                                    id="basicSelect">
                                                                    <option>pilih</option>
                                                                    @foreach ($kelas as $k)
                                                                        <option value="{{ $k->id_kelas }}"
                                                                            {{ $k->id_kelas == $d->kelas_id ? 'selected' : '' }}>
                                                                            {{ $k->nama_kelas }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </fieldset>
                                                            <label for="nama">Jurusan: </label>
                                                            <fieldset class="form-group mt-1">
                                                                <select name="jurusan" class="form-select"
                                                                    id="basicSelect">
                                                                    <option>pilih</option>
                                                                    @foreach ($jurusan as $j)
                                                                        <option value="{{ $j->id_jurusan }}"
                                                                            {{ $j->id_jurusan == $d->jurusan_id ? 'selected' : '' }}>
                                                                            {{ $j->nama_jurusan }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </fieldset>
                                                            <label for="email">Email: </label>
                                                            <div class="form-group mt-2">
                                                                <input id="email" name="email"
                                                                    value="{{ $d->email }}" type="email"
                                                                    placeholder="alamat Email" class="form-control">
                                                            </div>
                                                            <label for="no_hp">No HP: </label>
                                                            <div class="form-group mt-2">
                                                                <input id="no_hp" name="no_hp"
                                                                    value="{{ $d->no_hp }}" type="number"
                                                                    placeholder="No HP" class="form-control">
                                                            </div>
                                                            <label for="alamat">Alamat Rumah: </label>
                                                            <div class="form-group mt-2">
                                                                <input id="alamat" name="alamat"
                                                                    value="{{ $d->alamat }}" type="text"
                                                                    placeholder="Alamat Rumah" class="form-control">
                                                            </div>
                                                            <label>Gambar: </label>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <div class="input-group mb-3">
                                                                            <div class="input-group mb-3">
                                                                                <label class="input-group-text"
                                                                                    for="inputGroupFile01"><i
                                                                                        class="bi bi-upload"></i></label>
                                                                                <input type="file" class="form-control"
                                                                                    id="inputGroupFile01" name="gambar">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <img id="preview"
                                                                            src="assets/img/{{ $d->gambar }}"
                                                                            alt="">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light-secondary"
                                                                data-bs-dismiss="modal">
                                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                                <span class="d-none d-sm-block">Close</span>
                                                            </button>
                                                            <button type="submit" class="btn btn-primary ms-1">
                                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                                <span class="d-none d-sm-block">Simpan</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade text-left" id="resetForm{{ $d->id }}"
                                            tabindex="-1" aria-labelledby="resetForm{{ $d->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="resetForm{{ $d->id }}">
                                                            Reset Password Siswa
                                                        </h4>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-x">
                                                                <line x1="18" y1="6" x2="6"
                                                                    y2="18"></line>
                                                                <line x1="6" y1="6" x2="18"
                                                                    y2="18"></line>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('admin.manageSiswa.resetPassword', $d->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <label for="nama">Password Baru: </label>
                                                            <div class="form-group mt-2">
                                                                <input id="password" name="password" type="password"
                                                                    class="form-control">
                                                            </div>


                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light-secondary"
                                                                data-bs-dismiss="modal">
                                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                                <span class="d-none d-sm-block">Close</span>
                                                            </button>
                                                            <button type="submit" class="btn btn-primary ms-1">
                                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                                <span class="d-none d-sm-block">Reset Password</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!--Insert Modal -->
                                        {{-- <div class="modal fade text-left" id="insertModal" tabindex="-1"
                                    aria-labelledby="insertModal" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                        role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="insertModal">
                                                    Tambah Kelas
                                                </h4>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-x">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                </button>
                                            </div>
                                            <form action="{{ route('admin.kelas.store') }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <label for="nama">Nama Kelas: </label>
                                                    <div class="form-group mt-1">
                                                        <input id="name" type="text" name="nama"
                                                            placeholder="Nama Kelas" class="form-control">
                                                    </div>
                                                    <label for="password">Jurusan: </label>
                                                    <fieldset class="form-group mt-1">
                                                        <select name="jurusan" class="form-select" id="basicSelect">
                                                            <option>pilih</option>
                                                            @foreach ($jurusan as $j)
                                                            <option value="{{ $j->id_jurusan }}">{{ $j->nama_jurusan }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </fieldset>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
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
                                </div> --}}

                        </div>
                        @endforeach
                        </tbody>
                        </table>
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
                        Tambah Data Siswa
                    </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('admin.manageSiswa.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label for="nama">Nama Siswa: </label>
                        <div class="form-group mt-2">
                            <input id="nama" name="nama" type="text" placeholder="Nama Siswa"
                                class="form-control">
                        </div>
                        <label for="nama">Gender: </label>
                        <fieldset class="form-group mt-1">
                            <select name="gender" class="form-select" id="basicSelect">
                                <option>pilih</option>
                                <option value="L">Laki-Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </fieldset>
                        <label for="nama">Kelas: </label>
                        <fieldset class="form-group mt-1">
                            <select name="kelas" class="form-select" id="basicSelect">
                                <option>pilih</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </fieldset>
                        <label for="nama">Jurusan: </label>
                        <fieldset class="form-group mt-1">
                            <select name="jurusan" class="form-select" id="basicSelect">
                                <option>pilih</option>
                                @foreach ($jurusan as $j)
                                    <option value="{{ $j->id_jurusan }}">{{ $j->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </fieldset>
                        <label for="email">Email: </label>
                        <div class="form-group mt-2">
                            <input id="email" name="email" type="email" placeholder="alamat Email"
                                class="form-control">
                        </div>
                        <label for="no_hp">No HP: </label>
                        <div class="form-group mt-2">
                            <input id="no_hp" name="no_hp" type="number" placeholder="No HP"
                                class="form-control">
                        </div>
                        <label for="alamat">Alamat Rumah: </label>
                        <div class="form-group mt-2">
                            <input id="alamat" name="alamat" type="text" placeholder="Alamat Rumah"
                                class="form-control">
                        </div>
                        <label>Gambar: </label>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-group mb-3">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="gambar-input"><i
                                                    class="bi bi-upload"></i></label>
                                            <input type="file" class="form-control" name="gambar" id="gambar-input">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div id="gambar-preview" class="avatar avatar-xl">
                                    </div>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
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
                    window.location.href = "/manageSiswa/destroy/" + id;
                }
            });
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#inputGroupFile01").change(function() {
            previewImage(this);
        });

        const gambarInput = document.getElementById('gambar-input');
        const gambarPreview = document.getElementById('gambar-preview');

        gambarInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.addEventListener('load', function() {
                    gambarPreview.innerHTML =
                        `<img src="${this.result}" class="img-fluid" style="max-height: 200px;">`;
                });
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
