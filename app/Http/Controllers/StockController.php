<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Rack;
use App\Models\ProductType;
use App\Models\StockHistory;
use App\Models\DefectiveProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $stocks = Stock::with(['rack', 'productType'])
            ->latest()
            ->get();

        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        $racks = Rack::orderBy('code')->get();
        $productTypes = ProductType::orderBy('name')->get();
        return view('stocks.create', compact('racks', 'productTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rack_id' => 'nullable|exists:racks,id',
            'product_type_id' => 'required|exists:product_types,id',
            'production_code' => 'required|string|max:255',
            'batch' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1',
            'production_date' => 'required|date',
            'expiration_date' => 'required|date|after_or_equal:production_date',
            'remark' => 'nullable|string',
        ]);

        $stock = Stock::create($request->all());

        // Generate Unique Sample ID
        $uniqueId = 'SMPL-' . now()->format('Ymd') . '-' . str_pad($stock->id, 4, '0', STR_PAD_LEFT);
        $stock->update(['unique_sample_id' => $uniqueId]);

        // Catat riwayat pertama
        StockHistory::create([
            'stock_id' => $stock->id,
            'user_id' => Auth::id(),
            'action' => 'Sampel Dibuat oleh Produksi',
        ]);

        return redirect()->route('stocks.print-barcode', $stock)->with('success', 'Stok baru berhasil dibuat. Silakan cetak barcode.');
    }

    public function edit(Stock $stock)
    {
        $racks = Rack::orderBy('code')->get();
        $productTypes = ProductType::orderBy('name')->get();
        return view('stocks.edit', compact('stock', 'racks', 'productTypes'));
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'rack_id' => 'nullable|exists:racks,id',
            'product_type_id' => 'required|exists:product_types,id',
            'production_code' => 'required|string|max:255',
            'batch' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'production_date' => 'required|date',
            'expiration_date' => 'required|date|after_or_equal:production_date',
            'remark' => 'nullable|string',
        ]);

        $stock->update($request->all());

        return redirect()->route('stocks.index')->with('success', 'Stok berhasil diperbarui.');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();

        return redirect()->route('stocks.index')->with('success', 'Stok berhasil dihapus.');
    }

    public function showReportDeviationForm(Stock $stock)
    {
        return view('stocks.report_deviation', compact('stock'));
    }

    // Menyimpan laporan deviasi
    public function storeReportDeviation(Request $request, Stock $stock)
    {
        $request->validate([
            'remark' => 'required|string',
        ]);

        DB::transaction(function () use ($request, $stock) {
            // 1. Buat catatan di tabel produk cacat
            DefectiveProduct::create([
                'stock_id' => $stock->id,
                'reason' => $request->remark,
                'reported_by_id' => Auth::id(), // <-- Menyimpan ID pengguna yang login
            ]);

            // 2. Update kolom remark di stok yang bersangkutan
            $stock->update([
                'remark' => $request->remark,
            ]);
        });

        return redirect()->route('stocks.index')->with('success', 'Laporan deviasi berhasil disimpan.');
    }

    // Metode baru untuk menampilkan halaman cetak barcode
    public function printBarcode(Stock $stock)
    {
        return view('stocks.print_barcode', compact('stock'));
    }

    // Metode baru untuk menampilkan riwayat stok
    public function history(Stock $stock)
    {
        $stock->load('histories.user');
        return view('stocks.history', compact('stock'));
    }
}
