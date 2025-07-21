<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\VendorController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
Route::namespace('App\Http\Controllers\API')->group(function () {
    Route::post('login', 'UsersController@loginUser');
});
*/


// Route::post('login', [UsersController::class, 'loginUser']);
// Route::post('register', [UsersController::class, 'registerUser']);
// Route::post('forgotPassword', [UsersController::class, 'forgotPassword']);
// Route::post('contact', [UsersController::class, 'contactUs']);

// // Account Details
// Route::get('account/{id}', [UsersController::class, 'acountDetails']);
// // update Account
// Route::put('editAccount/{id}', [UsersController::class, 'userEditAccount']);

// // Update Password
// Route::put('updatePassword/{id}', [UsersController::class, 'userUpdatePassword']);

// // Patch API (Update Single Record) updated User Image
// // Route::patch('updateImage', [UsersController::class, 'updateUserImage']);

// // Notification
// Route::get('couponNotification', [UsersController::class, 'couponNotification']);

// // Feature Items
// Route::get('featureItems', [ProductController::class, 'getFeatureItems']);

// // All Items
// Route::get('allProducts', [ProductController::class, 'allNewItems']);
// Route::get('productDetails/{id}', [ProductController::class, 'productDetails']);

// // Add To Reminder List
// Route::post('addToReminderList/{user_id}', [ProductController::class, 'addToReminder']);
// Route::get('reminderListItems/{user_id}', [ProductController::class, 'reminderListItems']);
// Route::delete('deleteReminderItems/{id}', [ProductController::class, 'deleteReminderItems']);

// // Add to cart
// Route::post('addToCart/{user_id}', [ProductController::class, 'addToCart']);
// Route::delete('deleteCartItems/{id}', [ProductController::class, 'deleteCartItems']);
// Route::get('cartItems/{user_id}', [ProductController::class, 'cartItems']);

// // Apply Coupon
// Route::post('applyCoupon/{user_id}', [ProductController::class, 'applyCoupon']);

// // Checkout Page
// Route::post('checkout/{user_id}/{user_email}', [ProductController::class, 'checkout']);

// // Report
// Route::post('userReport', [ProductController::class, 'userReport']);

// // Orders Details
// // Route::get('order_details/{user_id}', [UsersController::class, 'orderDetails']);

// // Products Attributes
// Route::get('attributes/{product_id}', [ProductController::class, 'productAttributes']);

// // section (category) products 
// Route::get('men_women_kids_products/{keyword}', [ProductController::class, 'manproducts']);

// // Search Find 
// Route::post('search/{keyword}', [ProductController::class, 'search']);

// // Geofence Message API
// Route::get('notification/{user_id}', [ProductController::class, 'notification']);


/* VENDOR API'S */

// Login
Route::post('vendor_login', [VendorController::class, 'login']);

// Products Functionality
Route::get('listing_sections', [VendorController::class, 'allSections']);
Route::get('listing_brands', [VendorController::class, 'allBrands']);
Route::get('listing_parent-categories/{section_id}', [VendorController::class, 'allParentCategories']);
Route::get('listing_subcategories/{category_id}', [VendorController::class, 'allSubCategories']);

// Products
Route::get('listing_products/{vendor_id}', [VendorController::class, 'allProducts']);
Route::post('add_products/{vendor_id}', [VendorController::class, 'AddProducts']);
Route::post('edit_products/{product_id}', [VendorController::class, 'EditProducts']);
Route::post('addEdit_product_status/{product_id}', [VendorController::class, 'addEditProductStatus']);
Route::delete('deleteProducts/{id}', [VendorController::class, 'deleteProducts']);
Route::get('view_products/{id}', [VendorController::class, 'viewProducts']);

// Product Images
Route::post('add_products-images/{product_id}', [VendorController::class, 'AddProductImages']);
Route::get('get_products-images/{product_id}', [VendorController::class, 'getProductImages']);
Route::post('addEdit_productImages_status/{product_id}', [VendorController::class, 'addEditProductImageStatus']);

// Product Attributes
Route::post('add_products-attributes/{product_id}', [VendorController::class, 'AddProductAttributes']);
Route::get('get_attribute/{product_id}', [VendorController::class, 'viewAttributes']);
Route::post('addEdit_productAttribute_status/{product_id}', [VendorController::class, 'addEditProductAttributeStatus']);

// Product Colors
Route::post('add_products-attributesColor/{product_id}/{attribute_id}', [VendorController::class, 'AddProductAttributesColors']);
Route::get('get_color/{attribute_id}', [VendorController::class, 'viewAttributesColor']);

// View orders
Route::get('vieworder/{vendor_id}', [VendorController::class, 'viewOrders']);
Route::get('order_details/{id}/{vendor_id}', [VendorController::class, 'orderDetails']);

/* END VENDOR API'S */