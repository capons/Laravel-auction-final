@extends('main')

@section('title', 'Promise')

@section('sidebar')
@stop

@section('content')
	{{$request}}
	<div class="container profile">
		<div class="row">
			<h1>{{$promise['title']}}</h1>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="price">$@if($request['amount'] > $promise['price']) {{$request['amount']}} @else {{$promise['price']}} @endif</div>
				<div class="text"><span>LOCALITY:</span> {{$promise['location']['name']}}</div>
				@if($promise['type'] == 1)
				<div class="text"><span>NUMBER OF WINNERS:</span> {{$promise['winners']}}</div>
				<div class="text"><span>AUCTION CLOSESS:</span> {{$promise['time']}}</div>
				@endif
				<div class="text">{{$promise['desc']}}</div>
				<div class="text"><span>TERMS & CONDITIONS:</span> {{$promise['terms']}}</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<img style="width: 100%" src="{{$promise['file']['url'].'/'.$promise['file']['name']}}">
			</div>
			<div>
				<input @if($promise['type'] == 0) style="display: none;" @endif type="number" name="amount" id="amount">
				<button class="auction_btn" id="btn_buy">
					@if($promise['type'] == 1)
						BID NOW
					@else
						BUY NOW
					@endif
				</button>
			</div>
			<div>
				<button>CONTACT SELLER</button>
				<button>SIMILAR PROMISES</button>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="/js/promise/profile.js"></script>
@stop