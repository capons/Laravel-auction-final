@extends('main')

@section('title', 'Buy a promise')

@section('sidebar')
@stop

@section('content')
	<!-- user info -->
	<div class="col-xs-12">
		@if(Session::has('user-info'))
			<div class="alert-box success">
				<h2>{{ Session::get('user-info') }}</h2>
			</div>
		@endif
	</div>
	<div style="height: 500px" class="row">
		<div class="col-xs-3">
			<ul style="width: 100%" class="footer-menu">
			@foreach($category as $v)
				<li><a href="<?php echo Config::get('app.url'); ?>/promise/buy/{{ $v->id }}">{{$v->name}}</a></li>
			@endforeach
			</ul>
		</div>
		<?php if(isset($promise)) { ?>
		@if (count($promise) > 0)
			@foreach($promise->data as $row)
				<?php
				if($row->auction_end == null) { ?> <!--if $row->auction_end == null => auction for sell (display) -->
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
				<?php
				} else {     //display promise for sell  and check if auction end time "end" -> do not display them!!! //if auction_end has data => promise for auction => if auction end => display false
					$end_time = strtotime($row->auction_end); //auction end time
					if (time() < $end_time) { 				  //check auction time end or no
					?>
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
					<?php
					}
				}
					?>
			@endforeach
		@endif
		<?php } ?>
	</div>
	<div class="row">
		<div style="text-align: right" class="col-lg-12">
			{!! $promise->links() !!}
		</div>
	</div>


@stop