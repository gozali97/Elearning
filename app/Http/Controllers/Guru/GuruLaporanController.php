<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class GuruLaporanController extends Controller
{
    public function index()
    {

        $data = Siswa::query()
            ->join('users', 'users.email', 'siswa.email')
            ->get();

        return view('guru.laporan.index', compact('data'));
    }

    public function Print(Request $request)
    {
        $start = Carbon::parse($request->stat_date)->format('Y-m-d');
        $end = Carbon::parse($request->end_date)->format('Y-m-d');

        $data = Siswa::query()
            ->join('users', 'users.email', 'siswa.email')
            ->whereBetween('siswa.created_at', [$start, $end])
            ->get();

        $pdf = Pdf::loadView('guru.laporan.laporan-pdf', compact('data', 'start', 'end'));

        return Response::make($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="laporan-data-tugas.pdf"'
        ]);
    }
}
