<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model
{
    protected $table="theloai";
    protected $fillable=[
    	'Ten',
    	'TenKhongDau'
    ];

    public function loaitin()
    {
    	return $this->hasMany(LoaiTin::class,'idTheLoai','id');
    }
    public function tintuc()
    {
    	return $this->hasManyThrough(TinTuc::class,LoaiTin::class,'idTheLoai','idLoaiTin','id');
    }
}
