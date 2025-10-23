<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataAbsensi;
use Illuminate\Routing\Controllers\HasMiddleware;

class GuruAdditionalController extends GuruDashboardController implements HasMiddleware
{

   public function ValidasiKehadiran(Request $request)
   {
       // request alpa = {"siswa_id": 0, "tanggal": "2025-10-23 12:00:22",  "action": "Alpa"}
       // request alpa = {"siswa_id": 0, "tanggal": "2025-10-23 12:00:22",  "action": "Hadir"}
       // grab siswa_id
       $siswa_id = $request->input('siswa_id');
       $tanggal = $request->input('tanggal');
       $tanggal_hari = date('Y-m-d', strtotime($tanggal));
       $validasi = $request->input('action');

        // the handle is two
        try {
            // Map action to jenis
            $jenisMap = [
                'Alpa' => 'alpha',
                'Hadir' => 'masuk',
            ];
            $jenis = $jenisMap[$validasi] ?? $validasi;

            $updated = DataAbsensi::where('siswa_id', $siswa_id)
                ->whereRaw('DATE(tanggal) = ?', [$tanggal_hari])
                ->update(['jenis' => $jenis, 'updated_at' => $tanggal]);

           if ($updated) {
               return response()->json([
                   'success' => true,
                   'message' => 'Data absensi berhasil divalidasi.',
                   'data' => [
                       'siswa_id' => $siswa_id,
                       'tanggal' => $tanggal_hari,
                       'action' => $validasi
                   ]
               ]);
           } else {
               return response()->json([
                   'success' => false,
                   'message' => 'Data absensi tidak ditemukan atau tidak ada perubahan.'
               ], 404);
           }
       } catch (\Exception $e) {
           return response()->json([
               'success' => false,
               'message' => 'Terjadi kesalahan saat memvalidasi data absensi.',
               'error' => $e->getMessage()
           ], 500);
       }
   }
}
