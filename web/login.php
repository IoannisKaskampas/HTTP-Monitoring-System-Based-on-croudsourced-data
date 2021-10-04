<?php
session_start();
?>
<!DOCTYPE html>
<meta charset="UTF-8"> 
<html>


<head>

<link rel = "stylesheet" type = "text/css" href = "main_style.css">
<link rel = "stylesheet" type = "text/css" href = "main_form_style.css">
<title>Log-in</title>

</head>

<body>
<!-- Τίτλος Ιστοσελίδας-->
<div class="header">
	<h1>HTTP Monitoring System</h1>
	<h2>Based on croudsourced data</h2>
</div>

<!-- Menu bar-->
<div class="menubar">
	<a href="index.html">Αρχική Σελίδα</a>
	<a href="about.html">Σχετικά με την εφαρμογή</a>
	<a href="register.php" class="right">Εγγραφή</a>
	<a href="login.php" class="right">Σύνδεση</a>
</div>

<!-- Main Layout Area-->
<div class="main">
	<?php
		if(isset($_GET['logout'])) //Εμφάνιση μηνύματος εξόδου από το σύστημα, στην κορυφή της σελίδας login εάν ο χρήστης κάνει έξοδο.
		{
			if($_GET['logout'] == "logouttrue")
			{
				echo '<h2 style="text-align: center; color: green; font-weight: bold;">Έχετε αποσυνδεθεί επιτυχώς από το σύστημα. Συνδεθείτε ξανά για να συνεχίσετε</h2>';
			}
		}
		if(isset($_GET['register'])) //Εμφάνιση μηνύματος εισόδου νέου χρήστη, στην κορυφή της σελίδας login εάν ο χρήστης είναι νέος και έκανε register προηγουμένως.
		{
			if($_GET['register'] == "newuser")
			{
				echo '<h2 style="text-align: center; color: green; font-weight: bold;">Εγγραφήκατε επιτυχώς. Συνδεθείτε για να συνεχίσετε</h2>';
			}
		}
	?>
	<h2 style="text-align: center">Σύνδεση χρήστη στο σύστημα:</h2>
	<form method="post" action="verify.php">
		<div class="container">
			<p>Εισάγετε τα στοιχεία σας παρακάτω για να συνδεθείτε.</p>
			<p>
				<label for="username"><b>Όνομα Χρήστη:</b></label> <br>
				<input type="text" placeholder="Εισάγετε όνομα χρήστη (Απαιτείται)" name="username" required> <br>
				<label for="password"><b>Κωδικός Πρόσβασης:</b></label> <br>
				<input type="password" placeholder="Εισάγετε κωδικό πρόσβασης (Απαιτείται)" name="password" required> <br>
				<button type="submit" class="button_submit" name="login_submit" value="login_submit">Είσοδος</button>
			</p>
		</div>
	</form>
	<?php
	if(isset($_GET['error']))
	{
		if($_GET['error'] == "wrongpassword")
		{
			echo '<div class="error-message">Ο Κωδικός είναι λανθασμένος</div>';
		}
		else if($_GET['error'] == "usernotfound")
		{
			echo '<div class="error-message">Ο χρήστης δεν βρέθηκε!</div>';
		}
	}
	?>
	<p>
	<b>Εάν δεν έχετε λογαριασμό, μπορείτε να εγγραφείτε από εδώ:</b> <br>
	<button type="submit" class="button_submit" onclick="window.location.href='register.php'" style="width: 250px">Δημιουργήστε Λογαριασμό</button>
	</p>
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

</body>


</html>