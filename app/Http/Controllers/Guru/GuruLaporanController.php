<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\DetailTugas;
use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use App\Models\Tugas;
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

        $data = MataPelajaran::query()
            ->join('jadwal_pelajaran', 'jadwal_pelajaran.mapel_id', 'mata_pelajarans.kode_mapel')
            ->join('materi', 'materi.jadwal_id', 'jadwal_pelajaran.kode_jadwal')
            ->join('tugas', 'tugas.materi_id', 'materi.id_materi')
            ->join('detail_tugas', 'detail_tugas.tugas_id', 'tugas.id_tugas')
            ->join('siswa', 'siswa.nis', 'detail_tugas.siswa_id')
            ->join('users', 'users.email', 'siswa.email')
            ->select('mata_pelajarans.nama_mapel', 'mata_pelajarans.kode_mapel', 'materi.id_materi', 'materi.nama_materi', 'tugas.nama_tugas', 'siswa.nis', 'users.name', 'detail_tugas.nilai')
            ->where('guru_id', $guru->nip)
            ->orderBy('materi.id_materi');

        if (!empty($filter)) {
            $data = $data->where('jadwal_pelajaran.mapel_id', $filter);
        } else {
            $data = $data->where('mata_pelajarans.kode_mapel', $mapel_default->mapel_id);
        }

        $data = $data->get();

        $nama_materi = [];
        $data_siswa = [];

        foreach ($data as $item) {
            if (!isset($nama_materi[$item['id_materi']])) {
                $nama_materi[$item['id_materi']] = $item['nama_materi'];
            }

            if (!isset($data_siswa[$item['nis']]) && $item['nis'] != null) {
                $data_siswa[$item['nis']] = $item['name'];
            }
        }
        $tugas = [];

        foreach ($data_siswa as $id_siswa => $nama_siswa) {
            $nilai_siswa = [];

            foreach ($nama_materi as $id => $nama) {
                $nilai = 0;

                foreach ($data as $item) {
                    if (($item['nis'] === $id_siswa) && ($item['id_materi'] === $id)) {
                        $nilai = $item['nilai'];
                        break;
                    }
                }

                $nilai_siswa[] = [
                    'nama_materi' => $nama,
                    'nilai' => $nilai
                ];
            }

            $tugas[] = [
                'id_siswa' => $id_siswa,
                'nama_siswa' => $nama_siswa,
                'nilai' => $nilai_siswa
            ];
        }


        $jadwal = JadwalPelajaran::query()
            ->join('mata_pelajarans', 'mata_pelajarans.kode_mapel', 'jadwal_pelajaran.mapel_id')
            ->where('guru_id', $guru->nip)
            ->get();
        return view('guru.laporan.index', compact('tugas', 'jadwal', 'selectedMapel'));
    }

    public function Print(Request $request)
    {
        $filter = $request->mapel;
        $email = Auth::user()->email;
        $guru = Guru::where('email', $email)->first();

        $mapel_default = JadwalPelajaran::query()->where('guru_id', $guru->nip)->first();

        $data = MataPelajaran::query()
            ->join('jadwal_pelajaran', 'jadwal_pelajaran.mapel_id', 'mata_pelajarans.kode_mapel')
            ->join('materi', 'materi.jadwal_id', 'jadwal_pelajaran.kode_jadwal')
            ->join('tugas', 'tugas.materi_id', 'materi.id_materi')
            ->join('detail_tugas', 'detail_tugas.tugas_id', 'tugas.id_tugas')
            ->join('siswa', 'siswa.nis', 'detail_tugas.siswa_id')
            ->join('users', 'users.email', 'siswa.email')
            ->select('mata_pelajarans.nama_mapel', 'mata_pelajarans.kode_mapel', 'materi.id_materi', 'materi.nama_materi', 'tugas.nama_tugas', 'siswa.nis', 'users.name', 'detail_tugas.nilai')
            ->where('guru_id', $guru->nip)
            ->orderBy('materi.id_materi');

        if (!empty($filter)) {
            $data = $data->where('jadwal_pelajaran.mapel_id', $filter);
        } else {
            $data = $data->where('mata_pelajarans.kode_mapel', $mapel_default->mapel_id);
        }

        $data = $data->get();

        $nama_materi = [];
        $data_siswa = [];

        foreach ($data as $item) {
            if (!isset($nama_materi[$item['id_materi']])) {
                $nama_materi[$item['id_materi']] = $item['nama_materi'];
            }

            if (!isset($data_siswa[$item['nis']]) && $item['nis'] != null) {
                $data_siswa[$item['nis']] = $item['name'];
            }
        }
        $tugas = [];

        foreach ($data_siswa as $id_siswa => $nama_siswa) {
            $nilai_siswa = [];

            foreach ($nama_materi as $id => $nama) {
                $nilai = 0;

                foreach ($data as $item) {
                    if (($item['nis'] === $id_siswa) && ($item['id_materi'] === $id)) {
                        $nilai = $item['nilai'];
                        break;
                    }
                }

                $nilai_siswa[] = [
                    'nama_materi' => $nama,
                    'nilai' => $nilai
                ];
            }

            $tugas[] = [
                'id_siswa' => $id_siswa,
                'nama_siswa' => $nama_siswa,
                'nilai' => $nilai_siswa
            ];
        }
        $mapel = MataPelajaran::where('kode_mapel', $filter)->first();
        $pdf = Pdf::loadView('guru.laporan.laporan-pdf', compact('tugas', 'mapel'));

        return Response::make($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="laporan-data-tugas.pdf"'
        ]);
    }
}
