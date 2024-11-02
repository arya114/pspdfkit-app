<?php

namespace App\Http\Controllers;

use App\Models\PdfFile;
use Illuminate\Http\Request;

class PdfController extends Controller
{

    //Menampilkan halaman upload untuk file PDF.
    public function index()
    {
        return view('upload');
    }

    // Mengelola proses upload file PDF.
    public function upload(Request $request)
{
    // Validasi file yang diunggah
    $request->validate([
        'pdf' => 'required|file|mimes:pdf|max:25600',
    ]);

    // Ambil nama asli file
    $fileName = $request->file('pdf')->getClientOriginalName();

    // Simpan file ke direktori 'uploads' dalam penyimpanan publik
    $path = $request->pdf->storeAs('uploads', $fileName, 'public');

    // Simpan informasi file ke database
    $file = PdfFile::create([
        'filename' => $fileName,
        'path' => $path,
    ]);

    // Kembalikan respons JSON untuk penanganan AJAX
    if ($file) {
        return response()->json([
            'success' => true,
            'message' => 'File berhasil diunggah.',
            'fileId' => $file->id,
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Gagal mengunggah file.',
        ], 500);
    }
}

}
