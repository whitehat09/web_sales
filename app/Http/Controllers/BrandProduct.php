<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; /* sử dụng DB*/ 
/*thêm thư viện */
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
class BrandProduct extends Controller
{
    public function AuthLogin(){// hàm kiểm tra đăng nhập để vào bảng điều khiển
        $admin_id = session::get('admin_id');
        if ($admin_id) {
            return Redirect::to('dashboard');// nếu đúng trả về
        }
        else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_brand_product(){
        $this->AuthLogin();
    	return view('admin.add_brand_product');
    }
    public function all_brand_product(){
        $this->AuthLogin();
        $all_brand_product= DB::table('brand_product')->get();// dùng biến chứa để chứa dữu liệu của bảng đó
        $manager_brand_product = view('admin.all_brand_product')->with('all_brand_product',$all_brand_product);
        // Lấy biến chứa dữu liệu của biến đại diện cho bảng với giao diện  
    	return view('admin_layout')->with('admin.all_brand_product',$manager_brand_product);
    }
    public function save_brand_product(Request $request){
        $this->AuthLogin();
    	$data =  array();
    	$data ['brand_name'] = $request->brand_product_name; 
    	$data ['brand_desc'] = $request->brand_product_desc; 
    	$data ['brand_status'] = $request->brand_product_status; 
    	
    	DB::table('brand_product')->insert($data);
    	session::put('message','Thêm thương hiệu thành công');
    	return Redirect::to('add_brand_product');

    }	
    public function unactive_brand_product ($brand_product_id){
        $this->AuthLogin();
        DB::table('brand_product')->where('brand_id',$brand_product_id)->update(['brand_status'=>1]);
        //lấy dữu liệu từ bảng với hàng lấy từ biến hay có thể nói là so sánh với biến rồi đung update để thay đổi giá trị biến
        session::put('message','Không kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('all_brand_product');
    }
    public function active_brand_product ($brand_product_id){
        $this->AuthLogin();
         DB::table('brand_product')->where('brand_id',$brand_product_id)->update(['brand_status'=>0]);
        //lấy dữu liệu từ bảng với hàng lấy từ biến hay có thể nói là so sánh với biến rồi đung update để thay đổi giá trị biến
        session::put('message','Không kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('all_brand_product');
    }

    public function edit_brand_product($brand_product_id){
        $this->AuthLogin();
        $edit_brand_product= DB::table('brand_product')->where('brand_id',$brand_product_id)->get();
        // như hàm thêm nhưng với điều kiện where giống với biến id đã lấy 
        $manager_brand_product = view('admin.edit_brand_product')->with('edit_brand_product',$edit_brand_product);
        // Lấy biến chứa dữu liệu của biến đại diện cho bảng với giao diện  
        return view('admin_layout')->with('admin.edit_brand_product',$manager_brand_product);
    }
     public function update_brand_product(Request $request,$brand_product_id){
        $this->AuthLogin();
      $data  = array();
      $data ['brand_name'] = $request->brand_product_name; 
    $data ['brand_desc'] = $request->brand_product_desc; 
     DB::table('brand_product')->where('brand_id',$brand_product_id)->update($data);
      session::put('message','Cập nhập danh mục sản phẩm thành công');
        return Redirect::to('all_brand_product');
    }
     public function delete_brand_product ($brand_product_id){
        $this->AuthLogin();
        DB::table('brand_product')->where('brand_id',$brand_product_id)->delete();
        
        session::put('message','Xoá thương hiệu sản phẩm thành công');
        return Redirect::to('all_brand_product');
    }
}
