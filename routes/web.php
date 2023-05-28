<?php

use Illuminate\Support\Facades\Route;
use App\HTTP\Controllers\HomeController;

/*
@foreach($roles as $x)  
                        
                        <option value="{{$x->id}}">{{$x->admin}}</option>
                    @endforeach  
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
    return view('welcome');
});
Route::get('generate-pdf', [HomeController::class, 'generatePDF'])->name('generatePDF');
Auth::routes();

// Admin routes with 'is_admin' middleware
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('user', HomeController::class);
    Route::get('/crud/list', [HomeController::class, 'listUsers'])->name('crud.list');
    Route::get('/admin', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin');
    Route::get('/artist/artists', [HomeController::class, 'artistsHome'])->name('artist.artists');
    Route::post('/artist/artists', [HomeController::class, 'storeArtist'])->name('artist.store');
    Route::put('/artist/{artist}', [HomeController::class, 'updateArtist'])->name('artist.update');
    Route::get('/artwork/artworks', [HomeController::class, 'artworksHome'])->name('artwork.artworks');
    Route::post('/artwork/artworks',  [HomeController::class, 'storeArtwork'])->name('artworks.store');
    Route::put('/artwork/artworks{artwork}',  [HomeController::class, 'updateArtwork'])->name('artworks.update');
    Route::get('/purchase/artworkpurchases', [HomeController::class, 'purchaseArtworkHome'])->name('purchase.artworkpurchases');
    Route::patch('/purchase/artworkpurchases/{purchase}/approve', [HomeController::class, 'approvePurchase'])->name('purchases.approve');
    Route::patch('/purchase/artworkpurchases/{purchase}/reject', [HomeController::class, 'rejectPurchase'])->name('purchases.reject');
    Route::patch('/purchase/artworkpurchases/{purchase}/cancel', [HomeController::class, 'deletePurchase'])->name('purchases.cancel');
});

// Home route for non-admin users
Route::middleware(['auth'])->group(function () {
    Route::resource('user', HomeController::class);
    Route::get('/crud/list', [HomeController::class, 'listUsers'])->name('crud.list');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/artist/artists', [HomeController::class, 'artistsHome'])->name('artist.artists');
    Route::post('/artist/artists', [HomeController::class, 'storeArtist'])->name('artist.store');
    Route::put('/artist/{artist}', [HomeController::class, 'updateArtist'])->name('artist.update');
    Route::get('/artwork/artworks', [HomeController::class, 'artworksHome'])->name('artwork.artworks');
    Route::post('/artwork/artworks',  [HomeController::class, 'storeArtwork'])->name('artworks.store');
    Route::put('/artwork/artworks{artwork}',  [HomeController::class, 'updateArtwork'])->name('artworks.update');
    Route::get('/artworks/artworks/{artwork_id}', [HomeController::class, 'purchaseArtwork'])->name('purchase_artwork');
    Route::get('/customer/customerpurchases', [HomeController::class, 'customerPurchaseHome'])->name('customer.customerpurchases');
    Route::patch('/customer/customerpurchases/{purchaseDetail}/cancel', [HomeController::class, 'cancelPurchase'])->name('cancelPurchase');
});
