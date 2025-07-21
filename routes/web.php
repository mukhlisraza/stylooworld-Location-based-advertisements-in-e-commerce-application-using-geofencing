<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Admin Work
Route::prefix('/admin')->namespace('Admin')->group(function () {
    // All the admin routes will be defined here :-
    Route::match(['get', 'post'], '/', 'AdminController@login');

    Route::group(['middleware' => ['admin']], function () {
        // Route::get('dashboard', 'AdminController@dashboard');
        Route::get("dashboard", "AdminController@adminlogin");
        //Logout
        Route::get("logout", "AdminController@logout");
        //profile
        Route::get('profile', 'AdminController@admin_profile');
        Route::post('check-current-pwd', 'AdminController@chkCurrentPassword');
        Route::post('update-current-pwd', 'AdminController@updateCurrentPassword');
        Route::match(['get', 'post'], 'update-admin-details', 'AdminController@updateAdminDetails');
        Route::match(['get', 'post'], 'update-admin-image', 'AdminController@updateAdminImage');

        // Admin Account reset password
        Route::get('password_reset', 'AdminController@adminAccountResetPassword');
        Route::post('account_reset', 'AdminController@accountReset');

        //SECTIONS 
        Route::get('sections', 'SectionController@sections');
        Route::post('update-section-status', 'SectionController@updateSectionStatus');
        Route::get('add-section', 'SectionController@getSection');
        Route::post('add-sections', 'SectionController@addSection');
        Route::get('edit-section/{id?}', 'SectionController@getEditSection');
        Route::post('edit-sections/{id?}', 'SectionController@editSection');

        //Brands
        Route::get('brands', 'BrandController@brands');
        Route::post('update-brand-status', 'BrandController@updateBrandStatus');
        Route::match(['get', 'post'], 'add-edit-brand/{id?}', 'BrandController@addEditBrand');
        Route::get('delete-brand/{id}', 'BrandController@deleteBrand');

        //Categories
        Route::get('categories', 'CategoryController@categories');
        Route::post('update-category-status', 'CategoryController@updateCategoryStatus');
        Route::match(['get', 'post'], 'add-edit-category/{id?}', 'CategoryController@addEditCategory'); //{id?} if pass id it will be edit category route if did't so it will be a add category route
        Route::post('append-categories-level', 'CategoryController@appendCategoriesLevel');
        Route::get('delete-category-image/{id}', 'CategoryController@deleteCategoryImage');
        Route::get('delete-category/{id}', 'CategoryController@deleteCategory');

        //Products
        Route::get('products', 'ProductsController@products');
        Route::post('update-product-status', 'ProductsController@updateProductStatus');
        Route::get('delete-product/{id}', 'ProductsController@deleteProduct');
        Route::match(['get', 'post'], 'add-edit-product/{id?}', 'ProductsController@addEditProduct'); //{id?} if pass id it will be edit product route if did't so it will be a add product route
        Route::get('delete-product-image/{id}', 'ProductsController@deleteProductImage');
        Route::get('delete-product-video/{id}', 'ProductsController@deleteProductVideo');

        //Statistics
        Route::get('stats', 'ProductsController@stats');
        //Stock
        Route::get('stock', 'ProductsController@stock');
        // Reviews
        Route::get('review', 'ProductsController@review');
        Route::get("reviews/{id}", "ProductsController@reviewsDetails");

        // Attributes (Products)
        Route::match(['get', 'post'], 'add-attributes/{id}', 'ProductsController@addAttributes');
        Route::match(['get', 'post'], 'add-colors/{id}', 'ProductsController@addColor');
        Route::get('add-attribute-colors/{attribute_id}', 'ProductsController@addAttributeColors');
        Route::get('delete-color/{id}', 'ProductsController@deleteColor');
        Route::post('edit-attributes/{id}', 'ProductsController@editAttributes');
        Route::post('update-attribute-status', 'ProductsController@updateAttributeStatus');
        Route::get('delete-attribute/{id}', 'ProductsController@deleteAttribute');

        //Product Images
        Route::match(['get', 'post'], 'add-images/{id?}', 'ProductsController@addImages');
        Route::post('update-image-status', 'ProductsController@updateImageStatus');
        Route::get('delete-image/{id}', 'ProductsController@deleteImage');
        Route::get('delete-product-image/{id}', 'ProductsController@deleteProductImage');

        //Banners
        Route::get('banner', 'BannersController@manageBanners');
        Route::post('update-banner-status', 'BannersController@updateBannerStatus');
        Route::get('delete-banners/{id}', 'BannersController@deleteBanner');
        Route::match(['get', 'post'], 'add-edit-banner/{id?}', 'BannersController@addEditBanner');
        Route::get('delete-banner-image/{id}', 'BannersController@deleteBannerImage');

        //Coupons
        Route::get('coupons', 'CouponsController@coupons');
        Route::post('update-coupon-status', 'CouponsController@updateCouponStatus');
        Route::match(['get', 'post'], 'add-edit-coupon/{id?}', 'CouponsController@addEditCoupon');
        Route::get('delete-coupon/{id}', 'CouponsController@deleteCoupon');

        //User
        Route::get('activeuser', 'AdminController@activeuser');
        Route::get('deactiveuser', 'AdminController@deactiveuser');
        Route::get('subscriberuser', 'AdminController@subscriberuser');
        Route::post('update-user-status', 'AdminController@updateUserStatus');
        Route::get('delete-user/{id}', 'AdminController@deleteUser');
        // Orders
        Route::get('orders', 'OrdersController@orders');
        Route::get("orders/{id}", "OrdersController@ordersDetails");
        Route::post('update-order-status', 'OrdersController@updateOrderStatus');
        Route::get("view-order-invoice/{id}", "OrdersController@viewOrderInvoice");
        Route::get('pendingorders', 'OrdersController@pendingorders');
        Route::get('deliveredorders', 'OrdersController@deliveredorders');

        //Contact Us
        Route::get('contactusview', 'AdminController@contactusview');
        Route::post('update-contact-status', 'AdminController@updateContactStatus');

        //Report
        Route::get('report', 'ProductsController@proreport');

        //Vendor Registration
        Route::get('vendor', 'AdminController@vendor');
        Route::match(['get', 'post'], 'vendor-registration', 'AdminController@registerVendor');
        Route::post('update-vendor-status', 'AdminController@updateVendorStatus');
        Route::get('delete-vendor/{id}', 'AdminController@deleteVendor');

        //Products Gallary
        Route::get('productgallery', 'AdminController@productgallery');

        // Shop Information
        Route::get('shopinfo', 'AdminController@shopinfo');
        Route::match(['get', 'post'], 'edit-shopinfo/{id?}', 'AdminController@addEditShopInfo');
        Route::match(['get', 'post'], 'edit-shopTime/{id?}', 'AdminController@addEditShopTime');

        //Geofence Offers
        Route::get('geofenceoffer', 'ProductsController@geofenceoffer');
    });

    //Admin Password Recovery
    Route::get("passwordforgot", "AdminController@passwordforgot");

    Route::match(['get', 'post'], "forgot_password", "AdminController@forgotPassword");

    //password recovery code
    Route::get("recoverycode", "AdminController@recoverycode");
});


// Route::get('manageuser', 'Admin\AdminController@manageuser');


//*********************** */ Front Work *************************


use App\Category;

use Illuminate\Support\Facades\Route;

Route::namespace('Front')->group(function () {
    //Home Page Route
    Route::get('/', 'IndexController@index');

    //Get Listing/Category Routes
    $catUrls = Category::select('category_name', 'status')->where('status', 1)->get()->pluck('category_name')->toArray();
    foreach ($catUrls as $url) {
        Route::get("/" . $url, "ProductsController@listing");
    }


    // Product Detail Page
    Route::get("/product/{id?}", "ProductsController@detail");

    //Getting Product Attribute Price 
    Route::post("/get-product-price", "ProductsController@getProductPrice");
    Route::post("/get-attribute-color", "ProductsController@getAttributeColor");

    // Add to Cart Route
    Route::post("/add-to-cart", "ProductsController@addToCart");
    // Shopping Cart Route
    Route::get("/cart", "ProductsController@cart");

    // Update cart item Quantity
    Route::post('/update-cart-item-qty', 'ProductsController@updateCartItemQty');
    Route::post('/delete-cart-item', 'ProductsController@deleteCartItem');


    //Confirm Account
    Route::match(['get', 'post'], '/confirm/{code}', 'UsersController@confirmAccount');

    // User Login Route/RegisterRoute
    Route::get('/login', ['as' => 'login', 'uses' => 'UsersController@loginRegister']);
    Route::get("/register", "UsersController@userLoginRegister");

    //user login
    Route::post('/user-login', 'UsersController@loginUser');
    //Register User
    Route::post('/user-register', 'UsersController@registerUser');

    Route::get("/logout", "UsersController@logoutUser");

    // contact us
    Route::get("contactus", "UsersController@contactus");
    Route::post('/contact', "UsersController@contact");

    // Report 
    Route::get("report", "ProductsController@report");
    Route::post('/product-report', 'ProductsController@productReport');

    // Forgot Password
    Route::match(['get', 'post'], "forgotpassword", "UsersController@forPassword");
    Route::match(['get', 'post'], "forgot-password", "UsersController@forgotPassword");

    //Search
    Route::get('/search', 'ProductsController@search')->name('search');

    // Compare
    Route::post("/add-to-compare", "ProductsController@addToCompare");

    // subscriber
    Route::post("/check-subscriber-email", "NewsletterController@checkSubscriberEmail");

    // Add to Reminder Route
    Route::post("/add-to-reminder", "ProductsController@addToReminder");
    Route::get("/reminderlist", "ProductsController@reminderList");
    Route::match(['get', 'post'], '/reminderlist/{id?}', 'ProductsController@deleteReminderItem');

    // Vendor Shop Details
    Route::get('shop/{id?}', 'VendorController@vendorShop');
    Route::get('shop/profile/{id?}', 'VendorController@shopProfile');

    // Affiliate
    Route::get('shorter/{url}', 'UsersController@referrerRedirect');

    // Middleware
    Route::group(['middleware' => ['auth']], function () {
        //check email already exist
        Route::match(['get', 'post'], '/check-email', 'UsersController@checkEmail');
        // User Account
        Route::match(['get', 'post'], '/account', 'UsersController@account');
        Route::match(['get', 'post'], '/editaccount', 'UsersController@editAccount');
        Route::match(['get', 'post'], 'update-user-image', 'UsersController@updateUserImage');
        Route::post('/check-user-pwd', 'UsersController@chkUserPassword');
        Route::post('/update-user-pwd', 'UsersController@updateUserPassword');
        Route::get('referrer_earning', 'UsersController@referrer_Earning');

        // Coupons
        Route::post('/apply-coupon', 'ProductsController@applyCoupon');


        // Checkout 
        Route::match(['get', 'post'], "/checkout", "ProductsController@checkout");
        Route::match(['get', 'post'], "/add-edit-delivery-address/{id?}", "ProductsController@addEditDeliveryAddress");
        Route::get('/delete-delivery-address/{id?}', 'ProductsController@deleteAddress');

        //Thanks Page
        Route::get('/thanks', 'ProductsController@thanks');

        //User Orders Details
        Route::get("orders", "OrdersController@orders");
        Route::get("orders/{id}", "OrdersController@ordersDetails");

        // Review 
        Route::post('/review', 'ProductsController@review');

        //Notifications
        Route::get("notification", "UsersController@notification");

        // Affiliated 
        Route::get('affiliate', 'UsersController@affiliate');
        Route::get('affiliate/search', 'UsersController@search');
        Route::post('get-affiliate-link', 'UsersController@getAffiliateLink');
        Route::post('affiliate/get-affiliate-link', 'UsersController@getAffiliateLink');
    });
});





Route::get("verificationcode", "IndexController@verificationcode");



Route::get("compareproduct", "Front\IndexController@compareproduct");


// Route::get("account", "Front\IndexController@account");

// Route::get("editaccount", "Front\IndexController@editaccount");


Route::get("termcondition", "Front\IndexController@termcondition");
