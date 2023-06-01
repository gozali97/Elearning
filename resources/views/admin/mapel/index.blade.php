@extends('layouts.app')

@section('content')

@include('layouts.alerts')

<div class="col-12 col-lg-12">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Data Jurusan
                </div>
                <div class="card-body">
                    <div class="mt-2 d-flex flex-row-reverse">
                        <button type="button" class="btn btn-outline-success d-inline-flex" data-bs-toggle="modal"
                            data-bs-target="#insertModal" class="btn icon icon-left btn-success">
                            <i class="bi bi-plus-circle mt-1 d-inline-flex"></i>Tambah</button>
                    </div>
                    <div class="container p-3">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Mata Pelajaran</th>
                                    <th>Deskripsi</th>
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
                                    <td>{{ $d->nama_mapel }}</td>
                                    <td>{{ $d->deskripsi }}</td>
                                    <td>
                                        <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-sm btn-outline-warning d-inline-flex"
                                            data-bs-toggle="modal" data-bs-target="#inlineForm{{ $d->kode_mapel }}">
                                            <i class="bi bi-pencil-square mt-1"></i>
                                        </button>
                                        <a href="#" class="btn btn-sm btn-outline-danger d-inline-flex"
                                            onclick="event.preventDefault(); confirmDelete('{{ $d->kode_mapel }}');"><i
                                                class="bi bi-trash-fill mt-1"></i></a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal view -->
                                <div class="modal fade text-left" id="inlineForm{{ $d->kode_mapel }}" tabindex="-1"
                                    aria-labelledby="myModalLabel33{{ $d->kode_mapel }}" aria-hidden="true"
                                    style="display: none;">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                        role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel33{{ $d->kode_mapel }}">Edit
                                                    Guru </h4>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                            <form id="editForm{{ $d->kode_mapel }}" method="POST"
                                                action="{{ route('admin.mapel.update', $d->kode_mapel) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <label>Nama Jurusan: </label>
                                                    <div class="form-group mt-2">
                                                        <input type="text" placeholder="Nama Jurusan"
                                                            class="form-control" name="nama"
                                                            value="{{ $d->nama_mapel }}">
                                                    </div>
                                                    <label for="floatingTextarea">Deskripsi</label>
                                                    <div class="form-group mt-2">
                                                        <textarea class="form-control" name="deskripsi"
                                                            placeholder="Leave a comment here"
                                                            id="floatingTextarea">{{ $d->deskripsi }}</textarea>
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
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="insertModal">
                    Tambah Mata Pelajaran
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
            <form action="{{ route('admin.mapel.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <label for="nama">Nama Mata Pelajaran: </label>
                    <div class="form-group mt-2">
                        <input id="nama" name="nama" type="text" placeholder="Nama Mapel" class="form-control">
                    </div>
                    <label for="floatingTextarea">Deskripsi</label>
                    <div class="form-group mt-2">
                        <textarea class="form-control" name="deskripsi" placeholder="Leave a comment here"
                            id="floatingTextarea"></textarea>
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
            window.location.href = "/mapel/destroy/" + id;
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
</script>
@endsection
