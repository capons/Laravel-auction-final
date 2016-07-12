@extends('main')

@section('title', 'Account')

@section('sidebar')
@stop

@section('content')
    <script type="text/javascript" src="<?php echo base_path(); ?>/public/js/promise/buypromise.js"></script>

    <p style="text-align: center">ГЛАВНАЯ СТРАНИЦА ПОЛЬЗОВАТЕЛЯ</p>

    <div style="height: 300px" class="container-fluid">
        <div class="row">
            <div style="text-align: center" class="col-xs-4">
                <a href="{{ url('/account/broughtpromise')}}">BROUGHT PROMISES</a>
            </div>
            <div style="text-align: center" class="col-xs-4">
                <a href="{{ url('/account/sellpromise')}}">SOLD PROMISES</a>
            </div>
            <div style="text-align: center" class="col-xs-4">
                <a href="{{ url('/account/requeste')}}">REQUESTED PROMISES</a>
            </div>
        </div>
    </div>



@stop