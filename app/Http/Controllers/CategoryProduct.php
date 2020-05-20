<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB; /* sử dụng DB*/ 
/*thêm thư viện */
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class CategoryProduct extends Controller
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
    public function add_category_product(){
        $this->AuthLogin();
    	return view('admin.add_category_product');
    }
    public function all_category_product(){
        $this->AuthLogin();
        $all_category_product= DB::table('category_product')->get();// dùng biến chứa để chứa dữu liệu của bảng đó
        $manager_catrgory_product = view('admin.all_category_product')->with('all_category_product',$all_category_product);
        // Lấy biến chứa dữu liệu của biến đại diện cho bảng với giao diện  
    	return view('admin_layout')->with('admin.all_category_product',$manager_catrgory_product);
    }
    public function save_category_product(Request $request){
        $this->AuthLogin();
    	$data =  array();
    	$data ['category_name'] = $request->category_product_name; 
    	$data ['category_desc'] = $request->category_product_desc; 
    	$data ['category_status'] = $request->category_product_status; 
    	
    	DB::table('category_product')->insert($data);
    	session::put('message','Thêm danh mục thành công');
    	return Redirect::to('add_category_product');

    }	
    public function unactive_category_product ($category_product_id){
        $this->AuthLogin();
        DB::table('category_product')->where('category_id',$category_product_id)->update(['category_status'=>1]);
        //lấy dữu liệu từ bảng với hàng lấy từ biến hay có thể nói là so sánh với biến rồi đung update để thay đổi giá trị biến
        session::put('message','Không kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('all_category_product');
    }
    public function active_category_product ($category_product_id){
        $this->AuthLogin();
         DB::table('category_product')->where('category_id',$category_product_id)->update(['category_status'=>0]);
        //lấy dữu liệu từ bảng với hàng lấy từ biến hay có thể nói là so sánh với biến rồi đung update để thay đổi giá trị biến
        session::put('message','Không kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('all_category_product');
    }

    public function edit_category_product($category_product_id){
        $this->AuthLogin();
        $edit_category_product= DB::table('category_product')->where('category_id',$category_product_id)->get();
        // như hàm thêm nhưng với điều kiện where giống với biến id đã lấy 
        $manager_category_product = view('admin.edit_category_product')->with('edit_category_product',$edit_category_product);
        // Lấy biến chứa dữu liệu của biến đại diện cho bảng với giao diện  
        return view('admin_layout')->with('admin.edit_category_product',$manager_category_product);
    }
     public function update_category_product(Request $request,$category_product_id){
        $this->AuthLogin();
      $data  = array();
      $data ['category_name'] = $request->category_product_name; 
    $data ['category_desc'] = $request->category_product_desc; 
     DB::table('category_product')->where('category_id',$category_product_id)->update($data);
      session::put('message','Cập nhập danh mục sản phẩm thành công');
        return Redirect::to('all_category_product');
    }
     public function delete_category_product ($category_product_id){
        $this->AuthLogin();
        DB::table('category_product')->where('category_id',$category_product_id)->delete();
        
        session::put('message','Xoá danh mục sản phẩm thành công');
        return Redirect::to('all_category_product');
    }
}
