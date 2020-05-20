<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB; /* sử dụng DB*/ 
/*thêm thư viện */
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class AdminController extends Controller
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
    public function index(){

    	return view('admin_login');
    }
    public function showdashboard(){
        $this->AuthLogin();// chạy hàm đăng nhập trước khi dùng 
    	return view('admin.dashboard');
    }
    public function dashboard(Request $Request){ /*Request sử dụng biến yêu cầu*/
    	$admin_email = $Request->admin_email; /*tạo biến mới rồi yêu cầu dữ liệu vào biến đó*/

    	$admin_password = md5($Request->admin_password);
    	$result = DB::table('admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first(); /*biến kết quả lấy dữ liệu tuwf DB bảng admin cột admin vào biến $admin...  first() là chỉ 1 lấy 1 hàng */
    	
    	;
    	if ($result) {
    		Session::put('admin_name',$result->admin_name);
    		Session::put('admin_id',$result->admin_id);
    		Session::put('admin_password',$result->admin_password);
    		
    		return Redirect::to('/dashboard');/*trả về trang dashboard nếu đúng*/
    	}else{
    		Session::put('message','Mật khẩu hoặc tài khoản sai ! ');/*trả lại message put là đặt cacis gì bằng cái gì get là lấy ra*/
    		
    		return Redirect::to('/admin');/*sai hoàn tác lại trang*/
    	}
    }
    public function logout(){
         $this->AuthLogin();// chạy hàm đăng nhập trước khi dùng 
    	Session::put('admin_name',null);
    	Session::put('admin_id',null);
    	return Redirect::to('/admin');
    }
}
