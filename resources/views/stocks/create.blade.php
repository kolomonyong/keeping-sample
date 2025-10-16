@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold text-gray-800 mb-6">Tambah Stok Baru</h1>

<div class="bg-white p-6 rounded-lg shadow">
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('stocks.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="rack_id" class="block mb-2">Nomor/Kode Rak (Opsional)</label>
                <select name="rack_id" id="rack_id" class="w-full border p-2 rounded">
                    <option value="">Pilih Rak</option>
                    @foreach($racks as $rack)
                    <option value="{{ $rack->id }}">{{ $rack->code }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="product_type_id" class="block mb-2">Jenis Susu</label>
                <select name="product_type_id" id="product_type_id" class="w-full border p-2 rounded" required>
                    <option value="">Pilih Jenis Susu</option>
                     @foreach($productTypes as $type)
                    <option value="{{ $type->id }}" data-shelf-life="{{ $type->shelf_life_days }}">
                    {{ $type->name }}</option>
                    @endforeach
                </select>   
            </div>
            <div>
                <label for="production_code" class="block mb-2">Kode Produksi</label>
                <input type="text" name="production_code" id="production_code" class="w-full border p-2 rounded" required value="{{ old('production_code') }}">
            </div>
            <div>
                <label for="batch" class="block mb-2">Batch</label>
                <input type="text" name="batch" id="batch" class="w-full border p-2 rounded" value="{{ old('batch') }}" />
            </div>
            <div>
                <label for="quantity" class="block mb-2">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="w-full border p-2 rounded" required value="{{ old('quantity', 1) }}" min="1">
            </div>
            <div>
                <label for="production_date" class="block mb-2">Tanggal Produksi</label>
                <input type="date" name="production_date" id="production_date" class="w-full border p-2 rounded" required value="{{ old('production_date') }}">
            </div>
            <div>
                <label for="expiration_date" class="block mb-2">Tanggal Kedaluwarsa</label>
                <input type="date" name="expiration_date" id="expiration_date" class="w-full border p-2 rounded" required value="{{ old('expiration_date') }}">
            </div>
            <div class="md:col-span-2">
                <label for="remark" class="block mb-2">Remark (Catatan Deviasi)</label>
                <textarea name="remark" id="remark" rows="3" class="w-full border p-2 rounded" placeholder="Contoh: kemasan sedikit penyok, dll.">{{ old('remark') }}</textarea>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan Stok</button>
            <a href="{{ route('stocks.index') }}" class="text-gray-600 ml-4">Batal</a>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productTypeSelect = document.getElementById('product_type_id');
        const productionDateInput = document.getElementById('production_date');
        const expirationDateInput = document.getElementById('expiration_date');

        function updateExpirationDate() {
            const selectedOption = productTypeSelect.options[productTypeSelect.selectedIndex];
            const shelfLifeDays = parseInt(selectedOption.getAttribute('data-shelf-life') || 0);
            const productionDate = new Date(productionDateInput.value);

            if (!isNaN(productionDate.getTime()) && shelfLifeDays > 0) {
                const expirationDate = new Date(productionDate);
                expirationDate.setDate(productionDate.getDate() + shelfLifeDays);

                expirationDateInput.value = expirationDate.toISOString().split('T')[0];
            }
        }

        productTypeSelect.addEventListener('change', updateExpirationDate);
        productionDateInput.addEventListener('change', updateExpirationDate);
    });
</script>


