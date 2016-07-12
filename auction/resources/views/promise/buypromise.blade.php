@extends('main')

@section('title', 'Promise')

@section('sidebar')
@stop

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-2 col-sm-2 col-xs-2" id="category">
				<ul>
					@foreach($category as $v)
					<li class="li_category" data-id="{{$v['id']}}">{{$v['name']}}</li>
					@endforeach
				</ul>
			</div>
			<div class="col-md-10 col-sm-10 col-xs-10" id="list_promise">
			@foreach($promise as $v)
				<div>
					<div><img height="100px" src="{{$v['file']['url'].'/'.$v['file']['name']}}"></div>
					<div><a href="/promise/profile/{{$v['id']}}">{{$v['title']}}</a></div>
					<div>{{$v['desc']}}</div>
					<div>${{$v['price']}}</div>
				</div>
			@endforeach
			</div>
		</div>
	</div>
	<script type="text/javascript" src="/js/promise/buypromise.js"></script>
@stop