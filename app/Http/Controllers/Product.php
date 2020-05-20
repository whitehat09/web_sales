<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; /* sử dụng DB*/ 
/*thêm thư viện */
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
class Product extends Controller
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
    public function add_product(){
    	$this->AuthLogin();
    	$cate_product = DB::table('category_product')->orderby('category_id','desc')->get();// hàm orderby hàm sắp xếp theo
    	$brand_product = DB::table('brand_product')->orderby('brand_id','desc')->get();
   
        return view('admin.add_product')->with('cate_product',$cate_product)->with('brand_product',$brand_product);
    }
    public function all_product(){
    	$this->AuthLogin();
        $all_product= DB::table('product')
        ->join('category_product','category_product.category_id','=','product.category_id')
        ->join('brand_product','brand_product.brand_id','=','product.brand_id')
        ->orderby('product.product_id')->get();// dùng biến chứa để chứa dữu liệu của bảng đó 
        // join kết nối 2 bảng với nhau where kèm điều kiện chung 1 thuộc tính join kèm nhiều hàm nên không cần where
        // hàm orderby hàm sắp xếp theo
        $manager_product = view('admin.all_product')->with('all_product',$all_product);
        // Lấy biến chứa dữu liệu của biến đại diện cho bảng với giao diện  
    	return view('admin_layout')->with('admin.all_product',$manager_product);
    }
    public function save_product(Request $request){
    	$this->AuthLogin();
    	$data =  array();
    	$data ['product_name'] = $request->product_name; 
    	$data ['product_price'] = $request->product_price; 
    	$data ['product_desc'] = $request->product_desc; 
    	$data ['product_content'] = $request->product_content; 
    	$data ['category_id'] = $request->product_cate; // lấy giá trị name mà bên giao diện xuất ra 
    	$data ['brand_id'] = $request->product_brand; // lấy giá trị name mà bên giao diện xuất ra
    	$data ['product_status'] = $request->product_status; 
    	$data ['product_image'] = $request->product_image; 
    	$get_image = $request->file('product_image');
    	if ($get_image) {
    		$get_name_image = $get_image->getClientOriginalName();
    		$name_image = current(explode('.', $get_name_image));// lấy kí tự trước dấu chấm 
    		$new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
    		// biến ảnh hàm rand : ngẫu nhiên đặt tên từ 0-99 lấy đuôi sau dấu chấm 
    		$get_image->move('public/uploads/product',$new_image);
    		// biến chứa ảnh dùng hàm move đưa file đến địa chỉ
    		$data['product_image'] = $new_image;
    			DB::table('product')->insert($data);
    	session::put('message','Thêm thương hiệu thành công');
    	return Redirect::to('add_product');
    	}
    	else{
    		$data['product_image'] = '';
    	DB::table('product')->insert($data);
    	session::put('message','Thêm ảnh thương hiệu không thành công');
    	}
    	/*$data['product_image'] = '';
    	DB::table('product')->insert($data);
    	session::put('message','Thêm thương hiệu thành công');*/
    	return Redirect::to('add_product');

    }	
    public function unactive_product ($product_id){
    	$this->AuthLogin();
        DB::table('product')->where('product_id',$product_id)->update(['product_status'=>1]);
        //lấy dữu liệu từ bảng với hàng lấy từ biến hay có thể nói là so sánh với biến rồi đung update để thay đổi giá trị biến
        session::put('message','Không kích hoạt sản phẩm thành công');
        return Redirect::to('all_product');
    }
    public function active_product ($product_id){
         DB::table('product')->where('product_id',$product_id)->update(['product_status'=>0]);
        //lấy dữu liệu từ bảng với hàng lấy từ biến hay có thể nói là so sánh với biến rồi đung update để thay đổi giá trị biến
        session::put('message',' kích hoạt sản phẩm thành công');
        return Redirect::to('all_product');
    }

    public function edit_product($product_id){
    	$this->AuthLogin();
    	$cate_product = DB::table('category_product')->orderby('category_id','desc')->get();
    	$brand_product = DB::table('brand_product')->orderby('brand_id','desc')->get();

        $edit_product= DB::table('product')->where('product_id',$product_id)->get();
        // như hàm thêm nhưng với điều kiện where giống với biến id đã lấy 
        $manager_product = view('admin.edit_product')->with('edit_product',$edit_product)->with('cate_product',$cate_product)->with('brand_product',$brand_product);
        // Lấy biến chứa dữu liệu của biến đại diện cho bảng với giao diện  
        return view('admin_layout')->with('admin.edit_product',$manager_product);
    }
    //  public function update_product(Request $request,$product_id){
    //   $data  = array();
    //  $data ['product_name'] = $request->product_name; 
    // 	$data ['product_price'] = $request->product_price; 
    // 	$data ['product_desc'] = $request->product_desc; 
    // 	$data ['product_content'] = $request->product_content; 
    // 	$data ['category_id'] = $request->product_cate; // lấy giá trị name mà bên giao diện xuất ra 
    // 	$data ['brand_id'] = $request->product_brand; // lấy giá trị name mà bên giao diện xuất ra
    // 	$data ['product_status'] = $request->product_status; 
    // 	$data ['product_image'] = $request->product_image; 
    // 	$get_image = $request->file('product_image');
    // 	if ($get_image) {
    // 		$get_name_image = $get_image->getClientOriginalName();
    // 		$name_image = current(explode('.', $get_name_image));// lấy kí tự trước dấu chấm 
    // 		$new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
    // 		// biến ảnh hàm rand : ngẫu nhiên đặt tên từ 0-99 lấy đuôi sau dấu chấm 
    // 		$get_image->move('public/uploads/product',$new_image);
    // 		// biến chứa ảnh dùng hàm move đưa file đến địa chỉ
    // 		$data['product_image'] = $new_image;
    // 		DB::table('product')->where('product_id',$product_id)->update($data);
    // 	session::put('message','Cập nhập sản phẩm thành công');
    // 	return Redirect::to('all_product');
    // 	}
    // 	else{
    		
    // 	DB::table('product')->where('product_id',$product_id)->update($data);
    // 	session::put('message','Cập nhập sản phẩm không thành công');
    // 	return Redirect::to('all_product');
    // 	}
    // 	/*DB::table('product')->where('product_id',$product_id)->update($data);
    // 	session::put('message','Cập nhập  thương hiệu không thành công');
    // 	*/
    // }
    public function update_product(Request $request,$product_id){
    	$this->AuthLogin();
    	$data =  array();
    	$data ['product_name'] = $request->product_name; 
    	$data ['product_price'] = $request->product_price; 
    	$data ['product_desc'] = $request->product_desc; 
    	$data ['product_content'] = $request->product_content; 
    	$data ['category_id'] = $request->product_cate; // lấy giá trị name mà bên giao diện xuất ra 
    	$data ['brand_id'] = $request->product_brand; // lấy giá trị name mà bên giao diện xuất ra
    	$data ['product_status'] = $request->product_status; 
    	$data ['product_image'] = $request->product_image; 
    	$get_image = $request->file('product_image');
    	if ($get_image) {
    		$get_name_image = $get_image->getClientOriginalName();
    		$name_image = current(explode('.', $get_name_image));// lấy kí tự trước dấu chấm 
    		$new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
    		// biến ảnh hàm rand : ngẫu nhiên đặt tên từ 0-99 lấy đuôi sau dấu chấm 
    		$get_image->move('public/uploads/product',$new_image);
    		// biến chứa ảnh dùng hàm move đưa file đến địa chỉ
    		$data['product_image'] = $new_image;
    			DB::table('product')->where('product_id',$product_id)->update($data);
    	session::put('message','Cập nhập thương hiệu thành công');
    	return Redirect::to('all_product');
    	}
    	else{
    		DB::table('product')->where('product_id',$product_id)->update($data);
    	session::put('message','Cập nhập thương hiệu  thành công');
    	}
    	/*$data['product_image'] = '';
    	DB::table('product')->insert($data);
    	session::put('message','Thêm thương hiệu thành công');*/
    	return Redirect::to('all_product');

    }	
     public function delete_product ($product_id){
     	$this->AuthLogin();
        DB::table('product')->where('product_id',$product_id)->delete();
        
        session::put('message','Xoá  sản phẩm thành công');
        return Redirect::to('all_product');
    }
}
