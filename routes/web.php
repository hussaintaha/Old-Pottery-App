<?php

use Illuminate\Support\Facades\Route;

Route::get('/','AppController@super_admin_dashboard')->middleware(['auth.shopify', 'billable'])->name('home');
Route::get('/dashboard','AppController@super_admin_dashboard');


Route::post('/submit_locations','AppController@submit_locations');
Route::post('/submit_settings','AppController@submit_settings');
Route::get('/swicth-locations','AppController@CloseOpenAllLocations');
Route::get('/pos-slip','AppController@PosPrint');

Route::get('/AcceptOrder','AppController@AcceptOrder');
Route::get('/update-order-status','AppController@UpdateOrderStatus');

Route::get('/settings','AppController@super_admin_settings');
Route::get('/orders-list','AppController@OrderListByLocation');
Route::get('/manage-locations','AppController@super_admin_locations');
Route::get('/edit-location','AppController@edit_location_data');
Route::get('/frontendscript','ShopFrontController@shopscript');
Route::post('/SaveLocations','AdminController@SaveLocation');


/////////// Location user Routes
Route::post('/User/validatelocation','LocationUser@ValidateUser');
Route::get('/User/login','LocationUser@Login')->name('login');
Route::get('/User/Logout','LocationUser@Logout');
Route::get('/User/dashboard','LocationUser@Dashboard')->name('dashboard');
Route::get('/User/orders','LocationUser@Orders');
// Route::get('/User/test','LocationUser@Test')->name('Test');
Route::get('/User/AcceptOrder','LocationUser@AcceptOrder');
Route::get('/User/AcceptedOrders','LocationUser@AcceptedOrders');
Route::get('/User/settings','LocationUser@Settings');
Route::get('/User/update-settings','LocationUser@UpdateSettings');
Route::get('/User/pos-print','LocationUser@PosPrint');
Route::get('/User/update-order-status','LocationUser@UpdateOrderStatus');
Route::get('/User/order-full-details','LocationUser@OrderDetailsPage');


//////////// Webhooks App Uninstalled
Route::post('/app-uninstalled','ShopifyWebhookController@AppUnInstalled');


/////// Webhooks For Inventory Level - Related To Locations
Route::post('/inventory-level-connected','ShopifyWebhookController@LocationAttachedToProduct');
Route::post('/inventory-level-disconnected','ShopifyWebhookController@LocationDetachedToProduct');
Route::post('/inventory-level-update','ShopifyWebhookController@UpdateInventoryLevel');

///// Webhooks For Inventory Items
Route::post('/inventory-item-create','ShopifyWebhookController@InventoryItemCreated');
Route::post('/inventory-item-update','ShopifyWebhookController@InventoryItemUpdated');
Route::post('/inventory-item-delete','ShopifyWebhookController@InventoryItemDeleted');


///// Order Created Webhook
Route::post('/order-created','OrderController@orderwebhook');
Route::post('/checklocation','OrderController@checklocation');
Route::post('/check-product-available-on-locations','OrderController@CheckProduct');

Route::get('/test','OrderController@Test');


//// Product Related Webhooks
Route::post('/product-created','ShopifyWebhookController@ProductCreated');
Route::post('/product-updated','ShopifyWebhookController@ProductUpdated');
Route::post('/product-deleted','ShopifyWebhookController@ProductDeleted');



Route::get('/Sync','UserController@Sync');



Route::get('/search-locations','ShopFrontController@StoreLocations');
Route::get('/search-inventory','ShopFrontController@SearchProductInvetory');
Route::post('/search-locations-inventory','ShopFrontController@SearchLocationsInventory');
