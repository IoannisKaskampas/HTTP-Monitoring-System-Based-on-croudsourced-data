<?php
	$con = mysqli_connect('localhost','root','','webdb');
	if (!$con)
	{
		die('Error in connection: ' . mysqli_error($con));
	}
	
	$sta = mysqli_query($con,"SELECT COUNT(statusRes) as statusSum, statusRes as status FROM har WHERE statusRes > 0 GROUP BY statusRes");
	$statusTotals = [];
	$status = [];
	
	while($row = mysqli_fetch_array($sta))
	{
		$statusTotals[] = $row['statusSum'];
		$status[] = $row['status'];
	}
	
	echo json_encode(array($status,$statusTotals));
	mysqli_close($con);
?>