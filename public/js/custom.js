let selectedFiles = []; // Array untuk menyimpan file yang dipilih

function showPreview(event) {
    selectedFiles = Array.from(event.target.files); // Simpan file yang dipilih ke dalam array
    updatePreview(); // Tampilkan preview
}

function updatePreview() {
    const fileList = document.getElementById('file-preview');
    fileList.innerHTML = ""; // Bersihkan preview sebelumnya

    selectedFiles.forEach((file, index) => {
        const listItem = document.createElement('li');
        listItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');

        // Menambahkan nama file, ukuran, dan tombol hapus
        listItem.innerHTML = `
            <span>${file.name} (${(file.size / 1024).toFixed(2)} KB)</span>
            <button type="button" class="btn btn-sm btn-dark" onclick="removeFile(${index})">Hapus</button>
        `;

        fileList.appendChild(listItem);
    });
}

function removeFile(index) {
    selectedFiles.splice(index, 1); // Hapus file dari array
    updatePreview(); // Perbarui tampilan preview
    document.getElementById('file-upload').value = ""; // Reset input file
}

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

function renderAllPages() {
    for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
        pdfDoc.getPage(pageNum).then(page => {
            const viewport = page.getViewport({ scale: scale });
            const canvas = document.createElement("canvas");
            canvas.className = "pdf-page";
            canvas.width = viewport.width;
            canvas.height = viewport.height;
            pdfContainer.appendChild(canvas);
            const ctx = canvas.getContext("2d");
            const renderContext = { canvasContext: ctx, viewport: viewport };
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

document.getElementById('add-signature').addEventListener('click', () => {
    signaturePadCanvas.style.display = 'block';
    signaturePadCanvas.style.top = '20px';
    signaturePadCanvas.style.left = '20px';
    signaturePad.clear();
    enableDrawMode();
});

document.getElementById('enable-draw-mode').addEventListener('click', () => {
    enableDrawMode();
});

document.getElementById('enable-drag-mode').addEventListener('click', () => {
    enableDragMode();
});

function enableDrawMode() {
    isDrawMode = true;
    signaturePadCanvas.style.cursor = 'crosshair';
    signaturePad.on();
    signaturePadCanvas.style.backgroundColor = 'white';
    signaturePadCanvas.style.border = '1px solid #333';
    document.getElementById('enable-drag-mode').style.display = 'block';
    document.getElementById('enable-draw-mode').style.display = 'none';
}

function enableDragMode() {
    isDrawMode = false;
    signaturePadCanvas.style.cursor = 'move';
    signaturePad.off();
    signaturePadCanvas.style.backgroundColor = 'transparent';
    signaturePadCanvas.style.border = 'none';
    document.getElementById('enable-drag-mode').style.display = 'none';
    document.getElementById('enable-draw-mode').style.display = 'block';
}

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

    const firstPageCanvas = document.querySelector(".pdf-page");

    image.onload = function () {
        const canvasRect = firstPageCanvas.getBoundingClientRect();
        const signatureRect = signaturePadCanvas.getBoundingClientRect();

        const x = (signatureRect.left - canvasRect.left) * (firstPageCanvas.width / canvasRect.width);
        const y = (signatureRect.top - canvasRect.top) * (firstPageCanvas.height / canvasRect.height);

        const ctx = firstPageCanvas.getContext("2d");
        ctx.drawImage(
            image,
            x,
            y,
            signatureRect.width * (firstPageCanvas.width / canvasRect.width),
            signatureRect.height * (firstPageCanvas.height / canvasRect.height)
        );

        signaturePadCanvas.style.display = 'none';
        signaturePad.clear();
    };
});

document.getElementById('download-pdf').addEventListener('click', () => {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF();

    const canvases = document.querySelectorAll(".pdf-page");
    canvases.forEach((canvas, index) => {
        if (index > 0) pdf.addPage();
        const imgData = canvas.toDataURL("image/png");
        pdf.addImage(imgData, 'PNG', 0, 0, pdf.internal.pageSize.getWidth(), pdf.internal.pageSize.getHeight());
    });

    pdf.save("signed_document.pdf");
});
