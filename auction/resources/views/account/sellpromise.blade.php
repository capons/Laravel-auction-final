@extends('main')

@section('title', 'Promise')

@section('sidebar')
@stop

@section('content')
	<script type="text/javascript" src="<?php echo base_path(); ?>/public/js/promise/buypromise.js"></script>

	<p>Promise sell</p>



	@if(isset($promise_sell))
		@if(count($promise_sell) > 0)
			<?php
			$i = 1;
			?>
			@foreach($promise_sell as $row)
				<div style="border:2px solid #1b6d85" class="col-xs-12">

					<p>Promise №<?php echo $i; ?></p>
					<p>Promise title <span>{{$row->title}}</span></p>
					<p>Seller name <span>{{$row->seller}}</span></p>
					<p>Promise description <span>{{$row->desc}}</span></p>
					<p>{{$row->bid}}</p>

				</div>
				<?php
				$i++;
				?>
			@endforeach
		@endif
	@endif
@stop