<?php
session_start();

if(isset($_POST['update_button']))
{
	require '../connect.php';
	
	$update_username = $_POST['update_username'];
	$new_update_password = $_POST['update_new_password'];
	$update_comf_new_password = $_POST['update_comf_new_password'];
	$uppercase = preg_match('@[A-Z]@', $new_update_password);
	$lowercase = preg_match('@[a-z]@', $new_update_password);
	$number = preg_match('@[0-9]@', $new_update_password);
	$character = preg_match('@[/\W/]@',$new_update_password);
			
	if($_SESSION['password'] == $_POST['update_password']){
		if(isset($new_update_password) && isset($update_comf_new_password) && empty($update_username)){
			if(!$uppercase || !$lowercase || !$number || !$character || strlen($new_update_password) < 8){ 
				header("Location: ./client_update.php?error=wrongpassword");
				exit();
			}
			else if($new_update_password!== $update_comf_new_password){
				header("Location: ./client_update.php?error=passwordsdontmatch");
				exit();
			}
			else
			{
				if(mysqli_query($conn, "UPDATE users SET user_pwd='".$new_update_password."' WHERE user_email='".$_SESSION['email']."'"))
				{
					header("Location: ./client_update.php?update=success");
					exit();
				}
				else
				{
					header("Location: ./client_update.php?error=sqlerror");
					exit();
				}
			}
		}
		
		else if(empty($new_update_password) && empty($update_comf_new_password) && isset($update_username))
		{
			$username = mysqli_query($conn, "SELECT username FROM users WHERE username='".$update_username."'");
			if($row = mysqli_fetch_array($username))
			{
				header("Location: ./client_update.php?error=usernametaken");
				exit();
			}
			else
			{
				if(mysqli_query($conn, "UPDATE users SET username='".$update_username."' WHERE user_email='".$_SESSION['email']."'"))
				{
					header("Location: ./client_update.php?update=success");
					$_SESSION['username'] = $update_username;
					exit();
				}
				else
				{
					header("Location: ./client_update.php?error=sqlerror");
					exit();
				}
			}
		}
		
		else
		{
			//Για την αλλαγή του password
			if(!$uppercase || !$lowercase || !$number || !$character || strlen($new_update_password) < 8){ 
				header("Location: ./client_update.php?error=wrongpassword");
				exit();
			}
			else if($new_update_password!== $update_comf_new_password){
				header("Location: ./client_update.php?error=passwordsdontmatch");
				exit();
			}
			else
			{
				if(mysqli_query($conn, "UPDATE users SET user_pwd='".$new_update_password."' WHERE user_email='".$_SESSION['email']."'"))
				{
					header("Location: ./client_update.php?update=success");
					exit();
				}
				else
				{
					header("Location: ./client_update.php?error=sqlerror");
					exit();
				}
			}
			//Για την αλλαγή του username
			$username = mysqli_query($conn, "SELECT username FROM users WHERE username='".$update_username."'");
			if($row = mysqli_fetch_array($username))
			{
				header("Location: ./client_update.php?error=usernametaken");
				exit();
			}
			else
			{
				if(mysqli_query($conn, "UPDATE users SET username='".$update_username."' WHERE user_email='".$_SESSION['email']."'"))
				{
					header("Location: ./client_update.php?update=success");
					$_SESSION['username'] = $update_username;
					exit();
				}
				else
				{
					header("Location: ./client_update.php?error=sqlerror");
					exit();
				}
			}
		}
	}
	else
	{
		header("Location: ./client_update.php?error=wrongcurrentpassword");
		exit();
	}	
}
else {
	header("Location: ./client_update.php?error=unauthorisedaccess");
	exit();
}
?>