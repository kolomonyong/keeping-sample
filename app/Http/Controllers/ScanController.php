<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScanController extends Controller
{
    // Menampilkan halaman scan manual
    public function showScanPage()
    {
        return view('scan.index');
    }

    // Menampilkan halaman scan dengan kamera
    public function showCameraPage()
    {
        return view('scan.camera');
    }

    // Memproses hasil scan
    public function processScan(Request $request)
    {
        $request->validate([
            'unique_sample_id' => 'required|string|exists:stocks,unique_sample_id',
        ]);

        $stock = Stock::where('unique_sample_id', $request->unique_sample_id)->firstOrFail();
        $user = Auth::user();
        $action = '';
        $newStatus = '';

        // Tentukan aksi berdasarkan role (disini kita asumsikan 'admin' bisa melakukan semua)
        // Anda bisa menambahkan role 'admin_gudang', 'admin_scrap' di tabel users jika diperlukan
        if ($request->has('scan_type')) {
            switch ($request->scan_type) {
                case 'gudang':
                    if ($stock->status != 'Di Gudang') {
                        $action = 'Diterima di Gudang Sampel';
                        $newStatus = 'Di Gudang';
                    } else {
                        return back()->with('error', 'Sampel ini sudah berada di Gudang.');
                    }
                    break;
                case 'scrap':
                    if ($stock->status != 'Dibuang') {
                        $action = 'Dibuang/Scrap';
                        $newStatus = 'Dibuang';
                    } else {
                        return back()->with('error', 'Sampel ini sudah berstatus Dibuang.');
                    }
                    break;
                default:
                    return back()->with('error', 'Jenis scan tidak valid.');
            }
        } else {
            return back()->with('error', 'Pilih tipe scan terlebih dahulu.');
        }

        // Update status stok
        $stock->update(['status' => $newStatus]);

        // Catat riwayat
        StockHistory::create([
            'stock_id' => $stock->id,
            'user_id' => $user->id,
            'action' => $action,
        ]);

        return back()->with('success', "Status sampel {$stock->unique_sample_id} berhasil diperbarui menjadi '{$newStatus}'.");
    }
}
