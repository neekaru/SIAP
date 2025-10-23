<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class GuruDashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'guru',
        ];
    }

    /**
     * Show the guru dashboard.
     */
    public function index(Request $request): \Illuminate\Http\Response
    {
        // In a real app you'd compute these using models/queries. We'll provide
        // mock numbers that match the design: total siswa, hadir, izin, belum absen.
        // Get today's attendance data for "Absen Hari ini" section
        $today_attendance = [
            ['nama' => 'Ahmad Santoso', 'nis' => '001', 'waktu' => '07:05', 'status' => 'Hadir'],
            ['nama' => 'Siti Nurhaliza', 'nis' => '002', 'waktu' => '07:12', 'status' => 'Hadir'],
            ['nama' => 'Dedi Kurnia', 'nis' => '005', 'waktu' => '07:20', 'status' => 'Hadir'],
            ['nama' => 'Budi Santoso', 'nis' => '003', 'waktu' => '-', 'status' => 'Izin'],
            ['nama' => 'Rina Wijaya', 'nis' => '004', 'waktu' => '-', 'status' => 'Alpa'],
        ];

        $data['today_attendance'] = $today_attendance;

        return response()->view('guru.dashboard', $data);
    }

    /**
     * This for stats guru dashboard
     */
     public function StatsGuruDashboard(Request $request): \Illuminate\Http\JsonResponse
     {
         // This calculate Total siswa
         $siswa = \App\Models\DataSiswa::count();
         $hadir = \App\Models\DataAbsensi::where('jenis', 'masuk')
             ->whereDate('created_at', now()->toDateString())
             ->count() ?? "0";
         $izin_sakit = \App\Models\DataSakitIzin::whereDate('created_at', now()->toDateString())
             ->where('status', 'tervalidasi')
             ->count() ?? "0";
         $belum_absen = $siswa - ($hadir + $izin_sakit) ?? "0";

         return response()->json([
             'total_siswa' => $siswa,
             'hadir' => $hadir,
             'izin_sakit' => $izin_sakit,
             'belum_absen' => $belum_absen,
         ]);
     }

    /**
     * Show the kehadiran (attendance) page for guru.
     */
     public function kehadiran(Request $request): \Illuminate\Http\Response
     {
         // Get today's date
         $today = now()->toDateString();

         // Get all students
         $siswaList = \App\Models\DataSiswa::all();

         // Get today's attendance with eager loading
         $todayAbsensi = \App\Models\DataAbsensi::with('siswa')
             ->whereDate('tanggal', $today)
             ->get()
             ->groupBy('siswa_id');

         // Get today's izin/sakit
         $todayIzin = \App\Models\DataSakitIzin::whereDate('created_at', $today)
             ->where('status', 'tervalidasi')
             ->get()
             ->keyBy('siswa_id');

         $kehadiran = $siswaList->map(function ($siswa) use ($todayAbsensi, $todayIzin) {
             $siswaId = $siswa->id;
             $status = 'Alpa'; // Default
             $waktu = '-';

             if ($todayAbsensi->has($siswaId)) {
                 // Ambil absensi pertama dengan jenis 'masuk' jika ada, jika tidak ambil absensi dengan jenis 'alpha', jika tidak ambil absensi pertama
                 $absensiMasuk = $todayAbsensi->get($siswaId)->firstWhere('jenis', 'masuk');
                 $absensiAlpha = $todayAbsensi->get($siswaId)->firstWhere('jenis', 'alpha');
                 $absensi = $absensiMasuk ?: ($absensiAlpha ?: $todayAbsensi->get($siswaId)->first());

                 if ($absensi) {
                     // Map jenis to status, including 'alpha'
                     $status = match ($absensi->jenis) {
                         'masuk' => 'Hadir',
                         'pulang' => 'Pulang',
                         'alpha' => 'Alpa',
                         default => 'Unknown',
                     };
                     $waktu = $absensi->created_at ? \Carbon\Carbon::parse($absensi->created_at)->format('H:i') : '-';
                 }
             } elseif ($todayIzin->has($siswaId)) {
                 $izin = $todayIzin->get($siswaId);
                 $status = ucfirst($izin->tipe); // Sakit or Izin
             }

             return [
                 'id' => $siswaId,
                 'nama' => $siswa->nama,
                 'nis' => $siswa->nis,
                 'waktu' => $waktu,
                 'status' => $status,
             ];
         })->toArray();

         $debug = [
             'total_siswa' => $siswaList->count(),
             'total_absensi_today' => $todayAbsensi->flatten()->count(),
             'total_izin_today' => $todayIzin->count(),
             'today_date' => $today,
         ];

         return response()->view('guru.kehadiran', ['kehadiran' => $kehadiran, 'debug' => $debug]);
     }

    /**
     * Map jenis absensi to status label.
     */
    private function mapJenisToStatus(string $jenis): string
    {
        return match ($jenis) {
            'masuk' => 'Hadir',
            'pulang' => 'Pulang',
            default => 'Unknown',
        };
    }

    /**
     * Show the izin / sakit management page for guru.
     */
    public function izinSakit(Request $request): \Illuminate\Http\Response
    {
        // Get izin/sakit data from database
        $items = \App\Models\DataSakitIzin::with(['user.dataSiswa'])
            ->get()
            ->map(function ($izin) {
                $siswa = $izin->user->dataSiswa ?? null;

                return [
                    'nama' => $siswa ? $siswa->nama : '-',
                    'nis' => $siswa ? $siswa->nis : '-',
                    'tanggal' => $izin->created_at->toDateString(),
                    'jenis' => ucfirst($izin->tipe),
                    'keterangan' => $izin->alasan,
                    'status' => $izin->status,
                ];
            })
            ->toArray();

        return response()->view('guru.izin_sakit', ['items' => $items]);
    }
}
