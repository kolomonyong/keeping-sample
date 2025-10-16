@extends('layouts.app')


@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold text-gray-800">Manajemen Stok</h1>
    <a href="{{ route('stocks.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Tambah Stok Baru</a>
</div>

@if (session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
    {{ session('success') }}
</div>
@endif

<div class="bg-white p-6 rounded-lg shadow">
    <div class="overflow-x-auto">
        <table class="w-full text-sm table table-striped table-bordered" id="tabelData" style="width:100%">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3 text-left">Kode Rak</th>
                    <th class="p-3 text-left">Jenis Susu</th>
                    <th class="p-3 text-left">Kode Produksi</th>
                    <th class="p-3 text-left">Batch</th>
                    <th class="p-3 text-left">Tgl Produksi</th>
                    <th class="p-3 text-left">Tgl Kedaluwarsa</th>
                    <th class="p-3 text-left">Remark</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stocks as $stock)
                <tr class="border-b">
                    <td class="p-3">{{ $stock->rack->code }}</td>
                    <td class="p-3">{{ $stock->productType->name }}</td>
                    <td class="p-3">{{ $stock->production_code }}</td>
                    <td class="p-3">{{ $stock->batch ?? 'N/A' }}</td>
                    <td class="p-3">{{ $stock->production_date }}</td>
                    <td class="p-3">{{ $stock->expiration_date }}</td>
                    <td class="p-3">{{ $stock->remark }}</td>
                    <td class="p-3">

                        <!-- Modal -->
                        <div id="reportModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                                <h2 class="text-lg font-semibold mb-4">Laporkan Deviasi</h2>
                                <form action="{{ route('stocks.report-defective', $stock) }}" method="POST">
                                    @csrf
                                    <label for="reason" class="block text-sm font-medium text-gray-700">Alasan:</label>
                                    <textarea id="reason" name="reason" rows="3" class="w-full border rounded-md p-2 mt-2" placeholder="Masukkan alasan..."></textarea>
                                    <div class="mt-4 flex justify-end">
                                        <button type="button" onclick="closeModal()" class="mr-2 px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                                        <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded">Laporkan</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- JavaScript untuk mengontrol modal -->
                        <script>
                            function openModal() {
                                document.getElementById('reportModal').classList.remove('hidden');
                            }

                            function closeModal() {
                                document.getElementById('reportModal').classList.add('hidden');
                            }

                            // Tambahkan event listener agar modal juga bisa ditutup dengan klik di luar kotak modal
                            window.onclick = function(event) {
                                var modal = document.getElementById('reportModal');
                                if (event.target === modal) {
                                    closeModal();
                                }
                            };
                        </script>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('stocks.edit', $stock) }}" class="text-blue-600 hover:underline">Update</a>
                            <span>|</span>
                            <button onclick="document.getElementById('reportModal').classList.remove('hidden')" class="text-yellow-600 hover:underline">Laporkan Deviasi</button>
                            <span>|</span>
                            <form action="{{ route('stocks.destroy', $stock) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus stok ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center p-3">Tidak ada data stok</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th class="p-3 text-left">Kode Rak</th>
                    <th class="p-3 text-left">Jenis Susu</th>
                    <th class="p-3 text-left">Kode Produksi</th>
                    <th class="p-3 text-left">Batch</th>
                    <th class="p-3 text-left">Tgl Produksi</th>
                    <th class="p-3 text-left">Tgl Kedaluwarsa</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- Script langsung di sini, tidak di section -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        new DataTable('#tabelData', {
            layout: {
                topStart: {
                    buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
                }
            },
            columnDefs: [{
                "orderable": false,
                "targets": -1
            }]
        });
    });
</script>

@endsection