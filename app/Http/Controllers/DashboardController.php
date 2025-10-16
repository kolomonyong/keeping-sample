<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Rack;
use App\Models\DefectiveProduct;
use Illuminate\Support\Facades\DB;

// Define constants for stock statuses
class StockStatus {
    public const IN_STORAGE = 'Di Keeping Sample';
    public const CREATED = 'Dibuat';
    public const DISPOSED = 'Di Dispose';
    public const IN_WAREHOUSE = 'Di Gudang';
    public const DISCARDED = 'Dibuang';
}

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->startOfDay();

        $expiringSoon = Stock::with(['rack', 'productType'])
            ->where('status', StockStatus::IN_STORAGE)
            ->where('expiration_date', '>=', $today)
            ->where('expiration_date', '<=', $today->copy()->addDays(30))
            ->orderBy('expiration_date', 'asc')
            ->get();

        $expired = Stock::with(['rack', 'productType'])
            ->where('status', StockStatus::IN_STORAGE)
            ->where('expiration_date', '<', $today)
            ->orderBy('expiration_date', 'desc')
            ->get();

        $kpis = [
            'total_stock' => Stock::where('status', StockStatus::IN_STORAGE)->count(),
            'total_racks' => Rack::count(),
            'expiring_soon_count' => $expiringSoon->count(),
            'expired_count' => $expired->count(),
            'deviation_reports' => DefectiveProduct::count(),
        ];

        $productCounts = Stock::where('status', StockStatus::IN_STORAGE)
            ->join('product_types', 'stocks.product_type_id', '=', 'product_types.id')
            ->select('product_types.name', DB::raw('count(*) as total'))
            ->groupBy('product_types.name')
            ->pluck('total', 'name');

        // Data baru untuk diagram deviasi
        $deviationCounts = DefectiveProduct::select(DB::raw('DATE(reported_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('total', 'date');

        return view('dashboard', compact('expiringSoon', 'expired', 'kpis', 'productCounts', 'deviationCounts'));
    }

    public function cleanupExpired()
    {
        Stock::where('status', StockStatus::IN_STORAGE)
            ->where('expiration_date', '<', now()->startOfDay())
            ->delete();

        return redirect()->route('dashboard')->with('success', 'Semua produk kedaluwarsa berhasil dihapus dari sistem.');
    }

    public function cleanupExpiringSoon()
    {
        $today = now()->startOfDay();
        Stock::where('status', StockStatus::IN_STORAGE)
            ->where('expiration_date', '>=', $today)
            ->where('expiration_date', '<=', $today->copy()->addDays(30))
            ->delete();

        return redirect()->route('dashboard')->with('success', 'Semua produk yang akan kedaluwarsa berhasil dihapus dari sistem.');
    }
}
