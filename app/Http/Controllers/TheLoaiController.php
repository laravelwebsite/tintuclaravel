<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\Http\Requests\TheLoaiFormRequest;
//use App\function\function;
class TheLoaiController extends Controller
{
   public function getDanhsach()
   {
   	$theloai=TheLoai::all();
   	return view('admin.theloai.list',['theloai'=>$theloai]);
   }
   public function getThem()
   {
   	return view('admin.theloai.add');
   }
   public function postThem(Request $request)
   {
         $this->validate($request,
            [
               'Ten'=>'required|min:5|max:50|unique:theloai,Ten'
            ],
            [
               'Ten.required'=>'Vui  lòng nhập tên thể loại',
               'Ten.min'=>'Tối thiểu 5 ký tự',
               'Ten.max'=>'Tối đa chỉ 50 ký tự',
               'Ten.unique'=>'Tên này đã tồn tại!'
            ]);
         $theloai = new TheLoai;
         $theloai->Ten=$request->Ten;
         $theloai->TenKhongDau=changeTitle($request->Ten);
         $theloai->save();
         return redirect('admin/theloai/them')->with('thongbao','Đã thêm thành công');
   }
   public function getSua($id)
   {
         $theloai=TheLoai::find($id);
      	return view('admin.theloai.edit',['theloai'=>$theloai]);
   }
   public function postSua($id,Request $request)
   {
      $theloai=TheLoai::find($id);
      $this->validate($request,
            [
               'Ten'=>'required|min:5|max:50|unique:theloai,Ten'
            ],
            [
               'Ten.required'=>'Vui  lòng nhập tên thể loại',
               'Ten.min'=>'Tối thiểu 5 ký tự',
               'Ten.max'=>'Tối đa chỉ 50 ký tự',
               'Ten.unique'=>'Tên này đã tồn tại!'
            ]);
         $theloai->Ten=$request->Ten;
         $theloai->TenKhongDau=changeTitle($request->Ten);
         $theloai->save();
      return redirect('admin/theloai/sua/'.$id)->with('thongbao','Sửa thành công!');
   }

   public function getXoa($id)
   {
      $theloai=TheLoai::find($id);
      $theloai->delete();
      return redirect('admin/theloai/danhsach')->with('thongbao','Đã xóa:'.$theloai->Ten);
   }
}
