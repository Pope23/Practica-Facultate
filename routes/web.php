<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OfferController;
use App\Http\Controllers\QuoteController;

Route::get('/', function(){
    return redirect()->route('/api/quotes');
});

Route::get('/quote/{id}', [QuoteController::class, 'show']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');
Route::get('/offers/create', [OfferController::class, 'create'])->name('offers.create');
Route::post('/offers', [OfferController::class, 'store'])->name('offers.store');
Route::get('/offers/{id}', [OfferController::class, 'show'])->name('offers.show');
Route::get('/offers/{id}/pdf', [OfferController::class, 'downloadPdf'])->name('offers.pdf');
Route::get('/offers/results', [OfferController::class, 'results'])->name('offers.results');
