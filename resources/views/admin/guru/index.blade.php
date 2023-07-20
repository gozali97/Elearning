@extends('layouts.app')

@section('content')
    @include('layouts.alerts')

    <div class="col-12 col-lg-12">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Data Guru
                    </div>
                    <div class="card-body">
                        <div class="mt-2 d-flex flex-row-reverse">
                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                data-bs-target="#insertModal" class="btn icon icon-left btn-success d-inline-flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-person-plus-fill d-inline-flex mb-1" viewBox="0 0 16 16">
                                    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                    <path fill-rule="evenodd"
                                        d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                                </svg>
                                Tambah</button>
                        </div>
                        <div class="container p-3">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>No Telepone</th>
                                        <th>Foto</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($guru as $g)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $g->name }}</td>
                                            <td>{{ $g->email }}</td>
                                            <td>{{ $g->no_hp }}</td>
                                            <td>
                                                <div class="avatar avatar-xl">
                                                    <img src="assets/img/{{ $g->gambar }}" alt="">
                                                </div>

                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-warning"
                                                    data-bs-toggle="modal" data-bs-target="#inlineForm{{ $g->id }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-info d-inline-flex"
                                                    data-bs-toggle="modal" data-bs-target="#resetForm{{ $g->id }}">
                                                    <i class="bi bi-key-fill mt-1"></i>Reset
                                                </button>
                                                <a href="#" class="btn btn-sm btn-outline-danger"
                                                    onclick="event.preventDefault(); confirmDelete({{ $g->id }});"><i
                                                        class="bi bi-trash-fill"></i></a>
                                            </td>
                                        </tr>

                                        <div class="modal fade text-left" id="inlineForm{{ $g->id }}" tabindex="-1"
                                            aria-labelledby="myModalLabel33{{ $g->id }}" aria-hidden="true"
                                            style="display: none;">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel33{{ $g->id }}">Edit
                                                            Guru </h4>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <form id="editForm{{ $g->id }}" method="POST"
                                                        action="{{ route('manageGuru.update', $g->id) }}"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <label for="nama">Nama Guru: </label>
                                                            <div class="form-group mt-2">
                                                                <input id="nama" name="nama" type="text"
                                                                    placeholder="Nama Guru" class="form-control"
                                                                    value="{{ $g->name }}">
                                                            </div>
                                                            <label for="nama">Gender: </label>
                                                            <fieldset class="form-group mt-1">
                                                                <select name="gender" class="form-select" id="basicSelect">
                                                                    <option>pilih</option>
                                                                    <option value="L"
                                                                        {{ $g->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                                                        Laki-Laki</option>
                                                                    <option value="P"
                                                                        {{ $g->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                                                        Perempuan</option>
                                                                </select>
                                                            </fieldset>
                                                            <label for="email">Email: </label>
                                                            <div class="form-group mt-2">
                                                                <input id="email" name="email" type="email"
                                                                    placeholder="alamat Email" class="form-control"
                                                                    value="{{ $g->email }}">
                                                            </div>
                                                            <label for="no_hp">No HP: </label>
                                                            <div class="form-group mt-2">
                                                                <input id="no_hp" name="no_hp" type="number"
                                                                    placeholder="No HP" class="form-control"
                                                                    value="{{ $g->no_hp }}">
                                                            </div>
                                                            <label for="alamat">Alamat Rumah: </label>
                                                            <div class="form-group mt-2">
                                                                <input id="alamat" name="alamat" type="text"
                                                                    placeholder="Alamat Rumah" class="form-control"
                                                                    value="{{ $g->alamat }}">
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
                                                                    <img id="preview"
                                                                        src="assets/img/{{ $g->gambar }}"
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
                                                            <button type="submit" class="btn btn-primary ml-1">
                                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                                <span class="d-none d-sm-block">Simpan</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade text-left" id="resetForm{{ $g->id }}"
                                            tabindex="-1" aria-labelledby="resetForm{{ $g->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="resetForm{{ $g->id }}">
                                                            Reset Password Guru
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
                                                    <form action="{{ route('admin.manageGuru.resetPassword', $g->id) }}"
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
                                    @endforeach
                                </tbody>
                            </table>
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
                        Tambah Kelas
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
                <form action="{{ route('manageGuru.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label for="nama">Nama Guru: </label>
                        <div class="form-group mt-2">
                            <input id="nama" name="nama" type="text" placeholder="Nama Guru"
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
                    window.location.href = "/manageGuru/destroy/" + id;
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
