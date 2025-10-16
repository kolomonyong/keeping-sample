@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold text-gray-800 mb-6">Laporkan Deviasi</h1>

<div class="bg-white p-6 rounded-lg shadow">
    <div class="mb-4 p-4 border border-gray-200 rounded">
        <h3 class="font-bold">Informasi Stok</h3>
        <p><strong>Jenis Produk:</strong> {{ $stock->productType->name }}</p>
        <p><strong>Kode Produksi:</strong> {{ $stock->production_code }}</p>
        <p><strong>Batch:</strong> {{ $stock->batch ?? 'N/A' }}</p>
        <p><strong>Lokasi Rak:</strong> {{ $stock->rack->code ?? 'N/A' }}</p>
    </div>

    <form action="{{ route('stocks.report-deviation.store', $stock) }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="remark" class="block mb-2 font-medium">Alasan Deviasi / Remark</label>
                <textarea name="remark" id="remark" rows="4" class="w-full border p-2 rounded" required placeholder="Contoh: Kemasan sedikit penyok, label tergores, dll.">{{ old('remark', $stock->remark) }}</textarea>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Simpan Laporan</button>
            <a href="{{ route('stocks.index') }}" class="text-gray-600 ml-4">Batal</a>
        </div>
    </form>
</div>
@endsection