@extends('layouts.app')

@section('content')

@include('layouts.alerts')

<div class="col-12 col-lg-12">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Data Kelas
                </div>
                <div class="card-body">
                    <div class="mt-2 d-flex flex-row-reverse">
                        <button  type="button" class="btn btn-outline-success d-inline-flex" data-bs-toggle="modal" data-bs-target="#insertModal" class="btn icon icon-left btn-success">
                            <i class="bi bi-plus-circle mt-1 d-inline-flex"></i> Tambah</button>
                    </div>
                    <div class="container p-3">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Kelas</th>
                                    <th>Nama Jurusan</th>
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
                                    <td>{{ $d->nama_kelas }}</td>
                                    <td>{{ $d->nama_jurusan }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-warning d-inline-flex"
                                            data-bs-toggle="modal" data-bs-target="#inlineForm{{ $d->id_kelas }}">
                                            <i class="bi bi-pencil-square mt-1"></i>Edit
                                        </button>
                                        <a href="#" class="btn btn-sm btn-outline-danger d-inline-flex"
                                            onclick="event.preventDefault(); confirmDelete({{ $d->id_kelas }});"><i
                                                class="bi bi-trash-fill mt-1"></i>Hapus</a>
                                    </td>
                                </tr>

                                <!-- Modal view -->
                                <div class="modal fade text-left" id="inlineForm{{ $d->id_kelas }}" tabindex="-1"
                                    aria-labelledby="myModalLabel33{{ $d->id }}" aria-hidden="true"
                                    style="display: none;">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                        role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel33{{ $d->id_kelas }}">Edit Guru </h4>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                            <form id="editForm{{ $d->id_kelas }}" method="POST"
                                                action="{{ route('admin.kelas.update', $d->id_kelas) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <label for="nama">Nama Kelas: </label>
                                                    <div class="form-group mt-1">
                                                      <input id="name" type="text" name="nama" placeholder="Nama Kelas" class="form-control" value="{{ $d->nama_kelas }}">
                                                    </div>
                                                    <label for="password">Jurusan: </label>
                                                    <fieldset class="form-group mt-1">
                                                        <select name="jurusan" class="form-select" id="basicSelect">
                                                          <option>pilih</option>
                                                          @foreach ($jurusan as $j)
                                                          <option value="{{ $j->id_jurusan }}" {{ $j->id_jurusan == $d->jurusan_id ? 'selected' : '' }}>{{ $j->nama_jurusan }}</option>
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
                                                    <button type="submit" class="btn btn-primary ml-1">
                                                        <i class="bx bx-check d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Simpan</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                  <!--Insert Modal -->
                                  <div class="modal fade text-left" id="insertModal" tabindex="-1" aria-labelledby="insertModal"  aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h4 class="modal-title" id="insertModal">
                                            Tambah Kelas
                                          </h4>
                                          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                          </button>
                                        </div>
                                        <form action="{{ route('admin.kelas.store') }}" method="POST">
                                            @csrf
                                          <div class="modal-body">
                                            <label for="nama">Nama Kelas: </label>
                                            <div class="form-group mt-1">
                                              <input id="name" type="text" name="nama" placeholder="Nama Kelas" class="form-control">
                                            </div>
                                            <label for="password">Jurusan: </label>
                                            <fieldset class="form-group mt-1">
                                                <select name="jurusan" class="form-select" id="basicSelect">
                                                  <option>pilih</option>
                                                  @foreach ($jurusan as $j)
                                                  <option value="{{ $j->id_jurusan }}">{{ $j->nama_jurusan }}</option>
                                                  @endforeach
                                                </select>
                                              </fieldset>
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
            window.location.href = "/kelas/destroy/" + id;
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
