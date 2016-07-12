<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller {

	private $access = ''; //variable shows user access rights

	public function __construct()
	{
		$this->access = Auth::user()->access;
	}
	/*
	public function users(){
		if($this->access == 2) {
			//return view('admin.index',$this->users());
			//$user_data = \DB::table('users')->select('users.f_name','users.email','location.name as location','category.name as category')->join('location','users.location_id','=','location.id')->join('category','users.category_id','=','category.id')->get();
			//$user_data = \DB::table('users')->get();
			$grid = \DataGrid::source(\DB::table('users')->get());
			$grid->add('f_name','Name', true); //field name, label, sortable
			$grid->add('email','Email', true); //field  email, label, sortable
			$grid->edit('/articles/edit', 'Edit','modify|delete'); //shortcut to link DataEdit actions

			//cell closure
			$grid->add('revision','Revision')->cell( function( $value, $row) {
				return ($value != '') ? "rev.{$value}" : "no revisions for art. {$row->id}";
			});

			$grid->link('/articles/edit',"Add New", "TR");  //add button
			$grid->orderBy('id','desc'); //default orderby
			$grid->paginate(10); //pagination
			//return view('admin.index',['users_grid' => compact('grid')]);
			return view('admin.index', compact('grid'));

		} else {
			Session::flash('user-info', 'Sorry you have no rights'); //send message to user via flash data
			return redirect('/');
		}
	}
	*/
	public function getIndex(){
		if($this->access == 2) {
			return view('admin.default');
		} else {
			Session::flash('user-info', 'Sorry you have no rights'); //send message to user via flash data
			return redirect('/');
		}
	}
	public function pagePromise(){

		if($this->access == 2) {
			return view('admin.promise');
		} else {
			Session::flash('user-info', 'Sorry you have no rights'); //send message to user via flash data
			return redirect('/');
		}
	}
	/*
	public function users(){ //method to request by DataTable from view admin/index (and display user data)
		//$user = \DB::table('users')->select('users.f_name','users.email','location.name as location','category.name as category')->join('location','users.location_id','=','location.id')->join('category','users.category_id','=','category.id')->get();
		//return ['data'=>$user];
		$user_data = \DB::table('users')->get();
		return ['data' => $user_data];



	}
	*/
	public function promise(){ //display promise data in view -> request from DataTable library from admin/promise view

		$user = \DB::table('promise as p')
			->select('p.title','p.price')
			->get();
		//need to load view for promise controller
		return ['data'=>$user];

	}
}