<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
use App\Http\Requests\TheLoaiFormRequest;
//use App\function\function;
class AjaxController extends Controller
{
   function getLoaiTin($idTheLoai)
   {
      $loaitin=LoaiTin::where('idTheLoai',$idTheLoai)->get();
      foreach ($loaitin as  $lt) {
         echo "<option value='".$lt->id."'>".$lt->Ten."</option>";
      }
   }
}
