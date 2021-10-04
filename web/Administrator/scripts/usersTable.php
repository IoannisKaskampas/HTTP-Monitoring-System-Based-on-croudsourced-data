<?php
	$con = mysqli_connect('localhost','root','','webdb');
	if (!$con)
	{
		die('Error in connection: ' . mysqli_error($con));
	}
	
	$users = mysqli_query($con,"SELECT user_id, username, user_email FROM users WHERE user_role = 0");
	
	echo '<table style="width: 50%; margin-left: auto; margin-right: auto;">
			<thead>
				<th>ID</th>
				<th>Όνομα Χρήστη</th>
				<th>Email</th>
			</thead>';
	
	$sum = 0;
	while($row = mysqli_fetch_array($users))
	{
		echo '<tr>';
		echo '<td>' . $row['user_id'] . '</td>';
		echo '<td>' . $row['username'] . '</td>';
		echo '<td>' . $row['user_email'] . '</td>';
		echo '</tr>';
		$sum = $sum + 1; //πλήθος εγγραφών που επιστρέφεται
	}
	
	echo '</table>';
	echo '<p>Πλήθος εγγεγραμμένων χρηστών: ' . $sum . '</p>';
	
	mysqli_close($con);
?>