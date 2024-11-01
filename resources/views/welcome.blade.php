<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah Dokumen untuk Ditandatangani</title>
    <link rel="stylesheet" href="{{ asset('metronic/assets/css/style.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> <!-- Custom CSS -->
</head>
<body>

    <!-- Include Header -->
    @include('components.header')

    <!-- Form Upload -->
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card w-400 p-4">
            <h2 class="text-center text-dark">Apa yang perlu ditandatangani?</h2>
            <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="upload-box mb-3">
                    <label for="file-upload" class="text-muted">Seret file Anda ke sini atau <span class="text-dark">Pilih File</span></label>
                    <input id="file-upload" type="file" name="pdf" accept=".pdf" required onchange="showPreview(event)">
                    <p class="mt-2 text-muted">File harus berupa PDF dengan ukuran maksimum 25 MB.</p>
                </div>
                <button type="submit" class="btn btn-dark w-100">Unggah</button>
            </form>

            <!-- Preview sementara untuk file yang dipilih -->
            <h5 class="mt-4 text-dark">Preview File yang Dipilih:</h5>
            <ul class="list-group" id="file-preview">
                <!-- Preview file akan ditampilkan di sini -->
            </ul>
        </div>
    </div>

    <script src="{{ asset('metronic/assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script> <!-- Custom JS -->
</body>
</html>
