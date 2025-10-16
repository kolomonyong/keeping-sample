@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto">
        <div class="bg-white p-8 rounded-lg shadow-md text-center">
            <h1 class="text-2xl font-bold mb-6">Scan Sampel</h1>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('scan.process') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="unique_sample_id" class="block mb-2 font-semibold">ID Sampel (Hasil Scan)</label>
                    <input type="text" name="unique_sample_id" id="unique_sample_id"
                        class="w-full border p-3 rounded-md text-center text-lg font-mono" required autofocus>
                </div>

                <div class="mb-6">
                    <p class="font-semibold mb-2">Pilih Aksi:</p>
                    <div class="flex justify-center space-x-4">
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer">
                            <input type="radio" name="scan_type" value="gudang" class="mr-2" checked>
                            <span>Terima di Gudang</span>
                        </label>
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer">
                            <input type="radio" name="scan_type" value="scrap" class="mr-2">
                            <span>Buang / Scrap</span>
                        </label>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-blue-500 text-white py-3 rounded-md text-lg font-bold hover:bg-blue-600">Proses</button>
            </form>

            <div class="mt-6">
                <a href="{{ route('scan.camera') }}" class="text-blue-500 hover:underline">
                    Scan dengan Kamera
                </a>
            </div>
        </div>
    </div>
    <script>
        // Agar kursor selalu fokus ke input field setelah submit
        document.addEventListener('DOMContentLoaded', function() {
            const inputField = document.getElementById('unique_sample_id');
            if (inputField) {
                inputField.focus();
                inputField.select();
            }
        });
    </script>
@endsection
