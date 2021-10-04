<?php
	$con = mysqli_connect('localhost','root','','webdb');
	if (!$con)
	{
		die('Error in connection: ' . mysqli_error($con));
	}
	
	$isp = 0;
	
	$isp = $_POST['isp'];
	
	
	$result = mysqli_query($con, "SELECT SUM(har.resp_cache_control_value) as ttl, har.content_type as type FROM har INNER JOIN users ON har.userid = users.user_id WHERE users.user_ISP='".$isp."' AND (har.cache_control LIKE '%max-age%' OR har.resp_cache_control LIKE '%max-age%') AND content_type !='' AND har.resp_cache_control_value > 0 GROUP BY har.content_type;");
	$ttl = [];
	$type = [];
	
	while($row = mysqli_fetch_array($result))
	{
		$ttl[] = $row['ttl'];
		$type[] = $row['type'];
	}
	
	echo json_encode(array($ttl,$type));
	mysqli_close($con);
?>