<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use app\model\DB;
use App\model\DB\File;
use App\User;
use Session;
use App\Library\UpBid;
use App\Library\AuctionEnd;

class UserController extends Controller {
	use AuctionEnd; //auction end trait
	

	protected $redirectTo = 'user/index';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		AuctionEnd::auctionOver(); //auction close if end auction time
	}

	public function getIndex(){  //main view
		
		return view('user.index');
	}

	public function getRegister(){

		return view('user.register');
	}
	public function uploadedFile(){
		$file = File::select()->where('users_id','=',\Auth::user()->id)->get();
		return $file;
	}
}