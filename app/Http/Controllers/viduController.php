<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\vidu;
use DB;
use App\Quotation;
class viduController extends Controller
{
	public function test()
	{
		$user = DB::collection('theloai')->where('id', '1')->first();
		return view('pages.lienhe',['kq'=>$user]);
	}
}