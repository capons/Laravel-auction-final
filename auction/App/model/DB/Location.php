<?php

namespace App\model\DB;


use Illuminate\Database\Eloquent\Model;

class Location extends Model {

	public $timestamps = false;
	public $table = 'location'; //table name
	protected $fillable = ['name']; //database table row name

	public function users()
	{
		return $this->hasMany('App\User');
	}

}