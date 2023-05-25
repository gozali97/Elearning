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
                <a href="/listajar" class="btn btn sm btn-outline-secondary d-inline-flex mb-3"><i
                        class="bi bi-arrow-left mt-1 d-inline-flex"></i>Kembali</a>
                <div class="card">
                    <div class="card-header">
                        <h4 class="d-inline-flex">Daftar Upload Tugas Siswa</h4>
                    </div>
                    <div class="card-body">
                        <div class="container p-3">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Siswa</th>
                                        <th>Nama Tugas</th>
                                        <th>Nama Materi</th>
                                        <th>Upload Siswa</th>
                                        <th>Nilai</th>
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
                                            <td class="{{ $d->tugas->isEmpty() ? 'text-danger' : '' }}">
                                                {{ $d->name }}</td>
                                            @if ($d->tugas->isEmpty())
                                                <td colspan="5" class="text-danger text-center">Belum mengumpulkan tugas
                                                </td>
                                            @else
                                                @foreach ($d->tugas as $tugas)
                                                    <td>{{ $tugas->nama_tugas }}</td>
                                                    <td>{{ $tugas->nama_materi }}</td>
                                                    <td><button data-bs-toggle="modal"
                                                            data-bs-target="#full-scrn{{ $tugas->id_detail_tugas }}"
                                                            class="btn btn-light d-inline-flex align-items-center"><i
                                                                class="bi bi-file-word-fill me-1"></i>Lihat Tugas</button>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" id="id_tugas_{{ $tugas->id_detail_tugas }}"
                                                            value="{{ $tugas->id_detail_tugas }}">
                                                        <input class="form-control" type="number"
                                                            value="{{ $tugas->nilai }}"
                                                            id="nilai_{{ $tugas->id_detail_tugas }}">
                                                    </td>
                                                    <td>
                                                        <button class="btn me-md-2 d-inline-flex btn-submit-nilai"
                                                            data-id="{{ $tugas->id_detail_tugas }}"><i
                                                                class="bi text-success bi-check-circle-fill me-1 fs-5 d-inline-flex"></i></button>
                                                    </td>

                                                    <!-- Modal view Tugas -->
                                                    <div class="modal fade text-left w-100"
                                                        id="full-scrn{{ $tugas->id_detail_tugas }}" tabindex="-1"
                                                        aria-labelledby="myModalLabel20{{ $tugas->id_detail_tugas }}"
                                                        aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable"
                                                            role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                        data-bs-dismiss="modal" aria-label="Close">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24"
                                                                            viewBox="0 0 24 24" fill="none"
                                                                            stroke="currentColor" stroke-width="2"
                                                                            stroke-linecap="round" stroke-linejoin="round"
                                                                            class="feather feather-x">
                                                                            <line x1="18" y1="6"
                                                                                x2="6" y2="18">
                                                                            </line>
                                                                            <line x1="6" y1="6"
                                                                                x2="18" y2="18">
                                                                            </line>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <embed type="application/pdf"
                                                                        src="{{ url('/assets/tugas-siswa/', $tugas->file) }}"
                                                                        width="1090" height="800"></embed>
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
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="position-relative">
            <button class="btn btn-primary position-absolute top-100 start-50 translate-middle mt-1"
                type="button">Simpan</button>
        </div> --}}
    </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.btn-submit-nilai').click(function() {
                var idTugas = $(this).data('id');
                var nilai = $('#nilai_' + idTugas).val();

                $.ajax({
                    url: '{{ route('guru.listajar.viewTugas.mark') }}',
                    type: 'POST',
                    data: {
                        id_tugas: idTugas,
                        nilai: nilai,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            text: 'Nilai berhasil disimpan',
                            timer: 99999,
                            showConfirmButton: true
                        }).then(function() {
                            location
                                .reload();
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            text: 'Terjadi kesalahan saat menyimpan nilai'
                        });
                    }
                });
            });
        });
    </script>
@endsection
