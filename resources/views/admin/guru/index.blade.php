@extends('layouts.app')

@section('content')
        <div class="col-12 col-lg-12">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Data Guru
                        </div>
                        <div class="card-body">
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
                                                <img src="assets/images/faces/{{ $g->gambar }}" alt="">
                                            </div>

                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#inlineForm{{ $g->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <a href="#" class="btn btn-sm btn-outline-danger" onclick="event.preventDefault(); confirmDelete({{ $g->id }});"><i class="bi bi-trash-fill"></i></a>
                                        </td>
                                    </tr>

                                    <div class="modal fade text-left" id="inlineForm{{ $g->id }}" tabindex="-1" aria-labelledby="myModalLabel33{{ $g->id }}" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel33{{ $g->id }}">Edit Guru </h4>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <form id="editForm{{ $g->id }}" method="POST" action="{{ route('manageGuru.update', $g->id) }}" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <label>Nama: </label>
                                                        <div class="form-group">
                                                            <input type="text" placeholder="Email Address" class="form-control" name="nama" value="{{ $g->name }}">
                                                        </div>
                                                        <label>Email: </label>
                                                        <div class="form-group">
                                                            <input type="text" placeholder="nama" class="form-control" name="email" value="{{ $g->email }}">
                                                        </div>
                                                        <label>No Hp: </label>
                                                        <div class="form-group">
                                                            <input type="text" placeholder="Email Address" class="form-control" name="no_hp" value="{{ $g->no_hp }}">
                                                        </div>
                                                        <label>Gambar: </label>
                                                        <div class="form-group">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group mb-3">
                                                                    <label class="input-group-text" for="inputGroupFile01"><i class="bi bi-upload"></i></label>
                                                                    <input type="file" class="form-control" id="inputGroupFile01">
                                                                </div>
                                                            </div>
                                                            <div class="avatar avatar-xl">
                                                                <img id="preview" src="assets/images/faces/{{ $g->gambar }}" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                            <i class="bx bx-x d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">Close</span>
                                                        </button>
                                                        <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
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
            window.location.href = "/guru/destroy/" + id;
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
