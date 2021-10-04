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
	$sql = "SELECT COUNT(har_id) FROM har INNER JOIN users ON har.userid=users.user_id WHERE user_id ='".$_SESSION['user_id']."'";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result)>0){
		while ($row = mysqli_fetch_assoc($result)){
			echo "<p>";
			echo $row['COUNT(har_id)'];
			echo "</p>";
		}
	}
	else
	{
		echo "Σφάλμα ανάκτησης από τη Βάση Δεδομένων.";
	}
?>
