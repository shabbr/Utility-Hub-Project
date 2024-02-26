<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\BarcodeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// https://youtu.be/P2q4Cv6yj1Q?si=NZd04gHYYaAelOmg

Route::get('/', function () {
    return view('welcome');
});



Route::get('/loading', function () {
    return view('progressBar');
});




//form to paste long url
Route::get('/shortUrl', function () {
    return view('shortUrl');
})->name('shortUrl');


//form of long url submitted and show short url
Route::post('/shorten', [LinkController::class, 'shorten'])->name('shorten');
Route::get('/redirect/{short_url}', [LinkController::class, 'redirect'])
    ->where('short_url', '.*') // Allow any character including slashes
    ->name('redirect');
    Route::get('/r/{id}', [LinkController::class, 'redirectLink'])
    ->where('short_url', '.*') // Allow any character including slashes
    ->name('redirectLink');

//QR Code generater
    Route::prefix('QR')->group(function () {
        Route::controller(QrController::class)->group(function () {
         Route::get('/qrcode','qrCodeForm')->name('qrCodeForm');
           Route::post('/generate-qrcode','generateQrCode')->name('generateQrCode');
           Route::get('/download/{url}','download')->name('download');

                    });
    });

//Bar Code generator
Route::prefix('Barcode')->group(function () {
    Route::controller(BarcodeController::class)->group(function () {
        Route::get('/show-form','showForm')->name('barcode.show-form');
        Route::post('/generate-and-download','generateAndDownload')->name('barcode.generate-and-download');
        Route::get('/download/{filename}', 'downloadBarcode')->name('barcode.download');
    });
});
