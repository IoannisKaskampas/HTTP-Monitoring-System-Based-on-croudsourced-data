<!--Είσοδος μόνο με έγκυρο login και δικαιώματα χρήστη, σε διαφορετική περίπτωση το login θα πρέπει να επαναληφθεί-->
<?php
session_start();
if(!isset($_SESSION['username']))
{
   header("Location:../login.php");
}
if($_SESSION['user_role'] == 1)
{
	header("Location:../login.php");
}
?>

<!-- Υλοποίηση αρχικής σελίδας διαχειριστή-->
<!DOCTYPE html>
<meta charset="UTF-8">

<html>

<head>
<link rel = "stylesheet" type = "text/css" href = "../main_style.css">
<link rel = "stylesheet" type = "text/css" href = "../main_form_style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<title>Ενημέρωση προφίλ</title>

</head>

<body>
<!-- Τίτλος Ιστοσελίδας-->
<div class="header">
	<h1>HTTP Monitoring System</h1>
	<h2>Based on croudsourced data</h2>
</div>

<!-- Menu bar-->
<div class="menubar">
	<a href="client.php">Υποβολή Αρχείου</a>
	<a href="clientHeatMap.php">Οπτικοποίηση Δεδομένων</a>
	<div class="dropdown" style="float: right;">
		<button class="dropbtn">Έχετε εισέλθει ως: 
			<?php
				echo $_SESSION['username'];
			?>
			<i class="fa fa-caret-down"></i>
		</button>
		<div class="dropdown-menu">
			<a href="../logout.php">Έξοδος</a>
			<a href="client_update.php">Επεξεργασία προφίλ</a>
			<a href="client_Info_Upload.php">Πληροφορίες αρχείων</a>
		</div>
	</div>
</div>
		
<!-- Main Layout Area-->
<div class="main">
<h2 style="text-align: left;">Διαχείριση Προφίλ και Προβολή Στατιστικών Χρήστη</h2>
<p style="text-align: left;">Σε αυτή την ενότητα μπορείτε να επεξεργαστείτε το προφίλ σας και να δείτε ορισμένα στατιστικά χρήσης</p>
<form method="post" action="update.php">
	<div class="container">
		<p><label for="update_username"><b>Νέο username:</b></label><br>
		<input type="text" placeholder="Εισάγετε νέο όνομα χρήστη" name="update_username"></p>
		<p><label for="update_password"><b>Κωδικός πρόσβασης*:</b></label><br>
		<input type="password" placeholder="Εισάγετε τον τρέχοντα κωδικό πρόσβασης" name="update_password" required></p>
		<p><label for="update_new_password"><b>Νέος κωδικός πρόσβασης:</b></label><br>
		<input type="password" placeholder="Εισάγετε νέο κωδικό" name="update_new_password"></p>
		<p><label for="update_comf_new_password"><b>Επιβεβαίωση νέου κωδικού πρόσβασης:</b></label><br>
		<input type="password" placeholder="Εισάγετε ξανά τον νέο κωδικό" name="update_comf_new_password"></p>
		<button type="submit" class="button_submit" name="update_button" value="update_button" style="width: auto;">Αποθήκευση αλλαγών</button>
		<p>*: Το πεδίο απαιτείται</p>
	</div>
</form>
<?php
if(isset($_GET['error'])){ 
    if($_GET['error'] == "wrongpassword"){
		echo '<div class="error-message"><p>Λάθος Κωδικός!<br> Το password πρέπει
		να είναι τουλάχιστον 8 χαρακτήρες και να περιέχει τουλάχιστον ένα κεφαλαίο γράμμα, έναν αριθμό
		και κάποιο σύμβολο (π.χ. #$*&@).</div>';
	}
	else if($_GET['error'] == "passwordsdontmatch"){
		echo '<div class="error-message">Οι κωδικοί δεν είναι όμοιοι!</div>';
	}
	else if($_GET['error'] == "usernametaken"){
		echo '<div class="error-message">Υπάρχει ήδη χρήστης με αυτό το όνομα!</div>';
	}
	else if($_GET['error'] == "wrongcurrentpassword"){
		echo '<div class="error-message">Ο τρέχον κωδικός είναι λανθασμένος</div>';
	}
}
if(isset($_GET['update'])){ 
	if($_GET['update'] == "success")
	{
		echo '<h2 style="text-align: center; color: green; font-weight: bold;">Οι αλλαγές έγιναν με επιτυχία!</h2>';
	}
}
?>
</div>

<!--Footer-->
<div class="footer">
	<p>
	Copyright 2020 
	<br> Η τρέχουσα διαδικτυακή εφαρμογή αναπτύχθηκε στα πλαίσια του μαθήματος "Προγραμματισμός και Συστήματα στον Παγκόσμιο Ιστό 
	<br> Πανεπιστήμιο Πατρών 
	<br> Πολυτεχνική Σχολή 
	<br> Τμήμα Μηχανικών Η/Υ και Πληροφορικής 
	<br> Τομέας Λογικού των Υπολογιστών 
	</p>
</div>

<script type="text/javascript">	
</script>

</body>
	
</html>