<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\TinTuc;
use App\LoaiTin;
use App\Comment;
use App\Http\Requests\TheLoaiFormRequest;
//use App\function\function;
class TinTucController extends Controller
{
   public function getDanhsach()
   {
   	$tintuc=TinTuc::orderBy('id','DESC')->get();
   	return view('admin.tintuc.list',['tintuc'=>$tintuc]);
   }
   public function getThem()
   {
      $theloai=TheLoai::all();
      $loaitin=LoaiTin::all();
      return view('admin.tintuc.add',['theloai'=>$theloai,'loaitin'=>$loaitin]);
   }
   public function postThem(Request $request)
   {
      $this->validate($request,
         [
         'TheLoai'=>'required',
         'LoaiTin'=>'required',
         'TieuDe'=>'required|min:5|max:50|unique:tintuc,TieuDe|regex:[a-z{1}[A-Z]{1}[0-9]{1}]',
         'TomTat'=>'required|min:10|max:500',
         'NoiDung'=>'required|min:50',
         ],
         [
         'TheLoai.required'=>'Bạn chưa chọn tên thể loại',
         'LoaiTin.required'=>'Bạn chưa chọn tên loại tin',
         'TieuDe.required'=>'Bạn chưa nhập tiêu đề',
         'TomTat.required'=>'Bạn chưa nhập tóm tắt',
         'NoiDung.required'=>'Bạn chưa nhập nội dung',
         'TieuDe.min'=>'Tiêu đề tối thiểu 5 ký tự',
         'TieuDe.max'=>'Tiêu đề tối đa 50 ký tự',
         'TomTat.min'=>'Tóm tắt tối thiểu 10 ký tự',
         'TomTat.max'=>'Tóm tắt tối đa 500 ký tự',
         'NoiDung.min'=>'Nội dung Tối thiểu 50 ký tự',
         'TieuDe.unique'=>'Tiêu đề đã tồn tại',
         ]);
      $tintuc = new TinTuc;
      $tintuc->TieuDe=$request->TieuDe;
      $tintuc->TieuDeKhongDau=changeTitle($request->TieuDe);
      $tintuc->TomTat=$request->TomTat;
      $tintuc->NoiDung=$request->NoiDung;
      $tintuc->idLoaiTin=$request->LoaiTin;
      $tintuc->SoLuotXem=0;
      $tintuc->NoiBat=$request->NoiBat; 
      if($request->hasFile('Hinh'))
      {
         $file=$request->file('Hinh');
            $name=$file->getClientOriginalName();//lay ra ten file
            $duoi=$file->getClientOriginalExtension();//llay ra duoi file
            if($duoi!= 'png' && $duoi != 'jpg' && $duoi != 'jpeg')
            {
             return redirect('admin/tintuc/them')->with('loi','Định dạng đuôi file không đúng.Bạn chỉ được upload file có đuôi jpg,jpeg,png');
          }
            $hinh=str_random(10)."_".$name;//random  va noi dau _ de khong trung ten
            while(file_exists("upload/tintuc/".$hinh))//neu van trung thi random tiep
            {
               $hinh=str_random(10)."_".$name;
            }
            $file->move('upload/tintuc',$hinh);//vi tri luu va ten file
            $tintuc->Hinh=$hinh;
         }
         else
         {
            $tintuc->Hinh="";
         }
         $tintuc->save();
         return redirect('admin/tintuc/them')->with('thongbao','Đã thêm thành công');
      }
      public function getSua($id)
      {
         $tintuc=TinTuc::find($id);
         $theloai=TheLoai::all();
         $loaitin=LoaiTin::all();
         return view('admin.tintuc.edit',['theloai'=>$theloai,'loaitin'=>$loaitin,'tintuc'=>$tintuc]);
      }
      public function postSua($id,Request $request)
      {
         $tintuc=TinTuc::find($id);
         $this->validate($request,
            [
            'TheLoai'=>'required',
            'LoaiTin'=>'required',
            'TieuDe'=>'required|min:5|max:50',
            'TomTat'=>'required|min:10|max:500',
            'NoiDung'=>'required|min:50',
            ],
            [
            'TheLoai.required'=>'Bạn chưa chọn tên thể loại',
            'LoaiTin.required'=>'Bạn chưa chọn tên loại tin',
            'TieuDe.required'=>'Bạn chưa nhập tiêu đề',
            'TomTat.required'=>'Bạn chưa nhập tóm tắt',
            'NoiDung.required'=>'Bạn chưa nhập nội dung',
            'TieuDe.min'=>'Tiêu đề tối thiểu 5 ký tự',
            'TieuDe.max'=>'Tiêu đề tối đa 50 ký tự',
            'TomTat.min'=>'Tóm tắt tối thiểu 10 ký tự',
            'TomTat.max'=>'Tóm tắt tối đa 500 ký tự',
            'NoiDung.min'=>'Nội dung Tối thiểu 50 ký tự',
            ]);
         $tintuc->TieuDe=$request->TieuDe;
         $tintuc->TieuDeKhongDau=changeTitle($request->TieuDe);
         $tintuc->TomTat=$request->TomTat;
         $tintuc->NoiDung=$request->NoiDung;
         $tintuc->idLoaiTin=$request->LoaiTin;
         $tintuc->SoLuotXem=0;
         $tintuc->NoiBat=$request->NoiBat;
         if($request->hasFile('Hinh'))
         {
            $file=$request->file('Hinh');
            $name=$file->getClientOriginalName();//lay ra ten file
            $duoi=$file->getClientOriginalExtension();//llay ra duoi file
            if($duoi!= 'png' && $duoi != 'jpg' && $duoi != 'jpeg')
            {
             return redirect('admin/tintuc/them')->with('loi','Định dạng đuôi file không đúng.Bạn chỉ được upload file có đuôi jpg,jpeg,png');
          }
            $hinh=str_random(10)."_".$name;//random  va noi dau _ de khong trung ten
            while(file_exists("upload/tintuc/".$hinh))//neu van trung thi random tiep
            {
               $hinh=str_random(10)."_".$name;
            }
            $file->move('upload/tintuc',$hinh);//vi tri luu va ten file
            unlink('upload/tintuc/'.$tintuc->Hinh);//xoas hinh cu di
            $tintuc->Hinh=$hinh;
         }
         else
         {

         }
         $tintuc->save();
         return redirect('admin/tintuc/sua/'.$id)->with('thongbao','Đã sửa thành công');
      }

      public function getXoa($id)
      {
         $tintuc=TinTuc::find($id);
         $tintuc->delete();
         return redirect('admin/tintuc/danhsach')->with('thongbao','Đã xóa:'.$tintuc->TieuDe);
      }
   }
