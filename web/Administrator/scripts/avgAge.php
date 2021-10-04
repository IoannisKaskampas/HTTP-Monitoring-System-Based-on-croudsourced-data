<?php
	$con = mysqli_connect('localhost','root','','webdb');
	if (!$con)
	{
		die('Error in connection: ' . mysqli_error($con));
	}
	
	$age = mysqli_query($con,"SELECT AVG(age) as age, content_type as type FROM har WHERE content_type != '' GROUP BY content_type;");
	$avg = [];
	$type = [];
	
	while($row = mysqli_fetch_array($age))
	{
		$avg[] = $row['age'];
		$type[] = $row['type'];
	}
	
	echo json_encode(array($avg,$type));
	mysqli_close($con);
?>