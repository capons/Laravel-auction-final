@extends('main')

@section('title', 'Sell promise')

@section('sidebar')
@stop

@section('content')
	<div class="container">
		<div style="float: none;margin: 0 auto" class="col-xs-8">

			<div style="padding: 0px" class="col-xs-12">
				<h2>SELL A PROMISE</h2>
			</div>

			<form id="promise_form" enctype="multipart/form-data" class="form-horizontal" action="{{action('PromiseController@add')}}" method="post">
				<input type="hidden" name="sell_promise_type" value="0"> <!--input to understand -> promise for sale or auction -->
				<div style="margin-bottom: 10px" class="row"> <!--Select sell type -->
					<div class="col-xs-12">
						<button  id="btn_buy" type="button" class="btn buy_promis_active">BUY NOW PROMISE</button>
						<button style="float: right" id="btn_auction" type="button" class="btn select">AUCTION PROMISE</button>
					</div>
				</div>
				@if(isset($category))
					@if (count($category) > 0)
						<div class="form-group">
							<label style="text-align: left" class="col-sm-4 control-label">SELECT A CATEGORY</label>
							<div class="col-sm-8">
								<select id="location" name="prom_category"  class="form-control" >
									<option value="">Category</option>
									@foreach ($category as $row) <!-- loop array to display data-->
									<option value="{{$row->id}}">{{$row->name}}</option> <!--select country name -->
									@endforeach
								</select>
							</div>
						</div>
					@endif
				@endif



				@if(isset($location))
					@if (count($location) > 0)
						<div class="form-group">
							<label style="text-align: left" class="col-sm-4 control-label">SELECT A LOCALITY</label>
							<div class="col-sm-8">
								<select id="location" name="prom_location" class="form-control" >
									<option value="2">Locality</option>
									@foreach ($location as $row) <!-- loop array to display data-->
									<option value="{{$row->id}}">{{$row->name}}</option> <!--select country name -->
									@endforeach
								</select>
							</div>
						</div>
					@endif
				@endif
				<div class="form-group">
					<label style="text-align: left" class="col-sm-4 control-label">TITLE OF PROMISE</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" value="testtest" name="prom_title" placeholder="Title of promise here" required>
					</div>
				</div>
				<!-- if sell promise checked -->
				<div id="promise_f_buy"  class="form-group">
					<label style="text-align: left" class="col-sm-10 control-label">NUMBER OF TIMES THIS PROMISE IS AVAILABLE FOR SALE</label>
					<div class="col-sm-2">
						<input class="form-control" type="number" name="prom_available_time" value="1" placeholder="XX" required>
					</div>
				</div>

				<!-- if auction promise checked -->
				<div  class="form-group promise_auction">
					<label style="text-align: left" class="col-sm-10 control-label">NUMBER OF WINNERS FOR THIS AUCTION</label>
					<div class="col-sm-2">
						<input class="form-control" type="number" value="1" name="prom_auction_number" placeholder="XX" required>
					</div>
				</div>

				<div  class="form-group promise_auction">
					<label style="text-align: left" class="col-sm-10 control-label">DATE AUCTION CLOSES</label>
					<div class="col-sm-2">
						<input class="form-control" type="date" value="1" name="prom_auction_end" placeholder="XX" required>
					</div>
				</div>


				<!-- ./auction promise-->


				<div class="form-group">
					<label style="text-align: left" class="col-sm-12 control-label">DETAILS/DESCRIPTION OF WHAT THE PROMISE INCLUDES</label>
					<div class="col-sm-12">
						<textarea class="form-control" name="prom_desc" rows="3"  placeholder="Description of promise here"></textarea>
					</div>
				</div>

				<div class="form-group">
					<label style="text-align: left" class="col-sm-12 control-label">TERMS & CONDITIONS OF THE PROMISE</label>
					<label style="text-align: left;font-size: 9px" class="col-sm-12 control-label">extra description here of what their terms and conditions should cover</label>
					<div class="col-sm-12">
						<textarea class="form-control" name="prom_terms" rows="3"   placeholder="T & C’s of promise here"></textarea>
					</div>
				</div>


				<div class="form-group">
					<div class="col-sm-12">
						<div class="row">
							<div class="col-xs-12" id="btn">
								<p><span class="up_promise_photo" id="p_up_photo">UPLOAD</span> A PHOTO OR <span class="up_promise_photo">SELECT</span> ONE OF OURS</p>
							</div>
							<input id="upfile" type="file" name="prom_upload">
						</div>

					</div>
				</div>
					<!--
				<div class="form-group">
					<label style="text-align: left" class="col-sm-11 control-label">FEATURED PROMISE?<span style="font-size: 9px"> Do you think this promise has what it takes to be featured on our home page.</span></label>

					<div class="col-sm-1">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="prom_h_p" id="checkboxSuccess" value="some value">
							</label>
						</div>
					</div>
				</div>
				-->


				<div class="form-group">
					<label style="text-align: left" class="col-sm-3 control-label">SET YOUR PRICE</label>
					<div class="col-sm-4">
						<input class="form-control" type="text" value="50" name="prom_price" placeholder="$" required>
					</div>
				</div>


				<div class="form-group">
					<div style="text-align: center" class="col-xs-12">
						<input class="btn btn-default" type="submit" value="SUBMIT">
					</div>
				</div>
				{!! csrf_field() !!}
			</form>
		</div>
	</div>


<div  style="position: absolute;width: 400px;top: 0;left:50%;margin-left: -200px;">
	<!-- Display Validation Errors -->
	@include('common.errors')
			<!--User information -->
	@if(Session::has('user-info'))
		<div class="alert-box success">
			<h2>{{ Session::get('user-info') }}</h2>
		</div>
		@endif
				<!--End user information -->
</div>




@stop