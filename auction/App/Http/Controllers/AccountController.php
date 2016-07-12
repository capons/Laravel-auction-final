<?php

namespace App\Http\Controllers;

use App\model\DB\Promise;
use App\model\DB\Request;
use DB;
use Auth;

class AccountController extends Controller {
	
	function getIndex(){ //account index page


		return view('account.index');
	}

	function pageBroughtpromise(){
		$promise_buy = DB::table('winners') //select all promise to buy user
			->join('request', 'winners.promise_id','=','request.promise_id')
			->join('users','request.users_id','=','users.id')
			->join('promise', 'promise.id', '=', 'winners.promise_id')
			->select('winners.bid','promise.title','promise.description as desc','users.f_name as seller')
			->where('winners.winner_id','=',\Auth::user()->id) //buyer id
			->where('winners.if_email','=',1)
			->get();
		return view('account.broughtpromise',['promise_buy' => $promise_buy]);
	}
	function pageOtherpromise(){

		return view('account.otherpromise');
	}
	function pageSellpromise(){
		$promise_sell = DB::table('winners') //select all promise user are sold
		->join('request', 'winners.promise_id','=','request.promise_id')
			->join('users','request.users_id','=','users.id')
			->join('promise', 'promise.id', '=', 'request.promise_id')
			->select('winners.bid','promise.title','promise.description as desc','users.f_name as seller')
			//->where('request.promise_id','=',\Auth::user()->id) //seller id
			->where('winners.if_email','=',1)
			->get();
		return view('account.sellpromise',['promise_sell' => $promise_sell]);
	}
	function pageYourpromise(){
		$request = Promise::where('winner_id', \Auth::user()->id)->get();
		return view('account.yourpromise', ['request' => $request]);
	}
	function requestePromise(){
		
		return view('account.requestedpromises');
	}
}