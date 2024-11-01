const pdfCanvas = document.getElementById('pdf-canvas');
const signatureCanvas = document.getElementById('signature-pad');
const signaturePad = new SignaturePad(signatureCanvas);

const pdfjsLib = window['pdfjs-dist/build/pdf'];
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

const url = `{{ asset('storage/' . $path) }}`;

console.log('PDF URL:', url); // Debug URL PDF

// Render PDF dan atur ukuran canvas
pdfjsLib.getDocument(url).promise.then((pdf) => {
    console.log('PDF loaded:', pdf); // Debug PDF loaded

    pdf.getPage(1).then((page) => {
        const viewport = page.getViewport({ scale: 1.5 });

        pdfCanvas.width = viewport.width;
        pdfCanvas.height = viewport.height;
        signatureCanvas.width = viewport.width;
        signatureCanvas.height = viewport.height;

        document.getElementById('canvas_width').value = viewport.width;
        document.getElementById('canvas_height').value = viewport.height;

        const context = pdfCanvas.getContext('2d');
        const renderContext = {
            canvasContext: context,
            viewport: viewport,
        };

        page.render(renderContext).promise.then(() => {
            console.log('PDF rendered successfully'); // Debug rendering success
        }).catch((error) => {
            console.error('Error rendering page:', error); // Debug error rendering page
        });
    }).catch((error) => {
        console.error('Error loading page:', error); // Debug error loading page
    });
}).catch((error) => {
    console.error('Error loading PDF:', error); // Debug error loading PDF
    alert('Failed to load PDF. Please check the console for more details.');
});

$('#clear-signature').on('click', () => {
    signaturePad.clear();
});

$('#save-signature').on('click', () => {
    if (!signaturePad.isEmpty()) {
        const dataURL = signaturePad.toDataURL('image/png');
        $('#signature').val(dataURL);
    } else {
        alert('Please provide a signature first.');
    }
});

$('#signature-pad').draggable({
    stop: function(event, ui) {
        const posX = ui.position.left;
        const posY = ui.position.top;

        console.log('Tanda Tangan Posisi X:', posX);
        console.log('Tanda Tangan Posisi Y:', posY);

        $('#pos_x').val(posX);
        $('#pos_y').val(posY);
    }
});

function checkValues() {
    const canvasWidth = document.getElementById('canvas_width').value;
    const canvasHeight = document.getElementById('canvas_height').value;
    console.log('Canvas Width:', canvasWidth);
    console.log('Canvas Height:', canvasHeight);
}
