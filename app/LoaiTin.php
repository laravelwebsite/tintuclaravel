<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoaiTin extends Model
{
    protected $table="loaitin";

    public function theloai()
    {
    	return $this->belongsTo(TheLoai::class,'idTheLoai','id');
    }
    public function tintuc()
    {
    	return $this->hasMany(TinTuc::class,'idLoaiTin','id');
    }
}
