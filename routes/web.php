<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
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

Route::get('/admin/product/add/{id}',[AdminController::class,'productAdd'])->name('product-add');
Route::get('/admin/product/list',[AdminController::class,'productList'])->name('product-list');
Route::get('/admin/product/list/delete/{id}',[AdminController::class,'deleteProduct'])->name('product-list');
Route::post('/admin/product/add',[AdminController::class,'productPost']);

Route::get('/admin/setting',[AdminController::class,'setting'])->name('setting');
Route::get('/admin/catalog',[AdminController::class,'catalog'])->name('catalog');
Route::get('/admin/request',[CRMController::class,'request'])->name('req');

Route::prefix('/products')->group(function () {
   Route::get('/info/{size_id}/{name}',[ProductController::class,'productinfo'])->name('productinfo'); 
   Route::get('/img/{pro_id}',[ProductController::class,'showImg'])->name('product-list'); 
   Route::post('/add-img/{pro_id}',[ProductController::class,'addImg']); 
    Route::delete('/delete-img/{id}', [ProductController::class, 'deleteImg'])->name('products.delete-img');
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
Route::post('/admin/crm/addProd/add',[CRMController::class,'addProdPost'])->name('addProd');

Route::get('/admin/crm/reqProd',[CRMController::class,'reqProd'])->name('reqProd');
Route::post('/admin/crm/reqProd/add',[CRMController::class,'requestPost'])->name('reqProd');

Route::get('/admin/crm/listInvocie',[CRMController::class,'listInvocie'])->name('listInvocie');
Route::get('/admin/crm/show/invoice/{id}',[CRMController::class,'showInvocie']);

Route::get('/admin/crm/reqSale/{id}',[CRMController::class,'reqSale'])->name('reqSale'); 
Route::post('/admin/crm/reqSale/add',[CRMController::class,'salePost']); 
Route::post('/admin/crm/reqSale/product/add',[CRMController::class,'productAddPostCart']); 
Route::post('/admin/crm/reqSale/pay',[CRMController::class,'salePayPost']); 

Route::get('/get-customer-info/{id}', [CRMController::class, 'getCustomerInfo']);

Route::get('/admin/user/list',[CRMController::class,'listUser'])->name('listUser');
Route::get('/admin/user/add/{id}',[CRMController::class,'addUser'])->name('addUser');
Route::get('/admin/user/delete/{id}',[CRMController::class,'addUserDelete'])->name('addUser');
Route::post('/admin/user/add',[CRMController::class,'addUserPost'])->name('addUser');

Route::get('/login/admin',[AuthController::class,'login'])->name('login');
Route::post('/login/admin',[AuthController::class,'loginPost']);

Route::get('/logout/admin',[AuthController::class,'logout']);

Route::get('/admin/financial/submit/{id}',[CRMController::class,'submit'])->name('submit');
Route::get('/admin/financial/submit/show/list',[CRMController::class,'submitList'])->name('submitList1');

Route::post('/admin/financial/submit/add',[CRMController::class,'submitPost']);

Route::get('/admin/financial/received',[CRMController::class,'received'])->name('received');
Route::get('/admin/financial/pay',[CRMController::class,'pay'])->name('pay');
Route::get('/admin/financial/list',[CRMController::class,'list'])->name('listPay');

Route::post('/admin/setting/name/add',[CRMController::class,'settingPost']);

Route::get('/admin/crm/buy/add/{id}',[CRMController::class,'buy'])->name('buy');
Route::get('/admin/crm/buy/product/add',[CRMController::class,'buyaddProd']);
Route::get('/admin/crm/add/cart/buy',[CRMController::class,'buyAddToCart']);
Route::post('/admin/crm/cart/final/buy',[CRMController::class,'finalCartBuy']);

Route::get('/admin/crm/lpo/add/{id}',[CRMController::class,'lpo'])->name('lpo');
Route::post('/admin/crm/add/cart/lpo',[CRMController::class,'lpoAddCart']);
Route::post('/admin/crm/lpo/product/add',[CRMController::class,'lpoAddCartProd']);
Route::post('/admin/crm/cart/final/lpo',[CRMController::class,'lpoFinal']);


Route::get('/admin/req/leave',[CRMController::class,'reqLeave'])->name('leave');
Route::get('/admin/req/sample',[CRMController::class,'reqSample'])->name('sample');
Route::get('/admin/req/break',[CRMController::class,'reqbreak'])->name('break');

