@extends('layouts.app')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-2">Riwayat Sampel: {{ $stock->unique_sample_id }}</h1>
        <p class="text-gray-600 mb-6">{{ $stock->productType->name }} - Batch: {{ $stock->batch }}</p>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left">Waktu</th>
                        <th class="p-3 text-left">Aksi</th>
                        <th class="p-3 text-left">Dilakukan oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stock->histories as $history)
                        <tr class="border-b">
                            <td class="p-3">{{ $history->created_at->format('d M Y, H:i') }}</td>
                            <td class="p-3 font-semibold">{{ $history->action }}</td>
                            <td class="p-3">{{ $history->user->name }} ({{ $history->user->username }})</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center p-4">Belum ada riwayat untuk sampel ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8">
            <a href="{{ route('stocks.index') }}" class="text-blue-500 hover:underline">&larr; Kembali ke Manajemen Stok</a>
        </div>
    </div>
@endsection
