<!DOCTYPE html>
<html>
<head>
   <title>@yield('title')</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>



<?php
if(isset($link)){
?>
@if(count($link) > 0)
    <p>{{$link}}</p>
@endif
<?php
}
?>
</body>
</html>

