<?php

namespace App\model\DB;


use Illuminate\Database\Eloquent\Model;

class File extends Model {
	protected $table = 'file';
	protected $fillable = array('name','path','type','users_id','url');
	public $timestamps = false;

}