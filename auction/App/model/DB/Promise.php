<?php

namespace App\model\DB;


use Illuminate\Database\Eloquent\Model;

class Promise extends Model {

	protected $fillable = array('title','description','price','terms','file_id','category_id','type','featured','auction_end','winners','shows','sold','location_id');
	public $table = 'promise';
	public $timestamps = true;
	/*
	function users(){
		$this->belongsTo('App\User');
	}
	function category(){
		$this->belongsTo('App\model\DB\Category');
	}
	function file(){
		return $this->belongsTo('App\model\DB\File');
	}
	function location(){
		return $this->belongsTo('App\model\DB\Location');
	}
	*/
	/*
	function request(){
		//return $this->hasMany('App\model\DB\RequestPro','promise_id','id');
		return $this->hasManyThrough('App\User','App\model\DB\Requeste','promise_id','id');
	}
	*/
	

}