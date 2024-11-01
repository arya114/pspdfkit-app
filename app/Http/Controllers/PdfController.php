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
        // Validasi file upload
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

        // Redirect berdasarkan hasil upload
        if ($file) {
            return redirect()->route('pdf.signature', ['id' => $file->id])
                ->with('success', 'File berhasil diunggah. Anda sekarang dapat menandatangani file tersebut.');
        } else {
            return back()->with('error', 'File gagal diunggah.');
        }
    }
}
