<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\ShopController;
use App\Http\Controllers\backend\CouponController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\deshboardController;
use App\Http\Controllers\backend\InventoryController;
use App\Http\Controllers\backend\InvoiceController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\frontend\FrontendController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\backend\RolePermissionController;
use App\Http\Controllers\backend\ShippingConditionController;
use App\Http\Controllers\frontend\UserDeshboardController;

// 

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

Auth::routes(['verify' => true]);

// Frontend
Route::get('/', [FrontendController::class, 'index'])->name('frontend.home');
Route::get('/user/login-register', [FrontendController::class, 'userLogin'])->name('backend.user.login');

// User Deshboard
Route::controller(UserDeshboardController::class)->prefix('user/')->name('frontend.user.')->middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('deshboard', 'index')->name('deshboard');
    Route::get('order', 'userOrder')->name('order');
});

// Shop Router
Route::controller(ShopController::class)->name('frontend.')->group(function () {
    Route::get('/shop', 'allProducts')->name('shop');
    Route::get('/shop/{slug}', 'singleProduct')->name('single.shop');
    Route::post('/shop/color', 'shopColor')->name('single.shop.color');
    Route::post('/shop/stock', 'shopStock')->name('single.shop.stock');
});

// Cart Route
Route::controller(CartController::class)->middleware(['auth', 'verified'])->name('frontend.')->group(function () {
    Route::get('/carts', 'index')->name('cart.index');
    Route::post('/cart/store', 'store')->name('cart.store');
    Route::post('/cart/update', 'update')->name('cart.update');
    Route::post('/cart/applyCoupon', 'applyCoupon')->name('cart.applyCoupon');
    Route::post('/cart/applyShipping', 'applyShipping')->name('cart.applyShipping');
    Route::delete('/cart/delete/{cart}', 'destroy')->name('cart.destroy');
    Route::get('/checkout', 'checkoutView')->name('checkout.view');
});
// Backend
Route::prefix('deshboard')->name('backend.')->middleware(['auth', 'verified', 'role:super-admin|admin'])->group(function () {
    Route::get('/', [deshboardController::class, 'index'])->name('home');

    // Role And Permission Route
    Route::controller(RolePermissionController::class)->group(function () {
        Route::get('/role', 'indexRole')->name('role.index')->middleware(['role_or_permission:super-admin|see role']);
        Route::get('/role/create', 'createRole')->name('role.create')->middleware(['role_or_permission:super-admin|add role']);
        Route::post('/role/create', 'insertRole')->name('role.insert')->middleware(['role_or_permission:super-admin|add role']);
        Route::get('/role/edit/{id}', 'editRole')->name('role.edit')->middleware(['role_or_permission:super-admin|edit role']);
        Route::put('/role/update/{id}', 'updateRole')->name('role.update')->middleware(['role_or_permission:super-admin|edit role']);

        // Permission Route
        Route::post('/permission/insert', 'insertPermission')->name('permission.insert');
    });

    // Category Route
    Route::controller(CategoryController::class)->prefix('product/category')->name('product.category.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/edit/{category}', 'edit')->name('edit');
        Route::put('/update/{category}', 'update')->name('update');
        Route::delete('/delete/{category}', 'destroy')->name('delete');
        Route::delete('/parmanent/delete/{id?}', 'parmanentDestroy')->name('parmanentDelete');
        Route::get('/restore/{id}', 'restore')->name('restore');
    });

    // Product Route 
    Route::controller(ProductController::class)->prefix('product')->name('product.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/edit/{product}', 'edit')->name('edit');
        Route::put('/update/{product}', 'update')->name('update');
        Route::delete('/delete/{product}', 'destroy')->name('delete');
        Route::delete('/parmanent/delete/{id?}', 'parmanentDestroy')->name('parmanentDelete');
        Route::get('/restore/{id}', 'restore')->name('restore');
    });

    // Inventory Route 
    Route::controller(InventoryController::class)->prefix('product/inventory')->name('product.inventory.')->group(function () {
        Route::get('/{product_slug}', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/edit/{inventory}', 'edit')->name('edit');
        Route::put('/update/{inventory}', 'update')->name('update');
        Route::delete('/delete/{inventory}', 'destroy')->name('delete');
        Route::delete('/parmanent/delete/{id?}', 'parmanentDestroy')->name('parmanentDelete');
        Route::get('/restore/{id}', 'restore')->name('restore');
        Route::post('/sizeSelect', 'sizeSelect')->name('size.select');
    });

    // Coupon Route 
    Route::controller(CouponController::class)->prefix('coupon')->name('coupon.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::post('/show', 'show')->name('show');
        Route::get('/edit/{coupon}', 'edit')->name('edit');
        Route::put('/update/{coupon}', 'update')->name('update');
        Route::get('status/active/{coupon}', 'status_acitve')->name('status_acitve');
        Route::get('status/deactive/{coupon}', 'status_deacitve')->name('status_deacitve');
        Route::delete('/delete/{coupon}', 'destroy')->name('delete');
        Route::delete('/parmanent/delete/{id?}', 'parmanentDestroy')->name('parmanentDelete');
        Route::get('/restore/{coupon}', 'restore')->name('restore');
    });

    // Shipping Condition Route 
    Route::controller(ShippingConditionController::class)->prefix('shippingcondition')->name('shippingcondition.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::post('/show', 'show')->name('show');
        Route::get('/edit/{shippingcondition}', 'edit')->name('edit');
        Route::put('/update/{shippingcondition}', 'update')->name('update');
        Route::delete('/delete/{shippingcondition}', 'destroy')->name('delete');
        Route::delete('/parmanent/delete/{id?}', 'parmanentDestroy')->name('parmanentDelete');
        Route::get('/restore/{shippingcondition}', 'restore')->name('restore');
    });

    // Invoice Route 
    Route::controller(OrderController::class)->prefix('order')->name('order.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::post('/show', 'show')->name('show');
        Route::get('/edit/{order}', 'edit')->name('edit');
        Route::put('/update/{order}', 'update')->name('update');
        Route::get('status/active/{order}', 'status_acitve')->name('status_acitve');
        Route::get('status/deactive/{order}', 'status_deacitve')->name('status_deacitve');
        Route::delete('/delete/{order}', 'destroy')->name('delete');
        Route::delete('/parmanent/delete/{id?}', 'parmanentDestroy')->name('parmanentDelete');
        Route::get('/restore/{order}', 'restore')->name('restore');
    });
});

// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END


// tast Route

// Route::get('/user', function(){
//     $role = Role::find(6);
//     $user = User::find(1);
//     $user->assignRole($role);

//     return $role;
// });


// // Category table
// id
// parent_id
// name 
// slug 
// image 
// description 
// status


// // color table
// id 
// name 
// slug 
// status


// // size table
// id 
// name 
// slug 
// status 


// // product table
// id 
// title
// slug 
// shot_discription 
// price 
// sale_price 
// description 
// add_info 
// image 
// status 


// // category_product table 
// product_id 
// category_id


// // product gallery
// id 
// product_id
// image



// // inventory table
// id 
// product_id 
// color_id 
// size_id 
// stock
// additional_price 