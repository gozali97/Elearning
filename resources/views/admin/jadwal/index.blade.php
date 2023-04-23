@extends('layouts.app')

@section('content')

@include('layouts.alerts')

<div class="col-12 col-lg-12">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Data Jadwal Pelajaran
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
                                    <th>Nama Kelas</th>
                                    <th>Nama Mata Pelajaran</th>
                                    <th>Nama Guru</th>
                                    <th>Waktu</th>
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
                                    <td>{{ $d->nama_mapel }}</td>
                                    <td>{{ $d->name }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($d->jam_pelajaran)->format('H:i') }} WIB
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-warning d-inline-flex"
                                            data-bs-toggle="modal" data-bs-target="#inlineForm{{ $d->kode_jadwal }}">
                                            <i class="bi bi-pencil-square mt-1"></i> Edit
                                        </button>
                                        <a href="#" class="btn btn-sm btn-outline-danger d-inline-flex"
                                            onclick="event.preventDefault(); confirmDelete('{{ $d->kode_jadwal }}');"><i
                                                class="bi bi-trash-fill mt-1"></i>Hapus</a>
                                    </td>
                                </tr>

                                <!-- Modal view -->
                                <div class="modal fade text-left" id="inlineForm{{ $d->kode_jadwal }}" tabindex="-1"
                                    aria-labelledby="myModalLabel33{{ $d->kode_jadwal }}" aria-hidden="true"
                                    style="display: none;">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                        role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel33{{ $d->kode_jadwal }}">Edit
                                                    Jadwal Pelajaran </h4>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-x">
                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                        </svg>
                                                    </button>
                                            </div>
                                            <form id="editForm{{ $d->kode_jadwal }}" method="POST"
                                                action="{{ route('admin.jadwal.update', $d->kode_jadwal) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <label for="nama">Kelas</label>
                                                    <div class="form-group mt-2">
                                                        <fieldset class="form-group">
                                                            <select name="kelas" class="form-select" id="basicSelect">
                                                              <option>pilih</option>
                                                              @foreach ($kelas as $k)
                                                              <option value="{{ $k->id_kelas }}" {{ $k->id_kelas == $d->kelas_id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                                              @endforeach
                                                            </select>
                                                          </fieldset>
                                                    </div>
                                                    <label for="nama">Mata Pelajaran</label>
                                                    <div class="form-group mt-2">
                                                        <fieldset class="form-group">
                                                            <select name="mapel" class="form-select" id="basicSelect">
                                                              <option>pilih</option>
                                                              @foreach ($mapel as $m)
                                                              <option value="{{ $m->kode_mapel }}" {{ $m->kode_mapel == $d->mapel_id ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                                                              @endforeach
                                                            </select>
                                                          </fieldset>
                                                    </div>
                                                    <label for="nama">Guru</label>
                                                    <div class="form-group mt-2">
                                                        <fieldset class="form-group">
                                                            <select name="guru" class="form-select" id="basicSelect">
                                                              <option>pilih</option>
                                                              @foreach ($guru as $g)
                                                              <option value="{{ $g->nip }}" {{ $g->nip == $d->guru_id ? 'selected' : '' }}>{{ $g->name }}</option>
                                                              @endforeach
                                                            </select>
                                                          </fieldset>
                                                    </div>
                                                    <label for="floatingTextarea">Jam Pelajaran</label>
                                                    <div class="form-group mt-2">
                                                        <input type="time" name="jam" value="{{ $d->jam_pelajaran }}" class="form-control">
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
                    Tambah Jadwal Pelajaran
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
            <form action="{{ route('admin.jadwal.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <label for="nama">Kelas</label>
                    <div class="form-group mt-2">
                        <fieldset class="form-group">
                            <select name="kelas" class="form-select" id="basicSelect">
                              <option>pilih</option>
                              @foreach ($kelas as $k)
                              <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                              @endforeach
                            </select>
                          </fieldset>
                    </div>
                    <label for="nama">Mata Pelajaran</label>
                    <div class="form-group mt-2">
                        <fieldset class="form-group">
                            <select name="mapel" class="form-select" id="basicSelect">
                              <option>pilih</option>
                              @foreach ($mapel as $m)
                              <option value="{{ $m->kode_mapel }}">{{ $m->nama_mapel }}</option>
                              @endforeach
                            </select>
                          </fieldset>
                    </div>
                    <label for="nama">Guru</label>
                    <div class="form-group mt-2">
                        <fieldset class="form-group">
                            <select name="guru" class="form-select" id="basicSelect">
                              <option>pilih</option>
                              @foreach ($guru as $g)
                              <option value="{{ $g->nip }}">{{ $g->name }}</option>
                              @endforeach
                            </select>
                          </fieldset>
                    </div>
                    <label for="floatingTextarea">Jam Pelajaran</label>
                    <div class="form-group mt-2">
                        <input type="time" name="jam" class="form-control">
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
            window.location.href = "/jadwal/destroy/" + id;
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
