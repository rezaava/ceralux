<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ProductController;

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

Route::get('/',[SiteController::class,'index'])->name('index');

Route::prefix('/products')->group(function () {
   Route::get('/info/{name}',[ProductController::class,'productinfo'])->name('productinfo'); 
   Route::get('/{size}',[ProductController::class,'products'])->name('products'); 
   Route::get('/',[ProductController::class,'productsindex'])->name('productsindex'); 

});
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['fa', 'en', 'ar'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/catalogs',[ProductController::class,'catalogs'])->name('catalogs');

Route::get('/search',[SiteController::class,'search'])->name('search');

Route::get('/sellagents',[SiteController::class,'sellagents'])->name('sellagents');
Route::get('/blog/{id}',[SiteController::class,'viewblog'])->name('viewblog');

Route::get('/blog',[SiteController::class,'blog'])->name('blog');

Route::get('/aboutus',[SiteController::class,'aboutus'])->name('aboutus');

Route::get('/contact',[SiteController::class,'contact'])->name('contact');