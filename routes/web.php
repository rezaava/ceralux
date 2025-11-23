<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CRMController;
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
Route::get('/admin/dashboard',[AdminController::class,'dashboard'])->name('dashboard');

Route::get('/admin/size',[AdminController::class,'size'])->name('size');
Route::post('/admin/size/add',[AdminController::class,'sizePost']);

Route::get('/admin/product/add',[AdminController::class,'productAdd'])->name('product-add');
Route::get('/admin/product/list',[AdminController::class,'productList'])->name('product-list');
Route::post('/admin/product/add',[AdminController::class,'productPost']);

Route::get('/admin/setting',[AdminController::class,'setting'])->name('setting');
Route::get('/admin/catalog',[AdminController::class,'catalog'])->name('catalog');

Route::prefix('/products')->group(function () {
   Route::get('/info/{size_id}/{name}',[ProductController::class,'productinfo'])->name('productinfo'); 
   Route::get('/img/{pro_id}',[ProductController::class,'showImg'])->name('productinfo'); 
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

Route::get('/admin/crm/addProd',[CRMController::class,'addProd'])->name('addProd');
Route::get('/admin/crm/reqProd',[CRMController::class,'reqProd'])->name('reqProd');
Route::get('/admin/crm/reqSale',[CRMController::class,'reqSale'])->name('reqSale');