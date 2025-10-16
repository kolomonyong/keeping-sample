<?php

namespace App\Http\Controllers;

use App\Models\DefectiveProduct;
use Illuminate\Http\Request;

class DefectiveProductController extends Controller
{
    public function index()
    {
        $reports = DefectiveProduct::with(['stock.rack', 'stock.productType', 'reportedBy']) // <-- Menambahkan relasi 'reportedBy'
            ->latest('reported_at')
            ->paginate(15);

        return view('defective.index', compact('reports'));
    }

    public function confirm(DefectiveProduct $report)
    {
        $report->delete();
        return redirect()->route('defective-reports.index')->with('success', 'Laporan deviasi berhasil dikonfirmasi dan ditutup.');
    }
}
