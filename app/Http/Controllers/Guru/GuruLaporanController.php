<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\DetailTugas;
use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class GuruLaporanController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->mapel;
        $selectedMapel = $filter;

        $email = Auth::user()->email;
        $guru = Guru::where('email', $email)->first();

        $mapel_default = JadwalPelajaran::query()->where('guru_id', $guru->nip)->first();

        $data = Siswa::query()
            ->join('users', 'users.email', 'siswa.email')
            ->join('jadwal_pelajaran', 'jadwal_pelajaran.kelas_id', 'siswa.kelas_id')
            ->where('guru_id', $guru->nip)
            ->where('jadwal_pelajaran.mapel_id', $mapel_default->mapel_id)
            ->get();

        $detail = DetailTugas::query()
            ->join('tugas', 'tugas.id_tugas', 'detail_tugas.tugas_id')
            ->join('materi', 'materi.id_materi', 'tugas.materi_id')
            ->join('jadwal_pelajaran', 'jadwal_pelajaran.kode_jadwal', 'materi.jadwal_id')
            ->join('siswa', 'siswa.kelas_id', 'jadwal_pelajaran.kelas_id')
            ->whereIn('detail_tugas.siswa_id', $data->pluck('nis'))
            ->where('jadwal_pelajaran.guru_id', $guru->nip);

        if (!empty($filter)) {
            $detail = $detail->where('jadwal_pelajaran.mapel_id', $filter);
        }

        $tugas = $detail->get();

        $data = $data->map(function ($item) use ($tugas) {
            $item->tugas = collect($tugas)->filter(function ($tugasItem) use ($item) {
                return $tugasItem['siswa_id'] == $item->nis;
            })->values();
            return $item;
        });

        $jadwal = JadwalPelajaran::query()
            ->join('mata_pelajarans', 'mata_pelajarans.kode_mapel', 'jadwal_pelajaran.mapel_id')
            ->where('guru_id', $guru->nip)
            ->get();
        return view('guru.laporan.index', compact('data', 'jadwal', 'selectedMapel'));
    }

    public function Print(Request $request)
    {
        $filter = $request->mapel;
        $email = Auth::user()->email;
        $guru = Guru::where('email', $email)->first();

        $mapel_default = JadwalPelajaran::query()->where('guru_id', $guru->nip)->first();

        $data = Siswa::query()
            ->join('users', 'users.email', 'siswa.email')
            ->join('jadwal_pelajaran', 'jadwal_pelajaran.kelas_id', 'siswa.kelas_id')
            ->where('guru_id', $guru->nip)
            ->where('jadwal_pelajaran.mapel_id', $mapel_default->mapel_id)
            ->get();

        $detail = DetailTugas::query()
            ->join('tugas', 'tugas.id_tugas', 'detail_tugas.tugas_id')
            ->join('materi', 'materi.id_materi', 'tugas.materi_id')
            ->join('jadwal_pelajaran', 'jadwal_pelajaran.kode_jadwal', 'materi.jadwal_id')
            ->join('siswa', 'siswa.kelas_id', 'jadwal_pelajaran.kelas_id')
            ->whereIn('detail_tugas.siswa_id', $data->pluck('nis'))
            ->where('jadwal_pelajaran.guru_id', $guru->nip);

        if (!empty($filter)) {
            $detail = $detail->where('jadwal_pelajaran.mapel_id', $filter);
        }

        $tugas = $detail->get();

        $data = $data->map(function ($item) use ($tugas) {
            $item->tugas = collect($tugas)->filter(function ($tugasItem) use ($item) {
                return $tugasItem['siswa_id'] == $item->nis;
            })->values();
            return $item;
        });
        $mapel = MataPelajaran::where('kode_mapel', $filter)->first();
        $pdf = Pdf::loadView('guru.laporan.laporan-pdf', compact('data', 'mapel'));

        return Response::make($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="laporan-data-tugas.pdf"'
        ]);
    }
}
