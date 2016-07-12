<?php


namespace App\Http\Controllers;


use App\model\DB\Category;
use App\model\DB\File;
use App\model\DB\Location;
use Illuminate\Http\Request;
use Validator;
use App\model\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;


class AdminCategoryController extends Controller {

    //protected $redirectTo = '/dashboard';
    private $access = ''; //variable shows user access rights

    public function __construct()
    {
        $this->access = Auth::user()->access;
    }
    
    public function validation(Request $request){
        $this->validate($request,
            [
                'name' => 'required|string',
            ]);
    }

    public function getCategory(Request $request){
        if($this->access == 2) {
           // $category = \DB::table('category')->get();
            //costumize gridview
            //costumize filter for gridview
            $filter = \DataFilter::source(new Category);
            //simple like
            $filter->add('name','Name', 'text');
            //simple where with exact match
            //$filter->add('email', 'Email', 'text');//->clause('where')->operator('=');
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
            $grid->add('name','Name', true); //field name, label, sortable
            //$grid->add('email','Email', true); //field  email, label, sortable
            $grid->edit(URL::to('/').'/admin/category', 'Edit','modify|delete'); //shortcut to link DataEdit actions
            //cell closure
            $grid->add('revision','Revision')->cell( function( $value, $row) {
                return ($value != '') ? "rev.{$value}" : "no revisions for art. {$row->id}";
            });
            //$grid->link('/admin/category/new',"Add New", "TR");  //add button
            $grid->orderBy('id','asc'); //default orderby (desc)
            $grid->paginate(10); //pagination

            //Modify Country data
            if(isset($_GET['modify'])){ //modify user data
                $validator = Validator::make($request->all(), //validate $_GET data
                    ['modify' => 'integer']
                );
                $category_id = Input::get('modify');
                //$results = DB::select('select * from users where id = :id', ['id' => $user_data_id]);
                $category_view = \DB::table('category')->where('id', $category_id)->get(); //select user data

                return view('admin.category',['category_view' => $category_view]); //load category data to update
            }
            //delete Country data
            if(isset($_GET['delete'])){ //delete user data
                $id = Input::get('delete'); //user data id
                Category::findOrFail($id)->delete();
                Session::flash('user-info', 'You have successfull detele category name'); //send message to user via flash data
                return redirect('admin/category');
            }

            return view('admin.category',compact('filter','grid')); //load view
        } else {
            Session::flash('user-info', 'Sorry you have no rights'); //send message to user via flash data
            return redirect('/');
        }
    }

    public function modify(Request $request) //modify category data
    {
        $id = Input::get('m-c-id'); //category data id
        $name = Input::get('m-c-name'); //category new name
        $messages = [ //validation message
            'required' => 'The :attribute field is required.',
        ];
        $validator = Validator::make($request->all(), [
            'm-c-name' => 'required', $messages
        ]);
        if ($validator->fails()) { //if true display error
            return redirect('admin/category')//redirect url
            ->withInput()
                ->withErrors($validator); //set validation error name to display in error layout  views/common/errors.blade.php
        } else {
            $values=array('name'=>$name); //update data
            Category::where('id',$id)->update($values);
            Session::flash('user-info', 'You have successfully update data'); //send message to user via flash data
            return redirect('admin/category'); //redirect url
        }
    }

    public function addCategory(Request $request){ //add category
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('admin/category')
                ->withInput()
                ->withErrors($validator); //set validation error name to display in error layout  views/common/errors.blade.php
        }

        $task = new Category();
        $task->name = $request->name;
        $task->save();

        Session::flash('user-info', 'You have successfully add category'); //send message to user via flash data

        return redirect('admin/category'); //redirect after save data
        

    }
}