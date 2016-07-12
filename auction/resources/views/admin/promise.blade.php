@extends('admin')

@section('title', 'Заголовок страницы')

@section('sidebar')
@stop

@section('content')
		<!-- Display Validation Errors -->
	@include('common.errors')
		<!--./Error -->
	<!--Display User info -->
	<!--User information -->
	@if(Session::has('user-info'))
	<div class="alert-box success">
		<h2>{{ Session::get('user-info') }}</h2>
	</div>
	@endif
	<!-- ./User info-->
	<!--Promise GridView -->
	{!! $filter !!}
	{!! $grid !!}


	<!-- ./Promise GridView -->
@stop