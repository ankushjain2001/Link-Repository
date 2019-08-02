<html>
<head>
	
	

</head>

<?php
header('Refresh: 10;url=home_show_shared'); //refreshes page after evry 10 seconds
?>

@foreach($links as $link)

{{$link->email}} shared link {{$link->link}} <a href="allow?link={{$link->link}}">Allow</a> <a href="deny?link={{$link->link}}">Deny</a> <br>

@endforeach

</html>