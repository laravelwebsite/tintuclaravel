<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slide;
class SlideController extends Controller
{
	public function getDanhsach()
	{
		$slide=Slide::orderBy('id','DESC')->get();
		return view('admin.slide.list',['slide'=>$slide]);
	}
	public function getThem()
	{
		$slide=Slide::all();
		return view('admin.slide.add',['slide'=>$slide]);
	}


	public function postThem(Request $request)
	{

		$this->validate($request,
			[
			'Ten'=>'required|min:5|max:50|unique:slide,Ten', 
			'NoiDung'=>'required|min:5'
			],
			[
			'Ten.required'=>'Vui  lòng nhập tên slide',
			'Ten.min'=>'Tối thiểu 5 ký tự',
			'Ten.max'=>'Tối đa chỉ 50 ký tự',
			'Ten.unique'=>'Tên này đã tồn tại!',
			'NoiDung.required'=>'Bạn chưa nhập nội dung',
			'NoiDung.min'=>'Nội dung tối thiểu 5 ký tự'
			]);
		$slide = new Slide;
		$slide->Ten=$request->Ten;
		$slide->NoiDung=$request->NoiDung;
		if($request->hasFile('Hinh'))
		{
			$file=$request->file('Hinh');
            		$name=$file->getClientOriginalName();//lay ra ten file
            		$duoi=$file->getClientOriginalExtension();//llay ra duoi file
            		if($duoi!= 'png' && $duoi != 'jpg' && $duoi != 'jpeg')
            		{
            			return redirect('admin/slide/them')->with('loi','Định dạng đuôi file không đúng.Bạn chỉ được upload file có đuôi jpg,jpeg,png');
            		}
		            $hinh=str_random(10)."_".$name;//random  va noi dau _ de khong trung ten
		            while(file_exists("upload/slide/".$hinh))//neu van trung thi random tiep
		            {
		            	$hinh=str_random(10)."_".$name;
		            }
		            $file->move('upload/slide',$hinh);//vi tri luu va ten file
		            $slide->Hinh=$hinh;
		            $slide->link='upload/slide/'.$hinh;
		        }

		        else
		        {
		        	$slide->Hinh="";
		        }
		        $slide->save();
		        return redirect('admin/slide/them')->with('thongbao','Đã thêm thành công');
		    }
		    public function getSua($id)
		    {
		    	$slide=slide::find($id);
		    	return view('admin.slide.edit',['slide'=>$slide]);
		    }




		    public function postSua($id,Request $request)
		    {
		    	$this->validate($request,
			[
			'Ten'=>'required|min:5|max:50', 
			'NoiDung'=>'required|min:5'
			],
			[
			'Ten.required'=>'Vui  lòng nhập tên slide',
			'Ten.min'=>'Tối thiểu 5 ký tự',
			'Ten.max'=>'Tối đa chỉ 50 ký tự',
			'NoiDung.required'=>'Bạn chưa nhập nội dung',
			'NoiDung.min'=>'Nội dung tối thiểu 5 ký tự'
			]);
		$slide = Slide::find($id);
		$slide->Ten=$request->Ten;
		$slide->NoiDung=$request->NoiDung;
		if($request->hasFile('Hinh'))
		{
			$file=$request->file('Hinh');
            		$name=$file->getClientOriginalName();//lay ra ten file
            		$duoi=$file->getClientOriginalExtension();//llay ra duoi file
            		if($duoi!= 'png' && $duoi != 'jpg' && $duoi != 'jpeg')
            		{
            			return redirect('admin/slide/them')->with('loi','Định dạng đuôi file không đúng.Bạn chỉ được upload file có đuôi jpg,jpeg,png');
            		}
		            $hinh=str_random(10)."_".$name;//random  va noi dau _ de khong trung ten
		            while(file_exists("upload/slide/".$hinh))//neu van trung thi random tiep
		            {
		            	$hinh=str_random(10)."_".$name;
		            }
		            $file->move('upload/slide',$hinh);//vi tri luu va ten file
		            $slide->Hinh=$hinh;
		            $slide->link='upload/slide/'.$hinh;
		        }

		        else
		        {
		        	
		        }
		        $slide->save();
		        return redirect('admin/slide/sua/'.$id)->with('thongbao','Đã sửa thành công');
		    }


		    public function getXoa($id)
		    {
		    	$slide=slide::find($id);
		    	$slide->delete();
		    	return redirect('admin/slide/danhsach')->with('thongbao','Đã xóa:'.$slide->Ten);
		    }

		}
