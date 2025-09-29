<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home');
});

// Public Property Routes
Route::get('/imoveis', function () {
    return view('properties.index');
})->name('properties.index');

Route::get('/imovel/{property:slug}', function (\App\Models\Property $property) {
    return view('properties.show', compact('property'));
})->name('properties.show');

// Legal Pages
Route::get('/politica-privacidade', function () {
    return view('legal.privacy');
})->name('legal.privacy');

Route::get('/termos-uso', function () {
    return view('legal.terms');
})->name('legal.terms');

Route::get('/politica-cookies', function () {
    return view('legal.cookies');
})->name('legal.cookies');

// Sitemap
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index']);
