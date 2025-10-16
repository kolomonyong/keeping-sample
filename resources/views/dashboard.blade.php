@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold text-gray-800">Dashboard Utama</h1>
</div>

@if (session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
    {{ session('success') }}
</div>
@endif

{{-- Mengubah grid menjadi 5 kolom di layar besar --}}
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500">Total Stok</h3>
        <p class="text-3xl font-bold">{{ $kpis['total_stock'] }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500">Total Rak</h3>
        <p class="text-3xl font-bold">{{ $kpis['total_racks'] }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500">Laporan Deviasi</h3>
        <p class="text-3xl font-bold text-yellow-500">{{ $kpis['deviation_reports'] }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500">Akan Kedaluwarsa</h3>
        <p class="text-3xl font-bold text-orange-500">{{ $kpis['expiring_soon_count'] }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500">Sudah Kedaluwarsa</h3>
        <p class="text-3xl font-bold text-red-500">{{ $kpis['expired_count'] }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">
        @if(auth()->user()->role == 'admin')
        <div class="flex justify-end space-x-2">
            <!-- Tombol Hapus Akan Kedaluwarsa -->
            <form action="{{ route('dashboard.cleanup-expiring-soon') }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus SEMUA produk yang AKAN kedaluwarsa dari sistem? Tindakan ini tidak dapat diurungkan.');">
                @csrf
                <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 disabled:opacity-50" @if($kpis['expiring_soon_count']==0) disabled @endif>
                    <i class="fa-solid fa-bell-slash"></i> Hapus Akan Kedaluwarsa
                </button>
            </form>

            <!-- Tombol Hapus Sudah Kedaluwarsa -->
            <form action="{{ route('dashboard.cleanup-expired') }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus SEMUA produk yang SUDAH kedaluwarsa dari sistem? Tindakan ini tidak dapat diurungkan.');">
                @csrf
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 disabled:opacity-50" @if($kpis['expired_count']==0) disabled @endif>
                    <i class="fa-solid fa-trash-can"></i> Hapus Sudah Kedaluwarsa
                </button>
            </form>
        </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="font-semibold text-lg mb-4">Produk Akan Kedaluwarsa (30 Hari)</h2>
            @include('partials.stock_table', ['stocks' => $expiringSoon, 'type' => 'expiring'])
        </div>
        <div class="bg-white p-6 rounded-lg shadow border border-red-200">
            <h2 class="font-semibold text-lg mb-4 text-red-600">Produk Sudah Kedaluwarsa</h2>
            @include('partials.stock_table', ['stocks' => $expired, 'type' => 'expired'])
        </div>
    </div>
    <div class="lg:col-span-1 space-y-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="font-semibold text-lg mb-4">Stok per Jenis Produk</h2>
            <div class="relative h-96 overflow-visible">
                <canvas id="productTypeChart"
                    data-labels="{{ json_encode($productCounts->keys()) }}"
                    data-values="{{ json_encode($productCounts->values()) }}">
                </canvas>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="font-semibold text-lg mb-4">Laporan Deviasi per Hari</h2>
            <div class="relative h-96">
                <canvas id="deviationChart"
                    data-labels="{{ json_encode($deviationCounts->keys()) }}"
                    data-values="{{ json_encode($deviationCounts->values()) }}">
                </canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Diagram Stok per Jenis Produk
        const productTypeCanvas = document.getElementById('productTypeChart');
        if (productTypeCanvas && productTypeCanvas.dataset.labels.length > 2) {
            const labels = JSON.parse(productTypeCanvas.dataset.labels);
            const values = JSON.parse(productTypeCanvas.dataset.values);

            new Chart(productTypeCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Stok',
                        data: values,
                        backgroundColor: ['#FF69B4', '#FFC107', '#8BC34A', '#03A9F4', '#4CAF50', '#F44336', '#9C27B0', '#FF9800', '#3F51B5', '#2196F3', '#4DB6AC', '#FF9800', '#FFC107', '#8BC34A', 
                        '#03A9F4', '#4CAF50', '#F44336', '#9C27B0', '#FF69B4', '#FFC107', '#8BC34A', '#03A9F4', '#4CAF50', '#F44336', '#9C27B0', '#FF69B4', '#FFC107', '#8BC34A', '#03A9F4', '#4CAF50', 
                        '#F44336', '#9C27B0', '#FF69B4', '#FFC107', '#8BC34A', '#03A9F4', '#4CAF50', '#F44336', '#9C27B4', '#FF69B4', '#FFC107', '#8BC34A', '#03A9F4', '#4CAF50', '#F44336', '#9C27B0', 
                        '#FF69B4', '#FFC107', '#8BC34A', '#03A9F4', '#4CAF50', '#F44336', '#9C27B0', '#FF69B4', '#FFC107']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }

        // Diagram Laporan Deviasi
        const deviationCanvas = document.getElementById('deviationChart');
        if (deviationCanvas && deviationCanvas.dataset.labels.length > 2) {
            const deviationLabels = JSON.parse(deviationCanvas.dataset.labels);
            const deviationValues = JSON.parse(deviationCanvas.dataset.values);

            new Chart(deviationCanvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: deviationLabels,
                    datasets: [{
                        label: 'Jumlah Laporan',
                        data: deviationValues,
                        backgroundColor: 'rgba(245, 158, 11, 0.6)',
                        borderColor: 'rgba(245, 158, 11, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection