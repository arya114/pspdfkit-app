<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah Dokumen untuk Ditandatangani</title>
    <link rel="stylesheet" href="{{ asset('metronic/assets/css/style.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <!-- Include Header -->
    @include('components.header')

    <!-- Form Upload -->
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card w-400 p-4">
            <h2 class="text-center text-dark">Apa yang perlu ditandatangani?</h2>
            <form id="upload-form" action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="upload-box mb-3">
                    <label for="file-upload" class="text-muted">Seret file Anda ke sini atau <span class="text-dark">Pilih File</span></label>
                    <input id="file-upload" type="file" name="pdf" accept=".pdf" required onchange="showPreview(event)">
                    <p class="mt-2 text-muted">File harus berupa PDF dengan ukuran maksimum 25 MB.</p>
                </div>
                <button type="submit" class="btn btn-dark w-100" id="upload-button">
                    <span class="indicator-label">Unggah</span>
                    <span class="indicator-progress">
                        Mohon tunggu... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </form>

            <!-- Preview sementara untuk file yang dipilih -->
            <h5 class="mt-4 text-dark">Preview File yang Dipilih:</h5>
            <ul class="list-group" id="file-preview">
                <!-- Preview file akan ditampilkan di sini -->
            </ul>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <script src="{{ asset('metronic/assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        // Show file preview function
        function showPreview(event) {
            const file = event.target.files[0];
            const fileList = document.getElementById('file-preview');
            fileList.innerHTML = ""; // Clear previous preview
            const listItem = document.createElement('li');
            listItem.classList.add('list-group-item');
            listItem.textContent = `${file.name} (${(file.size / 1024).toFixed(2)} KB)`;
            fileList.appendChild(listItem);
        }

        // Handle form submission and display loading indicator on button
        document.getElementById('upload-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            const uploadButton = document.getElementById('upload-button');
            uploadButton.setAttribute("data-kt-indicator", "on"); // Show loading indicator

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                uploadButton.removeAttribute("data-kt-indicator"); // Hide loading indicator

                if (data.success) {
                    Swal.fire({
                        text: "File berhasil diunggah!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Oke!",
                        customClass: {
                            confirmButton: "btn btn-dark"
                        }
                    }).then(() => {
                        window.location.href = `/signature-pdf/${data.fileId}`;
                    });
                } else {
                    Swal.fire({
                        text: "Gagal mengunggah. Silakan coba lagi.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, coba lagi!",
                        customClass: {
                            confirmButton: "btn btn-danger"
                        }
                    });
                }
            })
            .catch(error => {
                uploadButton.removeAttribute("data-kt-indicator"); // Hide loading indicator
                Swal.fire({
                    text: "Terjadi kesalahan. Silakan coba lagi.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, coba lagi!",
                    customClass: {
                        confirmButton: "btn btn-danger"
                    }
                });
                console.error('Error:', error);
            });
        });
    </script>
</body>

</html>
