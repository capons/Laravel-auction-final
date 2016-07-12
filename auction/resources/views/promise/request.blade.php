@extends('main')

@section('title', 'Request a promise')

@section('sidebar')
@stop

@section('content')
		<!--CALENDAR -->
	<link rel="stylesheet" type="text/css" href="{!!asset('/public/js/calendar/jquery.datepick.css')!!}">
	<script type="text/javascript" src="{!!asset('/public/js/calendar/jquery.plugin.js')!!}"></script>
	<script type="text/javascript" src="{!!asset('/public/js/calendar/jquery.datepick.js')!!}"></script>
	<!--/CALENDAR -->
	<script type="text/javascript" src="{!! asset('/public/js/request/request.js') !!}"></script>



	<div class="container">
		<div style="float: none;margin: 0 auto" class="col-xs-8">

			<div style="padding: 0px" class="col-xs-12">
				<h2>REQUEST A PROMISE</h2>
			</div>

			<form id="promise_request_form"  class="form-horizontal" action="{{action('PromiseController@pageRequest')}}" method="get">
				@if(isset($category))
					@if (count($category) > 0)
						<div class="form-group">
							<label style="text-align: left" class="col-sm-4 control-label">SELECT A CATEGORY</label>
							<div class="col-sm-8">
								<select id="location" name="request_cat"  class="form-control" >
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
							<label style="text-align: left" class="col-sm-4 control-label">SELECT YOUR LOCALITY</label>
							<div class="col-sm-8">
								<select id="location" name="request_location" class="form-control" >
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
					<label style="text-align: left" class="col-sm-12 control-label">DETAILS/DESCRIPTION OF WHAT THE PROMISE INCLUDES</label>
					<div class="col-sm-12">
						<textarea class="form-control" name="request_desc" rows="3"  placeholder="Description of promise here"></textarea>
					</div>
				</div>

					<div class="form-group">
						<label style="text-align: left" class="col-sm-3 control-label">SET YOUR PRICE</label>
						<div class="col-sm-4">
							<input class="form-control" type="text" value="50" name="request_price" placeholder="$" required>
						</div>
					</div>

					<div class="form-group">
						<label style="text-align: left" class="col-sm-12 control-label">Date Added</label>
						<div style="padding: 0px 15px;" class="input-group">
							<input name="request_end" id="filter-date-add" type="date"  class="form-control" placeholder="Date added">
							<span style="margin: 0px;padding: 0px" class="input-group-addon"><button id="filter-d-add" data-datepick="rangeSelect: false, minDate: 'new Date()'"  type="button" style="border: none;padding: 8px;"><span class="glyphicon glyphicon-calendar"></span></button></span>
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

		<?php
		if(isset($promise)){
		?>
			@if(count($promise))
				@foreach($promise as $row)
					<div class="col-lg-3">
						<div class="col-xs-12">
							<a href="<?php echo Config::get('app.url'); ?>/promise/details/{{ $row->id }}" class="thumbnail">
								<img src="{!! asset('public') !!}{{$row->url}}<?php echo '/'; ?>{{$row->file_name}}" alt="...">
							</a>
							<h3>{{$row->title}}</h3>
							<h5>{{$row->description}}</h5>
							<strong><?php echo '$'; ?>{{$row->price}}</strong>
						</div>
					</div>
				@endforeach
			@endif
		<?php
			}
			?>


		<div class="row">
			<div style="float: none;margin: 0 auto" class="col-xs-6">
				<!-- Display Validation Errors -->
				@include('common.errors')
			</div>
		</div>
		<!--User information -->
		@if(Session::has('user-info'))
			<div style="text-align: center" class="alert-box success">
				<h2>{{ Session::get('user-info') }}</h2>
			</div>
		@endif
	</div>
@stop