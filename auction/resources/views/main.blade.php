<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="{!! asset('public/css/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet" type="text/css">
	<link href="{!! asset('public/css/bootstrap/css/bootstrap-theme.min.css') !!}" rel="stylesheet" type="text/css">
	<link href="{!! asset('public/css/style.css') !!}" rel="stylesheet" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>


	<!--style js -->
	<script type="text/javascript" src="{!! asset('/public/js/main.js') !!}"></script>
</head>
<body>
<!--nav menu -->
<section>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!--
				<a class="navbar-brand" href="#">Brand</a>
				-->
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li <?php if(Route::getCurrentRoute()->getPath() == '/'){ echo 'class=active';} else { echo '';} ?>><a href="{{ url('/')}}">Main page<span class="sr-only"></span></a></li>
					<li <?php if(Route::getCurrentRoute()->getPath() == 'account'){ echo 'class=active';} else { echo '';} ?>><a href="{{ url('/account')}}">User account<span class="sr-only"></span></a></li>

					</ul>
				<!--
				<form class="navbar-form navbar-left" role="search">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search">
					</div>
					<button type="submit" class="btn btn-default">Submit</button>
				</form>
				-->
				<!--
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#">Link</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#">Separated link</a></li>
						</ul>
					</li>
				</ul>
				-->
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
</section>
@section('sidebar')
	Это - главный сайдбар.
@show
	@yield('content')




<section style="width: 100%">

	<div class="col-xs-12">
		<div class="col-xs-4">
			<ul class="footer-menu">
				<li <?php if(Route::getCurrentRoute()->getPath() == 'promise/buy'){ echo 'class=active';} else { echo '';} ?>><a href="{{ url('/promise/buy')}}">Buy a Promise<span class="sr-only"></span></a></li>
				<li <?php if(Route::getCurrentRoute()->getPath() == 'promise/sell'){ echo 'class=active';} else { echo '';} ?>><a href="{{ url('/promise/sell')}}">Sell a Promise<span class="sr-only"></span></a></li>
				<li <?php if(Route::getCurrentRoute()->getPath() == 'promise/request'){ echo 'class=active';} else { echo '';} ?>><a href="{{ url('/promise/request')}}">Request a Promise<span class="sr-only"></span></a></li>

			</ul>
		</div>
		<div class="col-xs-4">
			<ul class="footer-menu">
				<li <?php if(Route::getCurrentRoute()->getPath() == 'promise/buy'){ echo 'class=';} else { echo '';} ?>><a href="{{ url('/')}}">About Us<span class="sr-only"></span></a></li>
				<li <?php if(Route::getCurrentRoute()->getPath() == 'promise/sell'){ echo 'class=';} else { echo '';} ?>><a href="{{ url('/')}}">Promise Team<span class="sr-only"></span></a></li>
				<li <?php if(Route::getCurrentRoute()->getPath() == 'promise/buy'){ echo 'class=';} else { echo '';} ?>><a href="{{ url('/')}}">Get Involved<span class="sr-only"></span></a></li>

			</ul>
		</div>
		<div class="col-xs-4">
			<ul class="footer-menu">
				<li <?php if(Route::getCurrentRoute()->getPath() == 'promise/buy'){ echo 'class=';} else { echo '';} ?>><a href="{{ url('/')}}">Suggestions?<span class="sr-only"></span></a></li>
				<li <?php if(Route::getCurrentRoute()->getPath() == 'promise/sell'){ echo 'class=';} else { echo '';} ?>><a href="{{ url('/')}}">Support<span class="sr-only"></span></a></li>
				<li <?php if(Route::getCurrentRoute()->getPath() == 'promise/buy'){ echo 'class=';} else { echo '';} ?>><a href="{{ url('/')}}">FAQ’s<span class="sr-only"></span></a></li>

			</ul>
		</div>
	</div>
</section>
</body>
</html>
