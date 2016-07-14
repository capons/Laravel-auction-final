<?php

namespace App\Http\Controllers;


use App\Library\UpBid;  //class to sort update winners bid data
//use App\Library\AuctionEnd;
use App\model\DB\Category;
use App\model\DB\File;
use App\model\DB\Location;
use App\model\DB\Promise;
use App\model\DB\Requeste;
use App\model\DB\Search;
use App\model\DB\Winner;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Input;
use Session;
use DB;
use Illuminate\Support\Facades\Mail;

class PromiseController extends Controller {
	//use AuctionEnd;

	protected $redirectTo = '/promise/sell';

	public function __construct(){
		//$this->auctionOver();
	}

	public function validation(array $data){
		$messages = [          //validation message
			'prom_category.required' => 'Category is required',
			'prom_location.required' => 'Location is required',
			'prom_title.required' => 'Title is required',
			'prom_title.max:50' => 'Title length max 50',
			'prom_available_time.required' => 'Promise amount is required',
			'prom_available_time.max:20' => 'Promise length-no more than 20 characters',
			'prom_desc.required' => 'Promise description is required',
			'prom_desc.max:150' => 'Promise description max 150 character',
			'prom_terms.required' => 'Promise terms is required',
			'prom_terms.max:150' => 'Promise terms max 150 character',
			'prom_price.required' => 'Promise price is required',
			'prom_auction_number.required' => 'Promise auction amount is required',
			'prom_upload.required' => 'Promise image is required',
			'prom_auction_end.required' => 'Auction expired required',
			'prom_auction_end.numeric' => 'Insert auction active days '
		];
		return Validator::make($data, [   //validation registration form
			'sell_promise_type' => 'numeric',
			'prom_category' => 'required',
			'prom_location' => 'required',
			'prom_title' => 'required|string|max:50',
			'prom_available_time' => 'required|numeric|max:20',
			'prom_desc' => 'required|max:150',
			'prom_terms' => 'required|max:150',
			'prom_auction_number' => 'required|numeric',
			'shows' => '',
			'prom_price' => 'required|numeric',
			'prom_upload' => 'required',
			'prom_auction_end' => 'required|numeric',
		],$messages);
	}


	public function pageSell(){ //sell promise view
		$category = Category::all();
		$location = Location::all();
		return view('promise.sell',['category' => $category,'location' => $location]);
	}

	public function add(Request $request){ //add promise for sale and auction
		$error = array();
		if(Input::get('sell_promise_type') == 0) { //if check promise to sell
			if (!$request->input('select_image_from_our_database')) { // input to upload file from our database
				$validator = $this->validation($request->all());
				if ($validator->fails()) {
					return redirect('promise/sell')
						->withInput()
						->withErrors($validator);
				} else {
					$v = Validator::make($request->all(), [
						'file' => 'mimes:jpeg,bmp,png',
					]);
					if ($v->fails()) {
						return $v->errors();
					} else {
						$file = \Request::file('prom_upload');
						$path = \Config::get('app.setting.upload') . '\\' . \Auth::user()->id;
						$name = time() . '.' . $file->getClientOriginalExtension();
						if ($file->move($path, $name)) {
							$file = File::create(['name' => $name, 'path' => $path, 'users_id' => \Auth::user()->id, 'url' => \Config::get('app.setting.url_upload') . '/' . \Auth::user()->id]);
						}
					}
				}
			} else {
				$file = File::find($request->input('select_image_from_our_database')); //input containes id of our image in database
			}
				$promise_value = Input::get('prom_available_time');

				$data = array( 
					'title' => Input::get('prom_title'),
					'description' => Input::get('prom_desc'),
					'price' => round((float)Input::get('prom_price'), 2), //round for 2 decimel
					'terms' => Input::get('prom_terms'),
					'type' => Input::get('sell_promise_type'),       //if type 0 => (for sale) if type 1 => (auction)
					'winners' => Input::get('prom_auction_number'),
					'file_id' => $file->id,                         //image upload id
					'category_id' => Input::get('prom_category'),
					'location_id' => Input::get('prom_location'),
				);

				$promise = Promise::create($data);
				if (!$promise) {
					$error[] = \Lang::get('message.error.save_db');
				} else {
					$request_data = array(
						'promise_id' => $promise->id, //last save promise id
						'amount' => $promise_value,
						'users_id' => \Auth::user()->id,
					);

					$p_request = Requeste::create($request_data);
					if (!$p_request) {
						$error[] = \Lang::get('message.error.save_db');
					} else {
						/*
						$winners_data = array (
							'promise_id' => $promise->id
						);
						$w_request = Winner::create($winners_data);
						if (!$w_request) {
							$error[] = \Lang::get('message.error.save_db');
						}
						*/
						Session::flash('user-info', 'Promise added successfully'); //send message to user via flash data
						return redirect($this->redirectTo);
						die();
					}

				}
		} elseif (Input::get('sell_promise_type') == 1){ //if check promise auction
			$error = array();
			if (!$request->input('select_image_from_our_database')) { // input to upload file from our database
				$validator = $this->validation($request->all());
				if ($validator->fails()) {
					/*
                    $this->throwValidationException(
                        $request, $validator
                    );
                    */
					return redirect('promise/sell')
						->withInput()
						->withErrors($validator);
				} else {
					$v = Validator::make($request->all(), [
						'file' => 'mimes:jpeg,bmp,png',
					]);
					if ($v->fails()) {
						return $v->errors();
					} else {
						$file = \Request::file('prom_upload');
						$path = \Config::get('app.setting.upload') . '\\' . \Auth::user()->id;
						$name = time() . '.' . $file->getClientOriginalExtension();
						if ($file->move($path, $name)) {
							$file = File::create(['name' => $name, 'path' => $path, 'users_id' => \Auth::user()->id, 'url' => \Config::get('app.setting.url_upload') . '/' . \Auth::user()->id]);
						}
					}
				}
			} else {
				$file = File::find($request->input('select_image_from_our_database')); //input containes id of our image in database
			}
			$promise_value = Input::get('prom_available_time'); //number of Promises for sale
			$auction_days = Input::get('prom_auction_end'); //days auction end
			$to_change = '+ '.$auction_days.' day';
			$date = date("Y-m-d H:i:s");
			$date = strtotime($date);
			$date = strtotime($to_change, $date); //date in future when auction is expired
			$number_of_winners = Input::get('prom_auction_number');
			$winners_array = array();


			$data = array(
				'title' => Input::get('prom_title'),
				'description' => Input::get('prom_desc'),
				'price' => Input::get('prom_price'),
				'terms' => Input::get('prom_terms'),
				'type' => Input::get('sell_promise_type'),       //if type 0 => (for sale) if type 1 => (auction)
				'winners' => Input::get('prom_auction_number'),
				'file_id' => $file->id,                         //image upload id
				'auction_end' => date("Y-m-d H:i:s",$date),     //date auction expire
				'category_id' => Input::get('prom_category'),
				'location_id' => Input::get('prom_location'),
			);
			$promise = Promise::create($data);
			if (!$promise) {
				$error[] = \Lang::get('message.error.save_db');
			} else {
				$request_data = array(
					'promise_id' => $promise->id, //last save promise id
					'amount' => $promise_value,
					'users_id' => \Auth::user()->id,
				);
				$p_request = Requeste::create($request_data);
				if (!$p_request) {
					$error[] = \Lang::get('message.error.save_db');
				} else {
					Session::flash('user-info', 'Promise added successfully'); //send message to user via flash data
					return redirect($this->redirectTo);
				}
			}
		}
	}
	//promise buy view
	public function promiseBuy(){

		$category = Category::all();
		/*
		$promise = DB::table('promise')
			->join('category','promise.category_id', '=', 'category.id')
			->join('file','promise.file_id', '=', 'file.id')
			->join('request', 'promise.id', '=', 'request.promise_id')
			->join('users', 'users.id', '=', 'request.users_id')
			->select('promise.id','promise.title','promise.description','promise.price','promise.type','promise.auction_end','promise.active','category.name as category_name','file.path as file_path','file.url','file.name as file_name','request.amount', 'users.f_name')
    		->get();
		*/

		$promise = \DataSet::source(
			DB::table('promise')
			->join('category','promise.category_id', '=', 'category.id')
			->join('file','promise.file_id', '=', 'file.id')
			->join('request', 'promise.id', '=', 'request.promise_id')
			->join('users', 'users.id', '=', 'request.users_id')
			->select('promise.id','promise.title','promise.description','promise.price','promise.type','promise.auction_end','promise.active','category.name as category_name','file.path as file_path','file.url','file.name as file_name','request.amount', 'users.f_name')
			->where('promise.active','=',1)
			->where('request.amount','<>',0) //not equal 0
		);
		$promise->orderBy('id','desc');
		$promise->paginate(7);
		//$promise->build();
		$promise->build();
		return view('promise.buy',['category' => $category],compact('promise'));
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function promiseCat($id){ //display promise in select category
		$category = Category::all();
		$promise = \DataSet::source(
			DB::table('promise')
				->join('category','promise.category_id', '=', 'category.id')
				->join('file','promise.file_id', '=', 'file.id')
				->join('request', 'promise.id', '=', 'request.promise_id')
				->join('users', 'users.id', '=', 'request.users_id')
				->select('promise.id','promise.title','promise.description','promise.price','promise.type','promise.auction_end','promise.active','category.name as category_name','file.path as file_path','file.url','file.name as file_name','request.amount', 'users.f_name')
				->where('promise.active','=',1)
				->where ('category.id', '=' , $id)
		);
		//$promise->addOrderBy(['title','id']);
		$promise->paginate(5);
		//$promise->build();
		$promise->build();
		return view('promise.buy', ['category' => $category],compact('promise'));
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function promiseDetails($id){  //display promise detailes
		$promise_details =  DB::table('promise')
			->join('category','promise.category_id', '=', 'category.id')
			->join('file','promise.file_id', '=', 'file.id')
			->join('request', 'promise.id', '=', 'request.promise_id')
			->join('users', 'users.id', '=', 'request.users_id')
			->join('location','promise.location_id','=','location.id')
			->select('promise.id','promise.title','promise.description','promise.price','promise.terms','promise.type','promise.auction_end','promise.active','promise.winners','category.name as category_name','file.path as file_path','file.url','file.name as file_name','request.amount', 'users.f_name','location.name as location_name')
			->where ('promise.id', '=' , $id)
			->get();

		return view('promise.details', ['promise_details' => $promise_details]);
	}

	/**
	 * @param Request $request
	 * @return mixed
	 * @throws \Exception
	 */
	public function buy(Request $request){   //Promise buy
		Validator::make($request->all(), [
			'promise_id' => 'numeric',
			'promise_amount' => 'numeric',
			'promise_price' => 'numeric'
		]);
		$promise_id = $request->input('promise_id');
		$amount = $request->input('promise_amount');
		$price = $request->input('promise_price');
		$promise = DB::table('promise')
			->join('request', 'promise.id', '=', 'request.promise_id')
			->select('promise.id','promise.price','promise.type','promise.active','promise.sold','request.amount')
			->where('promise.id','=',$request->input('promise_id'))
			->where('promise.active','=',1)
			->where('promise.type','=',0)
			->where('promise.sold','=',null)
			->first();
		if($promise->amount >= $amount){  //change amount of promise and create winner data


			//Paiment API INSERT HERE


			DB::beginTransaction();      //update table request and promise by Transaction
			try {
				Requeste::where('promise_id', $promise_id)
					->update(['amount' => $promise->amount - $amount]);
			} catch (ValidationException $e) {
				DB::rollback();
				return Redirect::to('promise/buy')
					->withErrors( $e->getErrors() )
					->withInput();
			} catch (\Exception $e) {
				DB::rollback();
				throw $e;
			}
			try {
				$winner = DB::table('winners')->insertGetId( //save buyer information and return last insert id
					['promise_id' => $promise_id, 'bid' => $price, 'winner_id' => \Auth::user()->id,'if_email' => 1]
				);
			} catch (ValidationException $e) {
				DB::rollback();
				return Redirect::to('promise/buy')
					->withErrors( $e->getErrors() )
					->withInput();
			} catch (\Exception $e) {
				DB::rollback();
				throw $e;
			}
			DB::commit();
			if($promise->amount - $amount == 0){ //if promise amount == 0 ->  promise  sold => change promise->sold to 1 (means that promise sold)!
				Promise::where('id', $promise_id)
					->update(['sold' => 1]);
			}
			//send mail to the user who bought Promise
			$data = array( //send variable to mail view
				'name'=> \Auth::user()->f_name,
				'email'=>\Auth::user()->email,
				'c_message'=> \Lang::get('message.user.successful_purchase').' '.$winner
			);
			Mail::send('mail.promise_buy',$data,function ($message) {
				$message->from(env('admin_email'), 'Auction');
				$message->to(\Auth::user()->email)->cc(\Auth::user()->email);
				$message->subject(\Lang::get('message.promise.buy'));
			});
			Session::flash('user-info', \Lang::get('message.user.successful_purchase').' '.$winner); //send message to user via flash data
			return redirect('promise/buy');
		} else { //if Promise amount < request amount
			Session::flash('user-info', \Lang::get('message.promise.quantity')); //send message to user via flash data
			return redirect('promise/buy');
		}
	}
	//promise auction buy
	public function buyAuction(Request $request){
		$messages = [ //validation message
			'au_promise_bid.required' => 'Bid is required',
			'au_promise_bid.numeric' => 'Bid is numeric'
		];
		$validator = Validator::make($request->all(), [
			'au_promise_id' => 'numeric',
			'au_promise_bid' => 'numeric|required'
		], $messages);
		if ($validator->fails()) { //if true display error
			return redirect('/promise/details/'.$request->au_promise_id)
				->withInput()
				->withErrors($validator); //set validation error name to display in error layout  views/common/errors.blade.php
		} else {
			$promise_id = Input::get('au_promise_id');
			$promise_bid = round((float)Input::get('au_promise_bid'), 2); //promise price
			if($this->auctionCheckTime($promise_id) == false){            //check auction end time
				Session::flash('user-info', \Lang::get('message.error.auction_end_time')); //send message to user via flash data
				return redirect('promise/buy');
				die();
			}
			$winner = DB::table('winners')
				->where('promise_id','=',$promise_id)
				->get();
			if(count($winner) == 0){ //check first auction bid or no -> true if first bid
				$promise = DB::table('promise')
					->join('request', 'promise.id', '=', 'request.promise_id')
					->select('promise.id','promise.price','promise.auction_end')
					->where ('promise.id', '=' , $promise_id)
					->first();
				$promis_min_bid = $promise->price; //auction min price
				if($promise_bid <= $promis_min_bid ){ // if auction bit < price die()
					Session::flash('user-info', \Lang::get('message.error.auction_min_bid').' '.$promise->price); //send message to user via flash data
					return redirect('promise/details/'.$promise_id);
					die();
				}
				DB::statement('SET FOREIGN_KEY_CHECKS=0;'); //foreign_key check off

				$new_winner = DB::table('winners')->insert(
					['promise_id' => $promise_id, 'bid' => $promise_bid,'winner_id' => \Auth::user()->id]
				);

				DB::statement('SET FOREIGN_KEY_CHECKS=1;'); //foreign_key check on
				if($new_winner){ //true if mysql return true
					Session::flash('user-info', \Lang::get('message.promise.true_bid')); //send message to user via flash data
					return redirect('promise/buy');
				} else {
					Session::flash('user-info', \Lang::get('message.error.error')); //send message to user via flash data
					return redirect('promise/details/'.$promise_id);
				}
			} else {             //true if auction already have bids
				if($this->auctionCheckTime($promise_id) == false){ //check auction end time
					Session::flash('user-info', \Lang::get('message.error.auction_end_time')); //send message to user via flash data
					return redirect('promise/buy');
					die();
				}
				$promise = Promise::find($promise_id);
				if($promise->winners == count($winner)) { //if auction winner count full
					$winners_data = json_decode(json_encode($winner), true); //winners array
					$update_bid = new UpBid();
					$up_bid = $update_bid->changeBid($winners_data);


					if ($promise_bid <= $up_bid['check_data']['user_old_bid']) { //if current bid < old_bid => true | $promise_bid 350 line
						Session::flash('user-info', \Lang::get('message.error.auction_min_bid') . ' ' . $up_bid['check_data']['user_old_bid']); //send message to user via flash data
						return redirect('promise/details/' . $promise_id);
						die();
					}

					$update_auction = DB::table('winners')
						//->where('winner_id', \Auth::user()->id)
						->where('promise_id', $promise_id)
						->where('bid', $up_bid['update_data']['user_old_bid'])
						->update(['bid' => $promise_bid,'winner_id' => \Auth::user()->id]);
					if ($update_auction) {
						Session::flash('user-info', \Lang::get('message.promise.true_bid')); //send message to user via flash data
						return redirect('promise/buy');
					} else {
						Session::flash('user-info', \Lang::get('message.error.error')); //send message to user via flash data
						return redirect('promise/buy');
					}
				} else {                             //if auction winner count not full
					$winners_data = json_decode(json_encode($winner), true); //winners array
					$update_bid = new UpBid();
					$next_winner_bid = $update_bid->changeBid($winners_data);

					if ($promise_bid <= $next_winner_bid['check_data']['user_old_bid']) { //if current bid < $next_winner_bid => true | $promise_bid -> 350 line
						Session::flash('user-info', \Lang::get('message.error.auction_min_bid') . ' ' . $next_winner_bid['check_data']['user_old_bid']); //send message to user via flash data
						return redirect('promise/details/' . $promise_id);
						die();
					}

					$duplicate_winners = DB::table('winners')
						->where ('promise_id', '=' , $promise_id)
						->where('winner_id', '=' , \Auth::user()->id)
						->get();
					if(count($duplicate_winners) !== 0) { //true if user has already put a bid
						DB::statement('SET FOREIGN_KEY_CHECKS=0;'); //foreign_key check off
						$update_auction = DB::table('winners')
							->where('promise_id', $promise_id)
							->where('bid', $next_winner_bid['update_data']['user_old_bid'])
							->update(['bid' => $promise_bid,'winner_id' => \Auth::user()->id]);
						DB::statement('SET FOREIGN_KEY_CHECKS=1;'); //foreign_key check on
						if ($update_auction) {
							Session::flash('user-info', \Lang::get('message.promise.true_bid')); //send message to user via flash data
							return redirect('promise/buy');
						} else {
							Session::flash('user-info', \Lang::get('message.error.error')); //send message to user via flash data
							return redirect('promise/buy');
						}
					}
					$new_winner = DB::table('winners')->insert(  //save new auction winner
						['promise_id' => $promise_id, 'bid' => $promise_bid,'winner_id' => \Auth::user()->id]
					);
					if($new_winner){ //true if mysql return true
						Session::flash('user-info', \Lang::get('message.promise.true_bid'));
						return redirect('promise/buy');
					} else {
						Session::flash('user-info', \Lang::get('message.error.error'));
						return redirect('promise/details/'.$promise_id);
					}
				}
			}
		}
	}
	protected function auctionCheckTime($promise_id){
		$promise = DB::table('promise')
			->join('request', 'promise.id', '=', 'request.promise_id')
			->select('promise.id','promise.price','promise.auction_end')
			->where ('promise.id', '=' , $promise_id)
			->first();
		$end_time = strtotime($promise->auction_end); //auction end time
		if (time() > $end_time) { //check auction time end or no
			return false; //if auction end -> return false
		} else {
			return true;
		}
	}
	/*
	public function check()
	{
		$msg = [];
		$id = \Request::input('id');
		//return ['check' => \App\model\DB\Promise::find($id)->request()->orderBy('amount', 'desc')->first()->users_id];
		$promise = \App\model\DB\Promise::find($id);
		if ($promise->request->isEmpty()) {
			$msg['check'] = false;
		} else {
			if ($promise->request()->orderBy('amount', 'desc')->first()->users_id == \Auth::user()->id) {
				$msg['check'] = true;
			} else {
				$msg['check'] = false;
			}
		}
		return $msg;
	}
	*/
	/*
	public function getPromiseByCategory(){
		$cat = \Request::input('category');
		$promise = Promise::select('file.name','file.url','promise.*');
		if($cat != 0){
			$promise = $promise->where('category_id',$cat);
		}
		$promise = $promise->join('file','promise.file_id','=','file.id')->get();
		return $promise->toArray();
	}
	*/
	
	
	public function pageRequest(Request $request){ // default request promise method
		$category = Category::all();
		$location = Location::all();
		if(empty($request->all())){ //if no request
			return view('promise.request', ['category' => $category,'location' => $location]);
			} else {
				//echo '<pre>';
				//print_r($request->all());
				//echo '</pre>';

			$promise =	DB::table('promise')
						->join('category','promise.category_id', '=', 'category.id')
						->join('file','promise.file_id', '=', 'file.id')
						->join('request', 'promise.id', '=', 'request.promise_id')
						//->join('users', 'users.id', '=', 'request.users_id')
						->select('promise.id','promise.title','promise.description','promise.price','promise.type','promise.auction_end','promise.active','category.name as category_name','file.path as file_path','file.url','file.name as file_name','request.amount')
						->where('promise.active','=',1)
						->where('request.amount','<>',0) //not equal 0
						->where('promise.category_id','=',$request->input('request_cat'))
						->where('promise.description','like','%'.$request->input('request_desc').'%')
						->get();

			if($promise == true){ //if query return true display matches
				return view('promise.request', ['category' => $category,'location' => $location,'promise' => $promise]);
				die();
			} else { //if query return false -> dont display result
				//echo 'Не нашло';
				$user_promise_email = DB::table('promise')
									->join('category','promise.category_id', '=', 'category.id')
									->join('file','promise.file_id', '=', 'file.id')
									->join('request', 'promise.id', '=', 'request.promise_id')
									->join('users', 'users.id', '=', 'request.users_id')
									->select('promise.id','promise.title','promise.description','promise.price','promise.type','promise.auction_end','promise.active','category.name as category_name','file.path as file_path','file.url','file.name as file_name','users.email','users.f_name')
									->where('promise.active','=',1)
									->where('request.amount','<>',0) //not equal 0
									->where('promise.category_id','=',$request->input('request_cat'))
									//->where('promise.description','like','%'.$request->input('request_desc').'%')
									->get();
				//$this->requestEmail();
				$user_promise_email = json_decode(json_encode($user_promise_email), true); //object convert to array
				$this->requestEmail($user_promise_email,$request->input('request_desc'));  //send mail to all users that have request in search category


				DB::statement('SET FOREIGN_KEY_CHECKS=0;'); //foreign_key check off
				$request_promise = Search::create(['users_id' => \Auth::user()->id,'price' => $request->input('request_price'),'descript' => $request->input('request_desc'),'expires' => $request->input('request_end')]);
				//НАДА ВЕРНУТЬ ID сохраненной записи что-бы значит что с ней делать дальше // по id потом будем находить этот запрос
				DB::statement('SET FOREIGN_KEY_CHECKS=1;'); //foreign_key check on


				Session::flash('user-info', \Lang::get('message.promise.request_negative'));
				return redirect('promise/request');
				die();
			}
		}
	}

	public function requestEmail(array $data, $desc){ //letters are sent to all users who have promise in the category in which search promise
		if(is_array($data)){
			foreach ($data as $row) {
				Mail::send('mail.request', ['desc' => $desc], function ($m) use ($row) {
					$m->from('hello@app.com', 'Your Application');
					$m->to($row['email'],$row['f_name'] )->subject('Create new Promise!!!'); //send to email link to activate account
				});
			}
		}
	}

	public function addRequest(Request $request){

	}

	public function pageBuy(){

		return view('promise.buy', [
			'category' => Category::all()
		]);
	}

	public function pageProfile($id){
		$promise = Promise::find($id);
		$req = $promise->request()->orderBy('amount', 'desc')->first();
		return view('promise.profile', ['promise' => $promise, 'request' => $req]);
	}

	public function pageBuypromise(){
		$promise = Promise::where('active',1)->get();
		$cat = Category::all();
		return view('promise.buypromise', ['promise' => $promise,'category' => $cat]);
	}

}