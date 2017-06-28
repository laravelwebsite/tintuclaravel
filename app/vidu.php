<?php 
namespace App;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

class vidu extends Eloquent {

	protected $connection = 'mongodb';
   	protected $collection = 'theloai';
   	//protected $primaryKey = '_id';

}
