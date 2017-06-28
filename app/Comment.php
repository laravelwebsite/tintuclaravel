<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table="comment";

    public function tintuc()
    {
    	return $this->belongsTo(TinTuc::class,'idTinTuc','id');
    }
    public function user()
    {
    	return $this->belongsTo(User::class,'idUser','id');
    }
}
