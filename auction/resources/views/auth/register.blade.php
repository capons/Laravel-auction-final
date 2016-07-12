@extends('main')

@section('title', 'Register')

@section('sidebar')

@stop

@section('content')


	<div class="row">
		<div style="float:none;margin: 0 auto" class="col-xs-5">


		<form class="form-horizontal" action="{{action('Auth\AuthController@postRegister')}}" method="post">
			<div class="form-group">
				<label style="text-align: left" class="col-sm-4 control-label">First name</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="f_name" value="test_name">
				</div>
			</div>
			<div class="form-group">
				<label style="text-align: left" class="col-sm-4 control-label">Last name</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="l_name" value="test_Last_name">
				</div>
			</div>
			@if (count($location_input) > 0)  <!-- $location_input -> array with country name -->
				<div class="form-group">
					<label style="text-align: left" class="col-sm-4 control-label">Locality</label>
					<div class="col-sm-8">
						<select id="location" name="location_id" class="form-control">
							<option value=""></option>
						@foreach ($location_input as $location) <!-- loop array to display data-->
							<option value="{{$location->id}}">{{$location->name}}</option> <!--select country name -->
						@endforeach
						</select>
					</div>
				</div>
			@endif
			<div class="form-group">
				<label style="text-align: left" class="col-sm-4 control-label">Email address</label>
				<div class="col-sm-8">
					<input type="email" class="form-control" name="email" value="{{ old('email') }}">
				</div>
			</div>
			<div class="form-group">
				<label style="text-align: left" class="col-sm-4 control-label">Password</label>
				<div class="col-sm-8">
					<input type="password" name="password" class="form-control">
				</div>
			</div>
			<div style="margin-top: 30px" class="row">
				<div class="col-xs-12">
					<p>Please select any of the below categories that fit your skillset</p>
				</div>
			</div>
			<!--category group -->
			@if (count($category_input) > 0)  <!-- $location_input -> array with country name -->
				<div style="margin-top: 20px" class="row">
					<div class="col-xs-12">
						@foreach ($category_input as $category) <!-- loop array to display data-->
						<div class="col-xs-4">
							<input type="checkbox" name="category_id" value="{{$category->id}}">
							{{$category->name}}
						</div>
						@endforeach
					</div>
				</div>
			@endif
			<!--./category group -->
			<!-- Terms and condicions checkbox -->
			<div style="margin-top: 20px" class="row">
				<div class="col-xs-12">
					<div class="col-xs-12">
						<input type="checkbox" name="terms" value="{{$category->id}}">
						<span>I have and agreed to the </span><a style="text-decoration-line: underline;" href="#">Terms and Conditions</a>
					</div>
				</div>
			</div>
			<!-- ./Terms and condicions checkbox -->
			<div class="form-group">
				<div style="text-align: right" class="col-xs-12">
					<input class="btn btn-default" type="submit" value="SUBMIT">
				</div>
			</div>
			{!! csrf_field() !!}
		</form>
		</div>
	</div>
	<div class="row">
		<div style="float: none;margin: 0 auto" class="col-xs-6">
			<!-- Display Validation Errors -->
			@include('common.errors')
		</div>
	</div>
	<!--User information -->
	@if(Session::has('user-info'))
		<div class="alert-box success">
			<h2>{{ Session::get('user-info') }}</h2>
		</div>
	@endif


@stop