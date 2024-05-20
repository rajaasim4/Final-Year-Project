<?php

use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\AdminLoginController;
use PharIo\Manifest\AuthorElementCollection;

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
Route::get('/test',function(){

});
Route::get('/', [FrontController::class, 'index'])->name('front.index');
// Route::get('/shop/{categorySlug?}/{subCategorySlug?}/',[ShopController::class,'index'])->name('front.shop');
// Route::get('/shop/{categorySlug?}/{subCategorySlug?}/',[ShopController::class,'index'])->name('front.shop');

Route::get('/shop/{categorySlug?}/{subCategorySlug?}/', [ShopController::class, 'index'])->name('front.shop');
Route::get('/products/{slug}/', [ShopController::class, 'product'])->name('front.product');
Route::get('/cart', [CartController::class, 'cart'])->name('front.cart');
Route::post('/delete-cart', [CartController::class, 'deleteItem'])->name('front.deleteItem.cart');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('front.addToCart');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('front.updateCart');
Route::get('/checkout',[CartController::class,'checkout'])->name('front.checkout');
Route::post('/process-checkout',[CartController::class,'processCheckout'])->name('front.processCheckout');
Route::get('/thanks/{orderId}',[CartController::class,'thankyou'])->name('front.thankyou');

Route::group(['prefix' => 'account'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::post('/process-register', [AuthController::class, 'processRegister'])->name('account.processRegister');
        Route::get('/register', [AuthController::class, 'register'])->name('account.register');
        Route::get('/login', [AuthController::class, 'login'])->name('account.login');
        Route::post('/login', [AuthController::class, 'authenticate'])->name('account.authenticate');
    });
    Route::group(['middleware' => 'auth'], function () {

        Route::get('/profile',[AuthController::class,'profile'])->name('account.profile');
        Route::get('/my-orders',[AuthController::class,'order'])->name('account.order');
        Route::get('/order-detail/{id}',[AuthController::class,'orderDetail'])->name('account.orderDetail');
        Route::get('/logout',[AuthController::class,'logout'])->name('account.logout');
        
    });
});



Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });
    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');

        // Routes for categories section are displayed here
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{categories}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'delete'])->name("categories.delete");

        // Routes for subCategories are listed here
        Route::get('/sub_categories/create', [SubCategoryController::class, 'create'])->name('sub_categories.create');
        Route::get('/sub_categories', [SubCategoryController::class, 'index'])->name('sub_categories.index');
        Route::post('/subCategories/store', [SubCategoryController::class, 'store'])->name('sub_categories.store');
        Route::get('/sub_categories/{subCategory}/edit', [SubCategoryController::class, 'edit'])->name('sub_categories.edit');
        Route::put('/subCategory/{SubCategory}', [SubCategoryController::class, 'update'])->name('sub_categories.update');
        Route::delete('/sub_categories/{SubCategory}', [SubCategoryController::class, 'delete'])->name('sub_categories.delete');

        // Routes for brands are listed here

        Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
        Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('/brands/store', [BrandController::class, 'store'])->name('brands.store');
        Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::put('/brands/{brands}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('/brands/{brands}', [BrandController::class, 'destroy'])->name('brands.delete');

        // Routes for Products are listed here

        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::get('/product/subCategories', [ProductSubCategoryController::class, 'index'])->name('product-subcategories.index');
        Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{products}', [ProductController::class, 'delete'])->name('products.delete');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::get('/productImagesDelete/{id}', [ProductController::class, 'deleteImages'])->name('productImage.delete');
        Route::put('/products/{products}', [ProductController::class, 'update'])->name('products.update');

        // Route to get the products based on their names
        // Order Routes
        Route::get('/orders',[OrderController::class,'index'])->name('orders.index');
        Route::get('/order-details/{id}',[OrderController::class,'detail'])->name('order.detail');
        // Route::post("/order/change-status/{id}",[OrderController::class,'changeOrderStatus'])->name('orders.changeOrderStatus');
        Route::post('/orders/change-status/{order}', [OrderController::class, 'changeOrderStatus'])->name('orders.changeOrderStatus');

        Route::get('/get-products', [ProductController::class, 'getProducts'])->name('products.getProducts');
    });
});