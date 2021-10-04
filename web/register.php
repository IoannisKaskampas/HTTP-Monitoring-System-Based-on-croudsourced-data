<!-- Υλοποίηση σελίδας για την εγγραφή νέου χρήστη-->
<!DOCTYPE html>
<meta charset="UTF-8"> 
<html>


<head>

<link rel = "stylesheet" type = "text/css" href = "main_style.css">
<link rel = "stylesheet" type = "text/css" href = "main_form_style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<title>User Register</title>

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
	<h2>Εγγραφή νέου χρήστη στο σύστημα:</h2>
	<form method="post" action="signup.php">
		<div class="container">
			<p>
				<label for="userid">Όνομα Χρήστη:</label> <br>
				<input type="text" placeholder="Εισάγετε όνομα χρήστη (Απαιτείται)" name="username" required> <br>
				<label for="email">email:</label> <br>
				<input type="text" placeholder="Εισάγετε email χρήστη (Απαιτείται)" name="email" required> <br>
				<label for="passwd">Κωδικός Πρόσβασης:</label> <br>
				<input type="password" placeholder="Εισάγετε κωδικό πρόσβασης (Απαιτείται)" name="password" required> <br>
				<label for="passwordConfirm">Επιβεβαίωση κωδικού πρόσβασης:</label><br>
				<input type="password" placeholder="Εισάγετε ξανά τον κωδικό πρόσβασης (Απαιτείται)" name="passwordConfirm"> <br>
				<button type="submit" class="submit_button" name="signup_submit" id="signup_submit" value="signup_submit">Εγγραφή</button>
			</p>
		</div>
	</form>
	<?php
	if(isset($_GET['error'])){
		if($_GET['error'] == "invalidmail"){
			echo '<div class="error-message">Λάθος Email!</div>';
		}
		else if($_GET['error'] == "emptyfields"){
			echo '<div class="error-message">Συμπληρώστε όλα τα πεδία!</div>';
		}
		else if($_GET['error'] == "invalidmailandusername"){
			echo '<div class="error-message">Λάθος Email και Όνομα Χρήστη!</div>';
		}
		else if($_GET['error'] == "invalidusername"){
			echo '<div class="error-message">Λάθος Όνομα Χρήστη!</div>';
		}
		else if($_GET['error'] == "wrongpassword"){
			echo '<div class="error-message"><p>Λάθος Κωδικός!<br> Το password πρέπει
			να είναι τουλάχιστον 8 χαρακτήρες και να περιέχει τουλάχιστον ένα κεφαλαίο γράμμα, έναν αριθμό
			και κάποιο σύμβολο (π.χ. #$*&@).</div>';
		}
		else if($_GET['error'] == "passwordsdontmatch"){
			echo '<div class="error-message">Οι κωδικοί δεν είναι όμοιοι!</div>';
		}
		else if($_GET['error'] == "usernameoremailtaken"){
			echo '<div class="error-message">Υπάρχει ήδη χρήστης με αυτό το όνομα ή/και email!</div>';
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

</body>

</html>