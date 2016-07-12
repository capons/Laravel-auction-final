<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
	<link href="{!! asset('public/css/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet" type="text/css">
	<link href="{!! asset('public/AdminLTE/dist/css/AdminLTE.min.css') !!}" rel="stylesheet" type="text/css">
	<link href="{!! asset('public/AdminLTE/dist/css/skins/skin-blue.min.css') !!}" rel="stylesheet" type="text/css">
	<link href="{!! asset('public/AdminLTE/dist/css/skins/_all-skins.min.css') !!}" rel="stylesheet" type="text/css">


	<link href="{!! asset('public/css/admin.css') !!}" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="{!! asset('public/js/WCL/main.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('public/js/WCL/interface.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('public/js/system.js') !!}"></script>

	<script type="text/javascript" src="{!! asset('public/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js') !!}"></script>
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>



	<script type="text/javascript" src="{!! asset('public/js/main.js') !!}"></script>








	<script type="text/javascript">
		$.ajaxSetup({
			headers: {
			'X-CSRFTOKEN': $('meta[name="csrf-token"]').attr('content')
		}
		});
	</script>

</head>
<body  class="skin-blue sidebar-mini">
<header class="main-header">
	<a href="/" class="logo">
		<!-- LOGO -->
		AdminLTE
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top" role="navigation">
		<!-- Navbar Right Menu -->
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<!-- Messages: style can be found in dropdown.less-->
				<li class="dropdown messages-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-envelope-o"></i>
						<span class="label label-success">4</span>
					</a>
					<ul class="dropdown-menu p-but">
						<li class="header">You have 4 messages</li>
						<li>
							<!-- inner menu: contains the actual data -->
							<ul class="menu">
								<li><!-- start message -->
									<a href="#">
										<div class="pull-left">
											<img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
										</div>
										<h4>
											Sender Name
											<small><i class="fa fa-clock-o"></i> 5 mins</small>
										</h4>
										<p>Message Excerpt</p>
									</a>
								</li><!-- end message -->
								...
							</ul>
						</li>
						<li class="footer"><a href="#">See All Messages</a></li>
					</ul>
				</li>
				<!-- Notifications: style can be found in dropdown.less -->
				<li class="dropdown notifications-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-bell-o"></i>
						<span class="label label-warning">10</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">You have 10 notifications</li>
						<li>
							<!-- inner menu: contains the actual data -->
							<ul class="menu">
								<li>
									<a href="#">
										<i class="ion ion-ios-people info"></i> Notification title
									</a>
								</li>
								...
							</ul>
						</li>
						<li class="footer"><a href="#">View all</a></li>
					</ul>
				</li>
				<!-- Tasks: style can be found in dropdown.less -->
				<li class="dropdown tasks-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-flag-o"></i>
						<span class="label label-danger">9</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">You have 9 tasks</li>
						<li>
							<!-- inner menu: contains the actual data -->
							<ul class="menu">
								<li><!-- Task item -->
									<a href="#">
										<h3>
											Design some buttons
											<small class="pull-right">20%</small>
										</h3>
										<div class="progress xs">
											<div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
												<span class="sr-only">20% Complete</span>
											</div>
										</div>
									</a>
								</li><!-- end task item -->
								...
							</ul>
						</li>
						<li class="footer">
							<a href="#">View all tasks</a>
						</li>
					</ul>
				</li>
				<!-- User Account: style can be found in dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="#" id="admin-p-display" class="dropdown-toggle" data-toggle="dropdown">
						<img src="<?php echo asset('AdminLTE/dist/img/user2-160x160.jpg'); ?>" class="user-image" alt="User Image">
						<span class="hidden-xs">Alexander Pierce</span>
					</a>
					<ul id="p-display" class="dropdown-menu">
						<!-- User image -->
						<li class="user-header">
							<img src="<?php echo asset('AdminLTE/dist/img/user2-160x160.jpg'); ?>" class="img-circle" alt="User Image">
							<p>
								Alexander Pierce - Web Developer
								<small>Member since Nov. 2012</small>
							</p>
						</li>
						<!-- Menu Body -->
						<li class="user-body">
							<div class="col-xs-4 text-center">
								<a href="#">Followers</a>
							</div>
							<div class="col-xs-4 text-center">
								<a href="#">Sales</a>
							</div>
							<div class="col-xs-4 text-center">
								<a href="#">Friends</a>
							</div>
						</li>
						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-left">
								<a href="#" class="btn btn-default btn-flat">Profile</a>
							</div>
							<div class="pull-right">
								<a href="{{ action('Auth\AuthController@getLogout') }}" class="btn btn-default btn-flat">Sign out</a> <!-- Link to log out Controller -->
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>
<aside class="main-sidebar">

	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">

		<!-- Sidebar user panel (optional) -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="<?php echo asset('AdminLTE/dist/img/user2-160x160.jpg'); ?>" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p>Alexander Pierce</p>
				<!-- Status -->
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>

		<!-- search form (Optional) -->
		<form action="#" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
			</div>
		</form>
		<!-- /.search form -->

		<!-- Sidebar Menu -->
		<ul class="sidebar-menu">
			<li class="header">HEADER</li>
			<!-- Optionally, you can add icons to the links -->
			<li {{ (Request::is('admin/users') ? 'class=active' : '') }}><a href="{!! url('/admin/users') !!}"><i class="fa fa-link"></i><span>Users</span></a></li>
			<li {{ (Request::is('admin/location') ? 'class=active' : '') }}><a href="{!! url('/admin/location') !!}"><i class="fa fa-link"></i> <span>Location</span></a></li>
			<li {{ (Request::is('admin/category') ? 'class=active' : '') }}><a href="{!! url('/admin/category') !!}"><i class="fa fa-link"></i> <span>Category</span></a></li>


			<li {{ (Request::is('admin/promise') ? 'class=active' : '') }}><a href="{!! url('/admin/promise') !!}"><i class="fa fa-link"></i> <span>Promise</span></a></li>
			<li class="treeview">
				<a href="#"><i class="fa fa-link"></i> <span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li><a href="#">Link in level 2</a></li>
					<li><a href="#">Link in level 2</a></li>
				</ul>
			</li>
		</ul>
		<!-- /.sidebar-menu -->
	</section>
	<!-- /.sidebar -->
</aside>
<div class="content-wrapper" style="min-height: 698px;">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Page Header
			<small>Optional description</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
			<li class="active">Here</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

		<!-- Your Page Content Here -->
		@yield('content')
	</section>
	<!-- /.content -->
</div>


<!--Admin panel js and css -->


<!--
<script src="{!! asset('/AdminLTE/bootstrap/js/bootstrap.min.js') !!}"></script>
<script src="{!! asset('/AdminLTE/dist/js/app.js') !!}" type="text/javascript"></script>
-->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
	//$.widget.bridge('uibutton', $.ui.button);
</script>



<!--admin panel js -->
<script type="text/javascript" src="{!! asset('public/AdminLTE/bootstrap/js/bootstrap.min.js') !!}"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script type="text/javascript" src="{!! asset('public/AdminLTE/plugins/morris/morris.min.js') !!}"></script>
<script src="{!! asset('public/AdminLTE/plugins/sparkline/jquery.sparkline.min.js') !!}"></script>
<!-- jvectormap -->
<script src="{!! asset('public/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') !!}"></script>
<script src="{!! asset('public/AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') !!}"></script>
<!-- jQuery Knob Chart -->
<script src="{!! asset('public/AdminLTE/plugins/knob/jquery.knob.js') !!}"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="{!! asset('public/AdminLTE/plugins/daterangepicker/daterangepicker.js') !!}"></script>
<!-- datepicker -->
<script src="{!! asset('public/AdminLTE/plugins/datepicker/bootstrap-datepicker.js') !!}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{!! asset('public/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') !!}"></script>
<!-- Slimscroll -->
<script src="{!! asset('public/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js') !!}"></script>
<!-- FastClick -->
<script src="{!! asset('public/AdminLTE/plugins/fastclick/fastclick.min.js') !!}"></script>
</body>
</html>
