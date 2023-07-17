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
                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{ route('guru.laporan.index') }}" method="GET">
                                    @csrf
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">Filter Data</div>
                                            <div class="col-md-6">
                                                <select class="form-control" name="mapel" id="">
                                                    <option value="">Pilih Mapel</option>
                                                    @foreach ($jadwal as $j)
                                                        <option value="{{ $j->kode_mapel }}"
                                                            {{ $j->kode_mapel == $selectedMapel ? 'selected' : '' }}>
                                                            {{ $j->nama_mapel }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn icon btn-primary">
                                                    Filter
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                </form>
                            </div>
                            <div class="col-md-6">
                                <form action="{{ route('guru.laporan.print') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">Cetak Laporan</div>
                                            <div class="col-md-6">
                                                <select class="form-control" name="mapel" id="">
                                                    <option value="">Pilih Mapel</option>
                                                    @foreach ($jadwal as $j)
                                                        <option value="{{ $j->kode_mapel }}">{{ $j->nama_mapel }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn icon btn-info">
                                                    Cetak
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="container p-3">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Siswa</th>
                                        @for ($i = 1; $i <= 10; $i++)
                                            <th>Tugas {{ $i }}</th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($tugas as $d)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $d['nama_siswa'] }}</td>
                                            @php
                                                $nomor = 1;
                                            @endphp
                                            @foreach ($d['nilai'] as $tugas)
                                                @php
                                                    $nomor += 1;
                                                @endphp
                                                <td>{{ $tugas['nilai'] }}</td>
                                            @endforeach
                                            @for ($i = $nomor; $i <= 10; $i++)
                                                <td>0</td>
                                            @endfor
                                        </tr>
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
