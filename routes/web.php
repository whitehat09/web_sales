<?php

use Illuminate\Support\Facades\Route;

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
//     return view('layout');
// });

// Route::get('/trang-chu', function () {
//     return view('layout');
// });
/* Home */
Route::get('/','HomeController@index');
Route::get('/trang-chu','HomeController@index');
/* Admin */
Route::get('/admin','AdminController@index');/*login*/
Route::get('/dashboard','AdminController@showdashboard');/*dashboard bảng điều khiển*/

Route::post('/admin_dashboard','AdminController@dashboard');/*login thành công đến dashboard bảng điều khiển*/
Route::get('/logout','AdminController@logout');/*logout*/

/*category product | danh mục sản phẩm  */
Route::get('/add_category_product','CategoryProduct@add_category_product');
Route::get('/all_category_product','CategoryProduct@all_category_product');

Route::get('/edit_category_product/{category_product_id}','CategoryProduct@edit_category_product');//sửa
Route::get('/delete_category_product/{category_product_id}','CategoryProduct@delete_category_product');//xoá
/*xử lí nút ẩn hiện*/
Route::get('/unactive_category_product/{category_product_id}','CategoryProduct@unactive_category_product');
Route::get('/active_category_product/{category_product_id}','CategoryProduct@active_category_product');

Route::post('/save_category_product','CategoryProduct@save_category_product');

// sửa 
Route::post('/update_category_product/{category_product_id}','CategoryProduct@update_category_product');


/*brand product | danh mục sản phẩm  */
Route::get('/add_brand_product','BrandProduct@add_brand_product');
Route::get('/all_brand_product','BrandProduct@all_brand_product');

Route::get('/edit_brand_product/{brand_product_id}','BrandProduct@edit_brand_product');//sửa
Route::get('/delete_brand_product/{brand_product_id}','BrandProduct@delete_brand_product');//xoá
/*xử lí nút ẩn hiện*/
Route::get('/unactive_brand_product/{brand_product_id}','BrandProduct@unactive_brand_product');
Route::get('/active_brand_product/{brand_product_id}','BrandProduct@active_brand_product');

Route::post('/save_brand_product','BrandProduct@save_brand_product');

// sửa 
Route::post('/update_brand_product/{brand_product_id}','BrandProduct@update_brand_product');

/*product | danh mục sản phẩm  */
Route::get('/add_product','Product@add_product');
Route::get('/all_product','Product@all_product');

Route::get('/edit_product/{product_id}','Product@edit_product');//sửa
Route::get('/delete_product/{product_id}','Product@delete_product');//xoá
/*xử lí nút ẩn hiện*/
Route::get('/unactive_product/{product_id}','Product@unactive_product');
Route::get('/active_product/{product_id}','Product@active_product');

Route::post('/save_product','Product@save_product');

// sửa 
Route::post('/update_product/{product_id}','Product@update_product');