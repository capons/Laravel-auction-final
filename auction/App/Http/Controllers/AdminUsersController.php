<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class AdminUsersController extends Controller
{
    private $access = ''; //variable shows user access rights

    public function __construct()
    {
        $this->access = Auth::user()->access;
    }

    public function users(Request $request){
        if($this->access == 2) {
            //return view('admin.index',$this->users());
            //$user_data = \DB::table('users')->select('users.f_name','users.email','location.name as location','category.name as category')->join('location','users.location_id','=','location.id')->join('category','users.category_id','=','category.id')->get();
            //$user_data = \DB::table('users')->get();


            //costumize gridview
            //costumize filter for gridview
            $filter = \DataFilter::source(new User);
            //simple like
            $filter->add('f_name','Name', 'text'); //one input search
            //simple where with exact match
            $filter->add('email', 'Email', 'text'); //two input search //->clause('where')->operator('=');
            //custom query scope, you can define the query logic in your model
            // $filter->add('search','Search text', 'text')->scope('myscope');
            //cool deep "whereHas" (you must use DeepHasScope trait bundled on your model)
            //this can build a where on a very deep relation.field
            //  $filter->add('search','Search text', 'text')->scope('hasRel','relation.relation.field');
            //closure query scope, you can define on the fly the where
            // $filter->add('search','Search text', 'text')->scope( function ($query, $value) {
            //     return $query->whereIn('field', ["1","3",$value]);
            //  });
            $filter->submit('search');
            $filter->reset('reset');
            //$grid = \DataGrid::source(\DB::table('users')->get());
            $grid = \DataGrid::source($filter);
            $grid->add('f_name','Name', true); //field name, label, sortable
            $grid->add('email','Email', true); //field  email, label, sortable
            $grid->edit(URL::to('/').'/admin/users', 'Edit','modify|delete'); //shortcut to link DataEdit actions
            //cell closure
            $grid->add('revision','Revision')->cell( function( $value, $row) {
                return ($value != '') ? "rev.{$value}" : "no revisions for art. {$row->id}";
            });
            $grid->link('/admin/users/new',"Add New", "TR");  //add button
            $grid->orderBy('id','asc'); //default orderby (desc)
            $grid->paginate(10); //pagination



            if(isset($_GET['modify'])){ //modify user data
                $validator = Validator::make($request->all(), //validate $_GET data
                ['modify' => 'integer']
                );
                $user_data_id = Input::get('modify');
                //$results = DB::select('select * from users where id = :id', ['id' => $user_data_id]);
                $user_view = \DB::table('users')->where('id', $user_data_id)->get(); //select user data

                return view('admin.index',['user_view' => $user_view]); //load user data to update
            } //else {
            if(isset($_GET['delete'])){ //delete user data
                $id = Input::get('delete'); //user data id
                User::findOrFail($id)->delete();
                Session::flash('user-info', 'You have successfull detele user data'); //send message to user via flash data
                return redirect('admin/users');
            }
            return view('admin.index', compact('filter','grid')); //load view with and user data in GridView
            //}

        } else {
            Session::flash('user-info', 'Sorry you have no rights'); //send message to user via flash data
            return redirect('/');
        }
    }
    public function modify(Request $request)
    {
       // $method = $request->method();
        //if($request->isMethod('post')) {
        /*
            $id = Input::get('m-id'); //user data id
            $name = Input::get('m-name');
            $email = Input::get('m-email');
        */
            $messages = [ //validation message
                'required' => 'The :attribute field is required.',
            ];
            $validator = Validator::make($request->all(), [
                'm-name' => 'required',
                'm-email' => 'required'
            ], $messages);
            if ($validator->fails()) { //if true display error
                return redirect('admin/users')//redirect url
                ->withInput()
                    ->withErrors($validator); //set validation error name to display in error layout  views/common/errors.blade.php
            } else {
                $id = Input::get('m-id'); //user data id
                $name = Input::get('m-name');
                $email = Input::get('m-email');
                $values=array('f_name'=>$name,'email'=>$email); //update data
                User::where('id',$id)->update($values);
                Session::flash('user-info', 'You have successfully update data'); //send message to user via flash data
                return redirect('admin/users'); //redirect url
            }

    }
    public function newUser(Request $request){
        if($this->access == 2) { //add new user
            /*
            $id = Input::get('m-id'); //user data id
            $name = Input::get('m-name');
            $email = Input::get('m-email');
            $messages = [ //validation message
                'required' => 'The :attribute field is required.',
            ];
            $validator = Validator::make($request->all(), [
                'm-name' => 'required',
                'm-email' => 'required', $messages
            ]);
            if ($validator->fails()) { //if true display error
                return redirect('admin/users/new')//redirect url
                ->withInput()
                    ->withErrors($validator); //set validation error name to display in error layout  views/common/errors.blade.php
            } else {
                $values=array('f_name'=>$name,'email'=>$email); //update data
                User::where('id',$id)->update($values);
                Session::flash('user-info', 'You have successfully add new user'); //send message to user via flash data
                return redirect('admin/users'); //redirect url
            }
            */
            
            return view('admin.new_user'); //load view
        } else {
            Session::flash('user-info', 'Sorry you have no rights'); //send message to user via flash data
            return redirect('/');
        }
    }
    public function delete(Request $request){
        $id = Input::get('delete'); //user data id
        User::findOrFail($id)->delete();
        Session::flash('user-info', 'You have successfull detele user data'); //send message to user via flash data
        return redirect('admin/users');
    }
}