<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Comment;
//phai khai bao lop nay de su dung lop Auth de dang nhap
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
	public function getDanhsach()
	{
		$userr=User::orderBy('id','DESC')->get();
		return view('admin.user.list',['userr'=>$userr]);
	}
	public function getThem()
	{
		$userr=User::all();
		return view('admin.user.add',['userr'=>$userr]);
	}
	public function postThem(Request $request)
	{

		$this->validate($request,
			[
			'name'=>'required|min:5|max:50', 
			'email'=>'required|email|unique:users,email', 
			'password'=>'required|min:3|max:32',
			'repassword'=>'required|same:password'
			],
			[
			'name.required'=>'Vui  lòng nhập tên họ tên',
			'name.min'=>'Họ tên tối thiểu 5 ký tự',
			'name.max'=>'Tên quá dài',

			'email.required'=>'Vui lòng nhập email',
			'email.email'=>'Email không đúng định dạng',
			'email.unique'=>'Email đã tồn tại',
			'password.required'=>'Vui lòng nhập mật khẩu',
			'password.min'=>'Mật khẩu tối thiểu 3 ký tự',
			'password.max'=>'Mật khẩu tối đa 32 ký tự',
			'repassword.required'=>'Vui lòng nhập xác nhận mật khẩu',
			'repassword.same'=>'Mật khẩu xác nhận không đúng'
			]);
		$user = new User;
		$user->name=$request->name;
		$user->email=$request->email;
		$user->quyen=$request->quyen;
		$user->password=bcrypt($request->password);
		$user->save();
		return redirect('admin/user/them')->with('thongbao','Đã thêm thành công');
	}
	public function getSua($id)
	{
		$userr=User::find($id);
		return view('admin.user.edit',['userr'=>$userr]);
	}
	public function postSua($id,Request $request)
	{
		$this->validate($request,
			[
			'name'=>'required|min:5|max:50', 
			],
			[
			'name.required'=>'Vui  lòng nhập tên họ tên',
			'name.min'=>'Họ tên tối thiểu 5 ký tự',
			'name.max'=>'Tên quá dài',
			]);
		$user=User::find($id);
		$user->name=$request->name;
		$user->quyen=$request->quyen;
		if($request->changePassword=="on")
		{
			$this->validate($request,
				[
				'password'=>'required|min:3|max:32',
				'repassword'=>'required|same:password'
				],
				[
				'password.required'=>'Vui lòng nhập mật khẩu',
				'password.min'=>'Mật khẩu tối thiểu 3 ký tự',
				'password.max'=>'Mật khẩu tối đa 32 ký tự',
				'repassword.required'=>'Vui lòng nhập xác nhận mật khẩu',
				'repassword.same'=>'Mật khẩu xác nhận không đúng'
				]);
			$user->password=bcrypt($request->password);
		}
		
		$user->save();
		return redirect('admin/user/sua/'.$id)->with('thongbao','Đã sửa thành công');
	}

	public function getXoa($id)
	{
		$user=User::find($id);
		$comment=Comment::where('idUser',$id);
		$comment->delete();
		$user->delete();
		return redirect('admin/user/danhsach')->with('thongbao','Đã xóa người dùng:'.$user->email);
	}

	public function getDangnhapAdmin()
	{
		return view('admin.login');
	}
	public function postDangnhapAdmin(Request $request)
	{
		$this->validate($request,
			[
			'email'=>'required|min:5|max:50',
			'password'=>'required|min:3|max:32'
			],
			[
			
			]);
		if (Auth::attempt(['email' =>$request->email, 'password' => $request->password])) {
    			return redirect('admin/theloai/danhsach');
		}
		//neu dang nhap thanh cong
		
		else
		{
			return redirect('admin/dangnhap')->with('thongbao','Sai tên tài khoản hoặc mật khẩu');
		}
	}
	public function getDangXuatAdmin()
	{
		Auth::logout();
		return redirect('admin/dangnhap');
	}
}
