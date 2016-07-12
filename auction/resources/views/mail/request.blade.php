<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<p>You can create a new Promise with that description</p>

<?php
if(isset($desc)){
?>
@if(count($desc) > 0)
    <p>{{$desc}}</p>
@endif
<?php
}
?>
</body>
</html>

