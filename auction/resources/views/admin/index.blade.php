@extends('admin')

@section('title', 'Заголовок страницы')

@section('sidebar')
@stop

@section('content')
		<!-- Validation error-->
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
		<!--  ./Validation error-->
		<!--User information -->
		@if(Session::has('user-info'))
			<div class="alert-box success">
				<h2>{{ Session::get('user-info') }}</h2>
			</div>
			@endif
		<!-- ./User information-->
	<!--Users GridView -->
	<?php
	if(isset($grid)){ //display gridview with users data
	?>
	{!! $filter !!}
	{!! $grid !!}
	<?php } ?>
	<!--End users GridView -->
<?php
if(isset($_GET['modify'])){ ?>

	@if (count($user_view) > 0)  <!-- if $tasks have data -->
		<div class="row">
			<div class="col-xs-12">
				<div style="float: none;margin: 0 auto" class="col-xs-6">
					@foreach ($user_view as $user) <!-- loop array to display data-->
						<form method="post" action="<?php echo Config::get('app.url'); ?>/admin/users">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="m-id" value="{{$user->id}}">
							<div class="form-group">
								<label>Name</label>
								<input type="name" name="m-name" class="form-control" value="{{$user->f_name}}">
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="email" name="m-email" class="form-control" value="{{$user->email}}">
							</div>
							<button type="submit" class="btn btn-default">Submit</button>
						</form>
					@endforeach
				</div>
			</div>
		</div>
	@endif
<?php
}
?>

@stop