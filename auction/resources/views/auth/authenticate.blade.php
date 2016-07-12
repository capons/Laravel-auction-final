@extends('main')

@section('title', 'login')

@section('sidebar')
@stop

@section('content')
<div>
	<form method="POST" action="{{ url('/auth/login')}}">
		{!! csrf_field() !!}

		<div>
			Email
			<input type="text" name="r_email" value="">
		</div>

		<div>
			Password
			<input type="password" name="r_password" id="password">
		</div>

		<div>
			<input type="checkbox" name="remember"> Remember Me
		</div>

		<div>
			<button type="submit">Login</button>
		</div>
	</form>
</div>


<div class="row">
	<div style="float: none;margin: 0 auto" class="col-xs-6">
		<!-- Display Validation Errors -->
		@include('common.errors')

				<!--Display User information -->
		@if(Session::has('user-info'))
			<div class="alert-box success">
				<h2 style="text-align: center">{{ Session::get('user-info') }}</h2>

			</div>
		@endif
	</div>
</div>

@stop