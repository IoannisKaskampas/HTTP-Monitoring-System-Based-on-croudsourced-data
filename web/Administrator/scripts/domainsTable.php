<?php
	$con = mysqli_connect('localhost','root','','webdb');
	if (!$con)
	{
		die('Error in connection: ' . mysqli_error($con));
	}
	
	$users = mysqli_query($con,"SELECT distinct url FROM har WHERE url != ''");
	
	echo '<table style="width: 50%; margin-left: auto; margin-right: auto;">
			<thead>
				<th>Ξεχωριστό Domain</th>
			</thead>';
	
	$domain_sum = 0;
	while($row = mysqli_fetch_array($users))
	{
		echo '<tr>';
		echo '<td>' . $row['url'] . '</td>';
		echo '</tr>';
		$domain_sum = $domain_sum + 1; //πλήθος εγγραφών που επιστρέφεται
	}
	
	echo '</table>';
	echo '<p>Πλήθος ξεχωριστών domain στη βάση: ' . $domain_sum . '</p>';
	
	mysqli_close($con);
?>