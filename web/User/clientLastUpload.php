<?php

	require '../connect.php';
	
	session_start();
	if(!isset($_SESSION['username']))
	{
	   header("Location:../login.php");
	}
	if($_SESSION['user_role'] == 1)
	{
		header("Location:../login.php");
	}
	$sql = "SELECT dateAndTime FROM har INNER JOIN users ON har.userid=users.user_id WHERE user_id ='".$_SESSION['user_id']."' ORDER BY har.dateAndTime DESC LIMIT 1";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result)>0){
		while ($row = mysqli_fetch_assoc($result)){
			echo "<p>";
			echo $row['dateAndTime'];
			echo "</p>";
		}
	}
	else
	{
		echo "Μη έγκυρη ημερομηνία: Δεν έχετε ανεβάσει κάποιο αρχείο στο σύστημα.";
	}
?>