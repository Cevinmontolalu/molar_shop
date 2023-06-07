<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VariantProductController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DetailTransactionController;
use App\Http\Controllers\Shop\HomeController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ShopProfileController;
use App\Http\Controllers\ShopRekeningController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BiayaPengirimanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class,'index']);
Route::GET('/login',[LoginController::class,'login'])->name('login');
Route::POST('/try_login',[LoginController::class,'login_admin']);

//should be locked
Route::group(['middleware'=>['auth']],function(){
    Route::GET('/category',[CategoryController::class,'index']);
    Route::GET('/category/create',[CategoryController::class,'create']);
    Route::GET('/category/edit/{id}',[CategoryController::class,'edit']);
    Route::POST('/category/store',[CategoryController::class,'store'])->name('category.store');
    Route::PUT('/category/update/{id}',[CategoryController::class,'update'])->name('category.update');
    Route::DELETE('/category/destroy/{id}',[CategoryController::class,'destroy']);

    Route::GET('/biaya_pengiriman',[BiayaPengirimanController::class,'index']);
    Route::GET('/biaya_pengiriman/create',[BiayaPengirimanController::class,'create']);
    Route::GET('/biaya_pengiriman/edit/{id}',[BiayaPengirimanController::class,'edit']);
    Route::POST('/biaya_pengiriman/store',[BiayaPengirimanController::class,'store']);
    Route::PUT('/biaya_pengiriman/update/{id}',[BiayaPengirimanController::class,'update']);
    Route::DELETE('/biaya_pengiriman/destroy/{id}',[BiayaPengirimanController::class,'destroy']);

    Route::GET('/subCategory',[SubCategoryController::class,'index']);
    Route::GET('/subCategory/create',[SubCategoryController::class,'create']);
    Route::GET('/subCategory/edit/{id}',[SubCategoryController::class,'edit']);
    Route::POST('/subCategory/store',[SubCategoryController::class,'store'])->name('subCategory.store');
    Route::PUT('/subCategory/update/{id}',[SubCategoryController::class,'update'])->name('subCategory.update');
    Route::DELETE('/subCategory/destroy/{id}',[SubCategoryController::class,'destroy']);

    Route::GET('/customer',[CustomerController::class,'index']);
    Route::GET('/customer/create',[CustomerController::class,'create']);
    Route::GET('/customer/edit/{id}',[CustomerController::class,'edit']);
    Route::GET('/customer/detail/{id}',[CustomerController::class,'show']);
    Route::POST('/customer/store',[CustomerController::class,'store'])->name('customer.store');
    Route::PUT('/customer/update/{id}',[CustomerController::class,'update'])->name('customer.update');
    Route::DELETE('/customer/destroy/{id}',[CustomerController::class,'destroy']);
    Route::GET('/customer/reset_password/{id}',[CustomerController::class,'reset_password']);
    Route::POST("/customer/upload_picture/{id}",[CustomerController::class,'upload_picture']);

    Route::GET('/product',[ProductController::class,'index']);
    Route::GET('/product/detail/{id}',[ProductController::class,'show']);
    Route::GET('/product/create',[ProductController::class,'create']);
    Route::GET('/product/edit/{id}',[ProductController::class,'edit']);
    Route::POST('/product/store',[ProductController::class,'store'])->name('product.store');
    Route::PUT('/product/update/{id}',[ProductController::class,'update'])->name('product.update');
    Route::DELETE('/product/destroy/{id}',[ProductController::class,'destroy']);
    Route::POST('/product/filter',[ProductController::class,'filter']);
    Route::GET('/product/clear-filter',[ProductController::class,'clearFilter']);

    Route::GET('/variant_product/create/{idProduct}',[VariantProductController::class,'create']);
    Route::GET('/variant_product/edit/{id}',[VariantProductController::class,'edit']);
    Route::POST('/variant_product/store',[VariantProductController::class,'store']);
    Route::PUT('/variant_product/update/{idVariant}',[VariantProductController::class,'update']);
    Route::DELETE('/variant_product/destroy/{idVariant}',[VariantProductController::class,'destroy']);

    Route::GET('/gallery/create/{idProduct}',[GalleryController::class,'create']);
    Route::GET('/gallery/edit/{id}',[GalleryController::class,'edit']);
    Route::POST('/gallery/store',[GalleryController::class,'store'])->name('gallery.store');
    Route::PUT('/gallery/update/{id}',[GalleryController::class,'update'])->name('gallery.update');
    Route::DELETE('/gallery/destroy/{id}',[GalleryController::class,'destroy']);

    Route::GET('/banners',[BannerController::class,'index']);
    Route::GET('/banner/create',[BannerController::class,'create']);
    Route::GET('/banner/edit/{id}',[BannerController::class,'edit']);
    Route::POST("/banner/store",[BannerController::class,'store'])->name('banner.store');
    Route::PUT('/banner/update/{id}',[BannerController::class,'update'])->name('banner.update');
    Route::DELETE('/banner/destroy/{banner}',[BannerController::class,'destroy']);
    Route::POST('/banner/update-gambar',[BannerController::class,'updateGambar']);

    Route::GET('/sub-category/category/{categoryId}',[SubCategoryController::class,'getSubCategoryByCategoryId']);

    Route::GET('/shop_rekening',[ShopRekeningController::class,'index']);
    Route::GET('/shop_rekening/create',[ShopRekeningController::class,'create']);
    Route::POST('/shop_rekening',[ShopRekeningController::class,'store']);
    Route::GET('/shop_rekening/edit/{id}',[ShopRekeningController::class,'edit']);
    Route::PUT('/shop_rekening/update',[ShopRekeningController::class,'update']);
    Route::DELETE('/shop_rekening/destroy/{id}',[ShopRekeningController::class,'destroy']);

    Route::GET('/transaction',[TransactionController::class,'getData']);
    Route::GET('/transaction/detail/{id}',[TransactionController::class,'show']);
    Route::POST("/transaction/update-status",[TransactionController::class,'updateStatus']);
    Route::POST('/transaction/filter',[TransactionController::class,'filter']);
    Route::GET('/transaction/clear-filter',[TransactionController::class,'clearFilter']);

    Route::GET('/logout',[LoginController::class,'logout_admin']);

    Route::GET('/profile',[UserController::class,'profile']);
    Route::PUT('/profile/update-password',[UserController::class,'updatePassword']);
    Route::GET("/user",[UserController::class,'index']);
    Route::GET('/user/create',[UserController::class,'create']);
    Route::GET('/user/edit/{id}',[UserController::class,'edit']);
    Route::POST('/user/store',[UserController::class,'store']);
    Route::PUT('/user/update/{id}',[UserController::class,'update']);
    Route::DELETE('/user/destroy/{id}',[UserController::class,'destroy']);

    Route::GET('/shop-profile',[ShopProfileController::class,'profile']);
    Route::PUT('/shop-profile/update',[ShopProfileController::class,'update']);
    Route::GET('/dashboard',[HomeController::class,'adminDashboard']);
});
//Category

//SHOPPING ROUTES

Route::GROUP(['middleware'=>'auth:customer'],function(){
    Route::GET('/shop/user-logout',[ShopController::class,'tryLogout']);

    Route::GET('/shop/profile',[ShopController::class,'profile']);
    Route::PUT('/shop/update-profile',[ShopController::class,'updateProfile']);
    Route::PUT('/shop/update-password',[ShopController::class,'updatePassword']);
    Route::PUT('/shop/update-foto',[ShopController::class,'updateFoto']);
    Route::GET('/shop/user/address',[ShopController::class,'userAddress']);
    Route::GET('/shop/user/address/add',[ShopController::class,'userFormAddress']);
    Route::POST('/shop/user/address/store',[ShopController::class,'userStoreAddress']);
    Route::GET('/shop/user/address/edit/{id}',[ShopController::class,'userEditAddress']);
    Route::PUT('/shop/user/address/update/{id}',[ShopController::class,'userUpdateAddress']);
    Route::DELETE('/shop/user/address/destroy/{id}',[ShopController::class,'userDestroyAddress']);

    Route::POST('/shop/user/addToCart',[ShopController::class,'addToCart']);
    Route::GET('/shop/user/reduceCart/{id}/{qty}',[ShopController::class,'reduceItemCart']);
    Route::GET('/shop/cart',[ShopController::class,'viewShoppingCart']);
    Route::POST('/shop/checkout',[ShopController::class,'checkout']);
    Route::GET('/shop/transaction/detail/{id}',[ShopController::class,'transactionDetail']);
    Route::GET('/shop/transactions',[ShopController::class,'transactionList']);
    Route::GET('/shop/transaction/upload/{id}',[ShopController::class,'transactionUploadForm']);
    Route::POST('/shop/transaction/upload',[ShopController::class,'transactionUpload']);
    Route::POST('/shop/finishTransaction',[ShopController::class,'finishTransaction']);
    Route::GET('/shop/transaction/search/{key}',[ShopController::class,'searchTransaction']);
});

Route::GET('/shop',[HomeController::class,'index']);
Route::GET('/shop/product',[ShopController::class,'productIndex']);
Route::GET('/shop/product/category/{id}',[ShopController::class,'productPerKategori']);
Route::GET('/shop/product/sub_category/{category}/{id}',[ShopController::class,'productPerSubKategori']);
Route::GET('/shop/product/detail/{id}',[ShopController::class,'productDetail']);
Route::GET('/shop/login',[ShopController::class,'login']);
Route::POST('/shop/try-login',[ShopController::class,'tryLogin']);
Route::GET('/shop/register',[ShopController::class,'register']);
Route::POST('/shop/try-register',[ShopController::class,'tryRegister']);
Route::POST('/shop/product/search',[ShopController::class,'searchProduct']);