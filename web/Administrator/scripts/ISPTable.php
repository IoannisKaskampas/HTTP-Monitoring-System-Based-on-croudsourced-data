<?php
	$con = mysqli_connect('localhost','root','','webdb');
	if (!$con)
	{
		die('Error in connection: ' . mysqli_error($con));
	}
	
	$users = mysqli_query($con,"SELECT distinct user_ISP FROM users WHERE user_ISP != ''");
	
	echo '<table style="width: 50%; margin-left: auto; margin-right: auto;">
			<thead>
				<th>Πάροχος Συνδεσιμότητας</th>
			</thead>';
	
	$isp_sum = 0;
	while($row = mysqli_fetch_array($users))
	{
		echo '<tr>';
		echo '<td>' . $row['user_ISP'] . '</td>';
		echo '</tr>';
		$isp_sum = $isp_sum + 1; //πλήθος εγγραφών που επιστρέφεται
	}
	
	echo '</table>';
	echo '<p>Πλήθος ξεχωριστών παρόχων συνδεσιμότητας στη βάση: ' . $isp_sum . '</p>';
	
	mysqli_close($con);
?>