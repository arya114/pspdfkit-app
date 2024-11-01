<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit PDF Document</title>
    <link rel="stylesheet" href="{{ asset('metronic/assets/css/style.bundle.css') }}">
    <style>
        body {
            background-color: #f8f9fa; /* Warna latar belakang abu-abu terang */
            color: white; /* Warna teks hitam */
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            padding: 20px;
        }

        /* Bagian Kontrol */
        .controls {
            position: sticky;
            top: 20px;
            max-width: 220px;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff; /* Latar belakang putih untuk kontrol */
        }

        .controls h1 {
            font-size: 20px;
            margin-bottom: 10px;
            text-align: center;
            color: black; /* Warna judul biru */
        }

        .signature-fields {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
        }

        .signature-fields button {
            border-radius: 5px; /* Sudut melengkung untuk tombol */
        }

        .pdf-container {
            flex-grow: 1;
            overflow-y: auto; /* Menyediakan scrolling untuk konten PDF */
            border: 1px solid #ddd; /* Border untuk kontainer PDF */
            background-color: #fff; /* Latar belakang putih untuk konten PDF */
            padding: 10px; /* Memberikan padding untuk konten */
        }

        .pdf-page {
            border: 1px solid #ddd;
            width: 100%;
            max-width: 800px;
            margin: 10px auto;
            display: block;
            position: relative;
            background-color: #fff; /* Latar belakang putih untuk halaman PDF */
        }

        #signature-pad {
            display: none;
            border: 1px solid #333;
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: white;
            z-index: 10;
            cursor: move;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>

<body>

    <!-- Include Header -->
    @include('components.header')

    <div class="container">
        <!-- Bagian Kontrol Tanda Tangan -->
        <div class="controls">
            <h1>Sign Document</h1>
            <label for="signers">Signers</label>
            <div class="signature-fields">
                <button id="add-signature" class="btn btn-dark btn-active-dark">Tambah Tanda Tangan</button>
                <button id="enable-draw-mode" class="btn btn-dark btn-active-dark">Edit Tanda Tangan</button>
                <button id="enable-drag-mode" class="btn btn-dark btn-active-dark" style="display:none;">Letakkan Tanda Tangan</button>
                <button id="save-signature" class="btn btn-dark btn-active-dark">Tempelkan Tanda Tangan</button>
                <button id="download-pdf" class="btn btn-dark btn-active-dark">Download PDF</button>
            </div>
        </div>

        <!-- Kontainer untuk halaman PDF -->
        <div class="pdf-container" id="pdf-container"></div>
        <canvas id="signature-pad" width="200" height="100"></canvas>
    </div>

    <script>
        const url = "{{ Storage::url($pdfFile->path) }}";
        console.log("PDF URL:", url);

        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

        const pdfContainer = document.getElementById('pdf-container');
        const signaturePadCanvas = document.getElementById('signature-pad');
        const signaturePad = new SignaturePad(signaturePadCanvas);

        let pdfDoc = null,
            scale = 1.5,
            isDragging = false,
            offsetX, offsetY,
            isDrawMode = false;

        // Fungsi untuk merender semua halaman PDF
        function renderAllPages() {
            for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
                pdfDoc.getPage(pageNum).then(page => {
                    const viewport = page.getViewport({
                        scale: scale
                    });

                    // Buat canvas untuk setiap halaman
                    const canvas = document.createElement("canvas");
                    canvas.className = "pdf-page";
                    canvas.width = viewport.width;
                    canvas.height = viewport.height;
                    pdfContainer.appendChild(canvas);

                    // Render halaman ke dalam canvas
                    const ctx = canvas.getContext("2d");
                    const renderContext = {
                        canvasContext: ctx,
                        viewport: viewport
                    };
                    page.render(renderContext);
                });
            }
        }

        pdfjsLib.getDocument(url).promise.then(pdfDoc_ => {
            pdfDoc = pdfDoc_;
            renderAllPages();
        }).catch(error => {
            console.error("Error loading PDF:", error);
        });

        // Tombol Add Signature
        document.getElementById('add-signature').addEventListener('click', () => {
            signaturePadCanvas.style.display = 'block';
            signaturePadCanvas.style.top = '20px';
            signaturePadCanvas.style.left = '20px';
            signaturePad.clear();
            enableDrawMode(); // Default ke mode menggambar saat tanda tangan ditambahkan
        });

        // Tombol untuk mengaktifkan mode menggambar
        document.getElementById('enable-draw-mode').addEventListener('click', () => {
            enableDrawMode();
        });

        // Tombol untuk mengaktifkan mode drag
        document.getElementById('enable-drag-mode').addEventListener('click', () => {
            enableDragMode();
        });

        // Fungsi untuk mengaktifkan mode menggambar
        function enableDrawMode() {
            isDrawMode = true;
            signaturePadCanvas.style.cursor = 'crosshair';
            signaturePad.on(); // Aktifkan mode menggambar
            signaturePadCanvas.style.backgroundColor = 'white'; // Set background untuk mode menggambar
            signaturePadCanvas.style.border = '1px solid #333'; // Set border untuk membedakan area tanda tangan
            document.getElementById('enable-drag-mode').style.display = 'block';
            document.getElementById('enable-draw-mode').style.display = 'none';
        }

        // Fungsi untuk mengaktifkan mode drag
        function enableDragMode() {
            isDrawMode = false;
            signaturePadCanvas.style.cursor = 'move';
            signaturePad.off(); // Nonaktifkan mode menggambar
            signaturePadCanvas.style.backgroundColor = 'transparent'; // Hilangkan background saat mode drag
            signaturePadCanvas.style.border = 'none'; // Hilangkan border saat mode drag
            document.getElementById('enable-drag-mode').style.display = 'none';
            document.getElementById('enable-draw-mode').style.display = 'block';
        }

        // Drag tanda tangan hanya jika dalam mode drag
        signaturePadCanvas.addEventListener('mousedown', (e) => {
            if (!isDrawMode) {
                isDragging = true;
                offsetX = e.clientX - signaturePadCanvas.getBoundingClientRect().left;
                offsetY = e.clientY - signaturePadCanvas.getBoundingClientRect().top;
            }
        });

        document.addEventListener('mousemove', (e) => {
            if (isDragging && !isDrawMode) {
                const x = e.clientX - offsetX;
                const y = e.clientY - offsetY;
                signaturePadCanvas.style.left = `${x}px`;
                signaturePadCanvas.style.top = `${y}px`;
            }
        });

        document.addEventListener('mouseup', () => {
            isDragging = false;
        });

        document.getElementById('save-signature').addEventListener('click', () => {
            if (signaturePad.isEmpty()) {
                alert("Please provide a signature first.");
                return;
            }

            const signatureData = signaturePad.toDataURL();
            const image = new Image();
            image.src = signatureData;

            // Tentukan halaman tempat tanda tangan ditempatkan (contoh: halaman pertama)
            const firstPageCanvas = document.querySelector(".pdf-page");

            image.onload = function() {
                // Ambil bounding box dari halaman PDF dan signature pad
                const canvasRect = firstPageCanvas.getBoundingClientRect();
                const signatureRect = signaturePadCanvas.getBoundingClientRect();

                // Hitung posisi x dan y dengan mempertimbangkan skala halaman PDF
                const x = (signatureRect.left - canvasRect.left) * (firstPageCanvas.width / canvasRect.width);
                const y = (signatureRect.top - canvasRect.top) * (firstPageCanvas.height / canvasRect.height);

                // Dapatkan konteks dari halaman PDF yang dipilih
                const ctx = firstPageCanvas.getContext("2d");

                // Gambar tanda tangan pada halaman PDF dengan skala yang sesuai
                ctx.drawImage(
                    image,
                    x,
                    y,
                    signatureRect.width * (firstPageCanvas.width / canvasRect.width),
                    signatureRect.height * (firstPageCanvas.height / canvasRect.height)
                );

                // Sembunyikan canvas tanda tangan setelah disimpan
                signaturePadCanvas.style.display = 'none';
                signaturePad.clear();
            };
        });

        document.getElementById('download-pdf').addEventListener('click', () => {
            const {
                jsPDF
            } = window.jspdf;
            const pdf = new jsPDF();

            const canvases = document.querySelectorAll(".pdf-page");
            canvases.forEach((canvas, index) => {
                if (index > 0) pdf.addPage();
                const imgData = canvas.toDataURL("image/png");
                pdf.addImage(imgData, 'PNG', 0, 0, pdf.internal.pageSize.getWidth(), pdf.internal.pageSize.getHeight());
            });

            pdf.save("signed_document.pdf");
        });
    </script>
</body>

</html>
