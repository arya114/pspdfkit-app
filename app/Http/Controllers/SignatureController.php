<?php

namespace App\Http\Controllers;

use App\Models\PdfFile;
use Illuminate\Http\Request;

class SignatureController extends Controller
{
    /**
     * Menampilkan halaman tanda tangan untuk file PDF yang dipilih.
     *
     * @param  int  $id  ID file PDF yang akan ditandatangani
     * @return \Illuminate\View\View
     */
    public function signature($id)
    {
        // Cari file PDF berdasarkan ID
        $pdfFile = PdfFile::findOrFail($id);

        // Mengambil semua file PDF yang memiliki tanda tangan
        $signatures = PdfFile::whereNotNull('signature')->get();

        // Kembalikan view dengan data file PDF dan tanda tangan
        return view('signature_pdf', compact('pdfFile', 'signatures'));
    }
}
