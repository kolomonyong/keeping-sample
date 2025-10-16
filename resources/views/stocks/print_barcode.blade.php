@extends('layouts.app')

@section('styles')
    <style>
        /* Ensure barcode images scale properly */
        .barcode-container img {
            max-width: 100%;
            height: auto;
        }

        /* Print-specific styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .barcode-container {
                width: 100%;
                text-align: center;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto text-center">
        <h1 class="text-2xl font-bold mb-4">Cetak Barcode Sampel</h1>
        <p class="mb-2">Stok berhasil dibuat dengan ID Unik:</p>
        <p class="text-3xl font-mono font-bold mb-6">{{ $stock->unique_sample_id }}</p>

        <div class="p-4 border rounded-md mx-auto" style="max-width: 100%; overflow-x: auto;">
            <div class="barcode-container inline-block">
                {!! DNS1D::getBarcodeHTML($stock->unique_sample_id, 'C128', 2, 60) !!}
                <p class="font-mono tracking-widest mt-2">{{ $stock->unique_sample_id }}</p>
            </div>
        </div>

        <div class="mt-8">
            <h2 class="font-semibold">Detail Sampel:</h2>
            <p>{{ $stock->productType->name }}</p>
            <p>Batch: {{ $stock->batch ?? 'N/A' }} | Qty: {{ $stock->quantity }}</p>
            <p>EXP: {{ $stock->expiration_date }}</p>
        </div>

        <div class="mt-8 no-print">
            <button onclick="window.print()" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Cetak
                Label</button>
            <a href="{{ route('stocks.index') }}" class="ml-4 text-gray-600">Kembali ke Manajemen Stok</a>
        </div>
    </div>
@endsection
