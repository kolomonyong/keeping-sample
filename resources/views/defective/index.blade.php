@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold text-gray-800 mb-6">Riwayat Laporan Deviasi</h1>

@if (session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
    {{ session('success') }}
</div>
@endif

<div class="bg-white p-6 rounded-lg shadow">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3 text-left">Tanggal Lapor</th>
                    <th class="p-3 text-left">Jenis Produk</th>
                    <th class="p-3 text-left">Kode Produksi</th>
                    <th class="p-3 text-left">Batch</th>
                    <th class="p-3 text-left">Alasan Deviasi</th>
                    <th class="p-3 text-left">Pelapor</th>
                    @if(auth()->user()->role == 'admin')
                    <th class="p-3 text-left">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                <tr class="border-b">
                    <td class="p-3">{{ $report->reported_at }}</td>
                    <td class="p-3">{{ $report->stock->productType->name }}</td>
                    <td class="p-3">{{ $report->stock->production_code }}</td>
                    <td class="p-3">{{ $report->stock->batch ?? 'N/A' }}</td>
                    <td class="p-3">{{ $report->reason }}</td>
                    <td class="p-3">{{ $report->reportedBy->name ?? 'N/A' }}</td>
                    @if(auth()->user()->role == 'admin')
                    <td class="p-3">
                        <form action="{{ route('defective-reports.confirm', $report) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menutup laporan ini?');">
                            @csrf
                            <button type="submit" class="text-green-600 hover:underline">Konfirmasi</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->role == 'admin' ? 7 : 6 }}" class="p-3 text-center text-gray-500">Belum ada laporan deviasi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $reports->links() }}
    </div>
</div>
@endsection