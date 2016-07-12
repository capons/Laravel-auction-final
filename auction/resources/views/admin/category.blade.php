@extends('admin')

@section('title', 'Заголовок страницы')

@section('sidebar')
@stop

@section('content')
        <!-- Display Validation Errors -->
@include('common.errors')
        <!--  ./Validation error-->

<!--User information -->
@if(Session::has('user-info'))
    <div class="alert-box success">
        <h2>{{ Session::get('user-info') }}</h2>
    </div>
    @endif
            <!-- ./user information -->
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

    @if (count($category_view) > 0)  <!-- if $category_view have data -->
    <div class="row">
        <div class="col-xs-12">
            <div style="float: none;margin: 0 auto" class="col-xs-6">
                @foreach ($category_view as $category) <!-- loop array to display data-->
                <form method="post" action="<?php echo Config::get('app.url'); ?>/admin/category">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="m-c-id" value="{{$category->id}}">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="name" name="m-c-name" class="form-control" value="{{$category->name}}">
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