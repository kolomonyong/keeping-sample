@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <h1 class="text-xl font-bold mb-4">Scan Sampel dengan Kamera</h1>

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

            <div class="mb-4">
                <!-- Added collapsible scanner container -->
                <div id="scanner-container" class="relative border-2 border-dashed border-gray-300 rounded-md"
                    style="display: none; max-height: 240px; overflow: hidden;">
                    <div id="interactive" class="viewport w-full h-48"></div>
                    <div id="loadingMessage"
                        class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-80">
                        <p>Memuat kamera...</p>
                    </div>
                </div>
            </div>

            <form id="scan-form" action="{{ route('scan.process') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="unique_sample_id" class="block mb-1 font-semibold text-sm">ID Sampel (Hasil Scan)</label>
                    <input type="text" name="unique_sample_id" id="unique_sample_id"
                        class="w-full border p-2 rounded-md text-center font-mono" required>
                </div>

                <div class="mb-4">
                    <p class="font-semibold mb-1 text-sm">Pilih Aksi:</p>
                    <div class="flex justify-center space-x-2 text-sm">
                        <label class="flex items-center p-2 border rounded-lg cursor-pointer">
                            <input type="radio" name="scan_type" value="gudang" class="mr-1" checked>
                            <span>Terima di Gudang</span>
                        </label>
                        <label class="flex items-center p-2 border rounded-lg cursor-pointer">
                            <input type="radio" name="scan_type" value="scrap" class="mr-1">
                            <span>Buang / Scrap</span>
                        </label>
                    </div>
                </div>

                <button type="submit" id="submit-button"
                    class="w-full bg-blue-500 text-white py-2 rounded-md font-bold hover:bg-blue-600"
                    disabled>Proses</button>
            </form>

            <div class="mt-4 flex justify-center space-x-4">
                <button id="toggle-camera" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300 flex-grow-0">
                    Aktifkan Kamera
                </button>
                <a href="{{ route('scan.page') }}"
                    class="px-4 py-2 border border-blue-500 text-blue-500 rounded-md hover:bg-blue-50 flex-grow-0">
                    Input Manual
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/quagga@0.12.1/dist/quagga.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scannerContainer = document.getElementById('scanner-container');
            const loadingMessage = document.getElementById('loadingMessage');
            const toggleCameraButton = document.getElementById('toggle-camera');
            const uniqueSampleIdInput = document.getElementById('unique_sample_id');
            const submitButton = document.getElementById('submit-button');
            let quaggaInitialized = false;

            function initQuagga() {
                if (quaggaInitialized) {
                    Quagga.stop();
                    quaggaInitialized = false;
                    toggleCameraButton.textContent = 'Aktifkan Kamera';
                    loadingMessage.style.display = 'flex';
                    loadingMessage.innerHTML = '<p>Kamera dimatikan</p>';
                    // Hide scanner container when camera is turned off
                    scannerContainer.style.display = 'none';
                    return;
                }

                // Show scanner container when camera is activated
                scannerContainer.style.display = 'block';
                loadingMessage.style.display = 'flex';
                loadingMessage.innerHTML = '<p>Memuat kamera...</p>';

                Quagga.init({
                    inputStream: {
                        name: "Live",
                        type: "LiveStream",
                        target: document.querySelector('#interactive'),
                        constraints: {
                            facingMode: "environment", // use rear camera on mobile
                            aspectRatio: {
                                min: 1,
                                max: 2
                            }
                        },
                    },
                    decoder: {
                        readers: [
                            "code_128_reader",
                            "ean_reader",
                            "ean_8_reader",
                            "code_39_reader",
                            "code_93_reader",
                            "upc_reader",
                            "upc_e_reader",
                            "codabar_reader",
                            "i2of5_reader"
                        ],
                        debug: {
                            // Reduced debug visuals for a cleaner UI
                            showCanvas: true,
                            showPatches: false,
                            showFoundPatches: false,
                            showSkeleton: false,
                            showLabels: false,
                            showPatchLabels: false,
                            showRemainingPatchLabels: false,
                            boxFromPatches: {
                                showTransformed: false,
                                showTransformedBox: true,
                                showBB: true
                            }
                        }
                    },
                }, function(err) {
                    if (err) {
                        console.error(err);
                        loadingMessage.innerHTML =
                            '<p class="text-red-500">Gagal memuat kamera. Silakan periksa izin kamera.</p>';
                        return;
                    }
                    loadingMessage.style.display = 'none';
                    toggleCameraButton.textContent = 'Matikan Kamera';
                    quaggaInitialized = true;
                    Quagga.start();
                });

                Quagga.onDetected(function(result) {
                    if (result && result.codeResult && result.codeResult.code) {
                        const code = result.codeResult.code;
                        uniqueSampleIdInput.value = code;
                        submitButton.disabled = false;

                        // Add a visual feedback
                        const feedbackDiv = document.createElement('div');
                        feedbackDiv.classList.add('bg-green-500', 'text-white', 'p-4', 'rounded-md',
                            'absolute', 'top-0', 'left-0', 'right-0', 'text-center');
                        feedbackDiv.textContent = 'Barcode terdeteksi: ' + code;
                        scannerContainer.appendChild(feedbackDiv);

                        setTimeout(() => {
                            if (feedbackDiv.parentNode) {
                                feedbackDiv.parentNode.removeChild(feedbackDiv);
                            }
                        }, 3000);
                    }
                });
            }

            toggleCameraButton.addEventListener('click', initQuagga);

            // Clean up on page unload
            window.addEventListener('beforeunload', function() {
                if (quaggaInitialized) {
                    Quagga.stop();
                }
            });
        });
    </script>
@endsection
