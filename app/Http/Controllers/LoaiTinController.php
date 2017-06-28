<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;
class LoaiTinController extends Controller
{
  public function getDanhsach()
  {
     $loaitin=LoaiTin::orderBy('id','DESC')->get();
     return view('admin.loaitin.list',['loaitin'=>$loaitin]);
  }
  public function getThem()
  {
   $theloai=TheLoai::all();
   return view('admin.loaitin.add',['theloai'=>$theloai]);
}
public function postThem(Request $request)
{

   $this->validate($request,
      [
      'Ten'=>'required|min:5|max:50|unique:loaitin,Ten', 
      'TheLoai'=>'required'
      ],
      [
      'Ten.required'=>'Vui  lòng nhập tên loại tin',
      'Ten.min'=>'Tối thiểu 5 ký tự',
      'Ten.max'=>'Tối đa chỉ 50 ký tự',
      'Ten.unique'=>'Tên này đã tồn tại!',
      'TheLoai.required'=>'Bạn chưa chọn thể loại'
      ]);
   $loaitin = new LoaiTin;
   $loaitin->Ten=$request->Ten;
   $loaitin->TenKhongDau=changeTitle($request->Ten);
   $loaitin->idTheLoai=$request->TheLoai;
   $loaitin->save();
   return redirect('admin/loaitin/them')->with('thongbao','Đã thêm thành công');
}
public function getSua($id)
{
   $loaitin=LoaiTin::find($id);
   $theloai=TheLoai::all();
   return view('admin.loaitin.edit',['loaitin'=>$loaitin,'theloai'=>$theloai]);
}
public function postSua($id,Request $request)
{
   $loaitin=LoaiTin::find($id);
   $this->validate($request,
      [
      'Ten'=>'required|min:5|max:50', 
      'TheLoai'=>'required'
      ],
      [
      'Ten.required'=>'Vui  lòng nhập tên loại tin',
      'Ten.min'=>'Tối thiểu 5 ký tự',
      'Ten.max'=>'Tối đa chỉ 50 ký tự',
      'TheLoai.required'=>'Bạn chưa chọn thể loại'
      ]);
   $loaitin->Ten=$request->Ten;
   $loaitin->TenKhongDau=changeTitle($request->Ten);
   $loaitin->idTheLoai=$request->TheLoai;
   $loaitin->save();
   return redirect('admin/loaitin/sua/'.$id)->with('thongbao','Đã sửa thành công');
}

public function getXoa($id)
{
   $loaitin=LoaiTin::find($id);
   $loaitin->delete();
   return redirect('admin/loaitin/danhsach')->with('thongbao','Đã xóa:'.$loaitin->Ten);
}
}
