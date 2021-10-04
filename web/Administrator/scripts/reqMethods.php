<?php
	$con = mysqli_connect('localhost','root','','webdb');
	if (!$con)
	{
		die('Error in connection: ' . mysqli_error($con));
	}
	
	$req = mysqli_query($con,"SELECT COUNT(req_method) as sum, req_method as methods FROM har GROUP BY req_method");
	$totals = [];
	$methods = [];
	
	while($row = mysqli_fetch_array($req))
	{
		$totals[] = $row['sum'];
		$methods[] = $row['methods'];
	}
	
	echo json_encode(array($methods,$totals));
	mysqli_close($con);
?>