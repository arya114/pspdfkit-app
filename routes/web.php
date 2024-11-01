<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\SignatureController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/signature-pdf/{id}', [SignatureController::class, 'signature'])->name('pdf.signature');
Route::post('/', action: [PdfController::class, 'upload'])->name('upload.store');
