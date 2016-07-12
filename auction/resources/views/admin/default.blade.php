@extends('admin')

@section('title', 'Заголовок страницы')

@section('sidebar')
@stop

@section('content')

        <p>Default admin page</p>


    <!-- Display Validation Errors -->
    @include('common.errors')
            <!--  ./Validation error-->
    <!--User information -->
    @if(Session::has('user-info'))
        <div class="alert-box success">
            <h2>{{ Session::get('user-info') }}</h2>
        </div>
        @endif
                <!-- ./User information-->

    @stop