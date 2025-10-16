@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
@endsection

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manajemen Stok</h1>
        <a href="{{ route('stocks.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Tambah
            Stok Baru</a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="stocksTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left">Kode Rak</th>
                        <th class="p-3 text-left">Jenis Susu</th>
                        <th class="p-3 text-left">Kode Produksi</th>
                        <th class="p-3 text-left">Batch</th>
                        <th class="p-3 text-left">Qty</th>
                        <th class="p-3 text-left">Tgl Produksi</th>
                        <th class="p-3 text-left">Tgl Kedaluwarsa</th>
                        <th class="p-3 text-left">Remark</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stocks as $stock)
                        <tr class="border-b">
                            <td class="p-3">{{ $stock->rack->code ?? 'N/A' }}</td>
                            <td class="p-3">{{ $stock->productType->name }}</td>
                            <td class="p-3">{{ $stock->production_code }}</td>
                            <td class="p-3">{{ $stock->batch ?? 'N/A' }}</td>
                            <td class="p-3">{{ $stock->quantity ?? 'N/A' }}</td>
                            <td class="p-3">{{ $stock->production_date }}</td>
                            <td class="p-3">{{ $stock->expiration_date }}</td>
                            <td class="p-3">{{ $stock->remark }}</td>
                            <td class="p-3">
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full
        @if ($stock->status == 'Dibuat') bg-blue-100 text-blue-800 @endif
        @if ($stock->status == 'Di Gudang') bg-green-100 text-green-800 @endif
        @if ($stock->status == 'Dibuang') bg-gray-100 text-gray-800 @endif
    ">
                                    {{ $stock->status }}
                                </span>
                            </td>
                            <td class="p-3">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('stocks.edit', $stock) }}"
                                        class="text-blue-600 hover:underline">Edit</a>
                                    <span>|</span>
                                    <a href="{{ route('stocks.report-deviation.form', $stock) }}"
                                        class="text-yellow-600 hover:underline">Laporkan Deviasi</a>
                                    <span>|</span>
                                    <form action="{{ route('stocks.destroy', $stock) }}" method="POST"
                                        onsubmit="return confirm('Anda yakin ingin menghapus stok ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                    <span>|</span>
                                    <a href="{{ route('stocks.history', $stock) }}"
                                        class="text-gray-600 hover:underline">Riwayat</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>


    <script>
        // $(document).ready(function() {
        //     if ($('#stocksTable').length) {
        //         new DataTable('#stocksTable', {
        //             columnDefs: [{
        //                 "orderable": false,
        //                 "targets": 8
        //             }],
        //         });
        //     }
        // });
        $(document).ready(function() {
            if ($('#stocksTable').length) {
                new DataTable('#stocksTable', {
                    columnDefs: [{
                        orderable: false,
                        targets: 9 // Updated to match the 10th column (0-indexed)
                    }],
                    dom: 'Blfrtip',
                    // buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
                });
            }
        });
    </script>
@endsection
