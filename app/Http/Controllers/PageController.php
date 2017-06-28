<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\Slide;
use App\LoaiTin;
use App\TinTuc;
use App\Comment;
use App\User;
use Illuminate\Support\Facades\Auth;
//noi quan ly trang index nguoi dung
class PageController extends Controller
{
	public function __construct()
	{

		$theloai=TheLoai::orderBy('Ten','ASC')->get();
		$slide=Slide::all();
		view()->share('theloai',$theloai);
		view()->share('slide',$slide);

	}
	public function trangchu()
	{

		return view('pages.trangchu');
	}
	public function lienhe()
	{
		return view('pages.lienhe');
	}
	public function loaitin($id)
	{
		$loaitin=LoaiTin::find($id);
		$tintuc=TinTuc::where('idLoaiTin',$id)->paginate(5);
		return view('pages.loaitin',['loaitin'=>$loaitin,'tintuc'=>$tintuc]);
	}
	public function chitiet($id)
	{
		$tintuc=TinTuc::find($id);
		$tinnoibat=TinTuc::where('NoiBat',1)->orderBy('created_at','DESC')->take(4)->get();
		$tinlienquan=TinTuc::where('idLoaiTin',$tintuc->idLoaiTin)->orderBy('created_at','DESC')->take(4)->get();
		return view('pages.chitiet',['tintuc'=>$tintuc,'tinnoibat'=>$tinnoibat,'tinlienquan'=>$tinlienquan]);
	}
	public function getDangNhap()
	{
		return view('pages.dangnhap');
	}
	public function postDangNhap(Request $request)
	{
		$this->validate($request,
			[
			'email'=>'required|min:5|max:50',
			'password'=>'required|min:3|max:32'
			],
			[
			
			]);
		if (Auth::attempt(['email' =>$request->email, 'password' => $request->password])) {
    			return redirect('trangchu');
		}
		//neu dang nhap thanh cong
		
		else
		{
			return redirect('dangnhap')->with('thongbao','Sai tên tài khoản hoặc mật khẩu');
		}
	}
	public function DangXuat()
	{
		Auth::logout();
		return redirect('trangchu');
	}
	public function getDangKy()
	{
		return view('pages.dangky');
	}
	public function postDangKy(Request $request)
	{
		$this->validate($request,
			[
			'name'=>'required|min:5|max:50', 
			'email'=>'required|email|unique:users,email', 
			'password'=>'required|min:3|max:32',
			'passwordAgain'=>'required|same:password'
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
			'passwordAgain.required'=>'Vui lòng nhập xác nhận mật khẩu',
			'passwordAgain.same'=>'Mật khẩu xác nhận không đúng'
			]);
		$user = new User;
		$user->name=$request->name;
		$user->email=$request->email;
		$user->quyen=0;
		$user->password=bcrypt($request->password);
		$user->save();
		return redirect('dangnhap')->with('dangky','Đăng ký tài khoản thành công');
	}
	public function postComment($idTinTuc,Request $request)
	{
		$this->validate($request,[
			'NoiDung'=>"required|min:4"		
		]);
		$idtt=$idTinTuc;
		$tintuc=TinTuc::find($idTinTuc);
		$comment=new Comment;
		$comment->idTinTuc=$idtt;
		$comment->idUser=Auth::user()->id;
		$comment->NoiDung=$request->NoiDung;
		$comment->save();
		return redirect("chitiet/$idtt/".$tintuc->TieuDeKhongDau.".html");

	}

	public function postTimKiem(Request $request)
	{
		$tukhoa=$request->TuKhoa;
		$tintuc=TinTuc::where('TieuDe','like',"%$tukhoa%")->orWhere('TomTat','like',"%$tukhoa%")->orWhere('NoiDung','like',"%$tukhoa%")->take(30)->paginate(6);
		return view('pages.timkiem',['tintuc'=>$tintuc,'tukhoa'=>$tukhoa]);

	}
}
