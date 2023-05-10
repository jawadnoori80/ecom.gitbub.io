<?php
use App\Models\Admin\HomeBanner;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AisleController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\HomeBannerController;


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
Route::get('/test', [FrontController::class, 'test']);
Route::group(['middleware'=>'user_auth'], function(){
    Route::get('/orders', [FrontController::class, 'orders']);
    Route::get('/order_details/{id}', [FrontController::class, 'order_details']);
    Route::get('/my_account', [FrontController::class, 'my_account']);
   
    Route::post('/my_account/update_account', [FrontController::class, 'update_account']);
});

Route::get('/', [FrontController::class, 'index']);
Route::get('/listing/{aisle_slug}/{category_slug}', [FrontController::class, 'categoryListing']);
Route::get('/product/{slug}', [FrontController::class, 'product_page']);
Route::get('/cart', [FrontController::class, 'cart_page']);
Route::post('/add_to_cart', [FrontController::class, 'addToCart']);
Route::get('/search', [FrontController::class, 'search']);
Route::get('/registration', [FrontController::class, 'registration']);
Route::get('/verification/{id}', [FrontController::class, 'verification']);
Route::post('/registration_process', [FrontController::class, 'registration_process']);
Route::post('/login_process', [FrontController::class, 'login_process'])->middleware('throttle:5,1');
Route::post('/forgot_password', [FrontController::class, 'forgot_password']);
Route::get('/reset_password/{id}', [FrontController::class, 'reset_password']);
Route::post('/reset_password_process', [FrontController::class, 'reset_password_process']);
Route::get('/checkout', [FrontController::class, 'checkout']);
// Route::post('/api/orders', [PaypalController::class, 'create']);
// Route::post('/api/orders/{data.orderID}/capture', [PaypalController::class, 'capture']);

// Route::get('/welcome', function () {
//     return view('welcome');
// });


Route::get('logout', function () {
    session()->forget('FRONT_USER_LOGIN');
    session()->forget('FRONT_USER_ID');
    session()->forget('FRONT_USER_NAME');
    session()->forget('USER_TEMP_ID');
    session()->flash('success', 'Logout Succesfully');
    return redirect('/');
});

Route::post('/update_cart', [FrontController::class, 'update_cart']);
Route::post('/delete_cart_item', [FrontController::class, 'delet_cart_item']);


Route::get('/admin', [AdminController::class, 'index']);
Route::post('/admin/auth', [AdminController::class, 'auth'])->name('admin.auth')->middleware('throttle:2,1');

Route::group(['middleware'=>'admin_auth'], function(){
    
    Route::get('admin/account', [AdminController::class, 'account']);
    Route::post('admin/account/update_account', [AdminController::class, 'update_account']);

    Route::get('admin/dashboard', [AdminController::class, 'dashboard']);
    Route::get('admin/orders/search', [AdminController::class, 'search']);
    Route::get('admin/orders/details/{id}', [AdminController::class, 'Order_details']);
    Route::get('admin/update_password', [AdminController::class, 'update_password']);

    Route::get('admin/HB', [HomeBannerController::class, 'index']);
    Route::get('admin/HB/manage_HB', [HomeBannerController::class, 'manage_HB']);
    Route::post('admin/HB/manage_HB_process', [HomeBannerController::class, 'manage_HB_process'])->name('HB.insert');
    Route::get('admin/HB/delete/{id}', [HomeBannerController::class, 'delete']);
    Route::get('admin/HB/edit/{id}', [HomeBannerController::class, 'edit']);
    Route::put('admin/HB/update/{id}', [HomeBannerController::class, 'update']);
    Route::get('admin/HB/status/{status}/{id}',[HomeBannerController::class,'status']);

    Route::get('admin/aisle', [AisleController::class, 'index']);
    Route::get('admin/aisle/manage_aisle', [AisleController::class, 'manage_aisle']);
    Route::post('admin/aisle/manage_aisle_process', [AisleController::class, 'manage_aisle_process'])->name('aisle.insert');
    Route::get('admin/aisle/delete/{id}', [AisleController::class, 'delete']);
    Route::get('admin/aisle/edit/{id}', [AisleController::class, 'edit']);
    Route::put('admin/aisle/update/{id}', [AisleController::class, 'update']);
    
    Route::get('admin/category', [CategoryController::class, 'index']);
    Route::get('admin/category/manage_category', [CategoryController::class, 'manage_category']);
    Route::post('admin/category/manage_category_process', [CategoryController::class, 'manage_category_process'])->name('category.insert');
    Route::get('admin/category/delete/{id}', [CategoryController::class, 'delete']);
    Route::get('admin/category/edit/{id}', [CategoryController::class, 'edit']);
    Route::put('admin/category/update/{id}', [CategoryController::class, 'update']);
    
    Route::get('admin/size',[SizeController::class,'index']);
    Route::get('admin/size/manage_size',[SizeController::class,'manage_size']);
    Route::get('admin/size/manage_size/{id}',[SizeController::class,'manage_size']);
    Route::post('admin/size/manage_size_process',[SizeController::class,'manage_size_process'])->name('size.manage_size_process');
    Route::get('admin/size/delete/{id}',[SizeController::class,'delete']);
    Route::get('admin/size/status/{status}/{id}',[SizeController::class,'status']);

    Route::get('admin/product',[ProductController::class,'index']);
    Route::get('admin/product/manage_product',[ProductController::class,'manage_product']);
    Route::post('admin/product/manage_product_process',[ProductController::class,'manage_product_process'])->name('product.manage_product_process');
    Route::get('admin/product/delete/{id}',[ProductController::class,'delete']);
    Route::get('admin/product/edit/{id}',[ProductController::class,'edit']);
    Route::post('admin/product/update/{id}',[ProductController::class,'update']);
    Route::post('admin/product/status/{status}/{id}',[ProductController::class,'status']);
    Route::post('admin/product/product_attr_delete/{paId}',[ProductController::class,'product_attr_delete']);
    Route::post('admin/product/product_image_delete/{paId}',[ProductController::class,'product_image_delete']);
    Route::get('admin/product/search', [ProductController::class, 'search']);


    Route::get('admin/customer',[CustomerController::class,'index']);
    Route::get('admin/customer/show/{id}',[CustomerController::class,'Show']);
    
    Route::get('admin/logout', function () {
        session()->forget('ADMIN_LOGIN');
        session()->forget('ADMIN_ID');
        session()->forget('ADMIN_NAME');
        session()->flash('success', 'Logout Succesfully');
        return redirect('admin');
    });
    
   
});



