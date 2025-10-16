<div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="p-3 text-left">Kode Rak</th>
                <th class="p-3 text-left">Jenis Susu</th>
                <th class="p-3 text-left">Kode Produksi</th>
                <th class="p-3 text-left">Tgl Kedaluwarsa</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stocks as $stock)
            <tr class="border-b {{ $type === 'expired' ? 'bg-red-50' : '' }}">
                <td class="p-3">{{ $stock->rack->code ?? 'N/A' }}</td>
                <td class="p-3">{{ $stock->productType->name }}</td>
                <td class="p-3">{{ $stock->production_code }}</td>
                <td class="p-3 font-medium {{ $type === 'expired' ? 'text-red-600' : 'text-orange-600' }}">{{ $stock->expiration_date }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="p-3 text-center text-gray-500">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>