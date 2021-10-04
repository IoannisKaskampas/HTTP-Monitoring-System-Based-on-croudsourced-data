<?php
	$con = mysqli_connect('localhost','root','','webdb');
	if (!$con)
	{
		die('Error in connection: ' . mysqli_error($con));
	}
	
	$type = 0;
	$day = 0;
	$method = 0;
	$isp = 0;
	
	$type = $_POST['type'];
	$day = $_POST['day'];
	$method = $_POST['method'];
	$isp = $_POST['isp'];
	
	
	$result = mysqli_query($con, "SELECT AVG(timingsWait) as timings, hour(startedDateTime) as hour from har inner join users on har.userid = users.user_id where har.content_type = '".$type."' AND dayname(har.startedDateTime) = '".$day."' AND har.req_method = '".$method."' AND users.user_ISP = '".$isp."' group by(hour(startedDateTime));");
	$timings = [];
	$hour = [];
	
	while($row = mysqli_fetch_array($result))
	{
		$timings[] = $row['timings'];
		$hour[] = $row['hour'];
	}
	
	echo json_encode(array($timings,$hour));
	mysqli_close($con);
?>