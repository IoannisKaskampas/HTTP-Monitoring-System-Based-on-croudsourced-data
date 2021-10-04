<!--Είσοδος μόνο με έγκυρο login και δικαιώματα διαχειριστή, σε διαφορετική περίπτωση το login θα πρέπει να επαναληφθεί-->
<?php
session_start();
if(!isset($_SESSION['username']))
{
   header("Location:../login.php");
}
if($_SESSION['user_role'] == 0)
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
<title>Administrator: Home</title>

</head>

<body>

<!-- Τίτλος Ιστοσελίδας-->
<div class="header">
	<h1>HTTP Monitoring System</h1>
	<h2>Based on croudsourced data</h2>
</div>

<!-- Menu bar-->
<div class="menubar">
	<a href="admindashboard.php">Αρχική Σελίδα Διαχείρισης</a>
	<a href="basicinfo.php">Βασικές πληροφορίες</a>
	<a href="responsetimes.php">Χρόνοι Απόκρισης</a>
	<a href="headers.php">HTTP Headers</a>
	<a href="visualization.php">Οπτικοποίηση Δεδομένων</a>
	<div class="dropdown" style="float: right;">
		<button class="dropbtn">Έχετε εισέλθει ως: 
			<?php
				echo $_SESSION['username'];
			?>
			<i class="fa fa-caret-down"></i>
    	</button>
		<div class="dropdown-menu">
      		<a href="../logout.php">Έξοδος</a>
    	</div>
  	</div>
</div>

<!-- Main Layout Area-->
<div class="main">
	<h4 style="text-align: left;">
		Καλωσήλθατε 
		<?php
			echo $_SESSION['username'];
		?>!<br>
	</h4>
	<h2 style="text-align: left;">Διαχείριση του συστήματος επεξεργασίας πληθοποριστικής πληροφορίας σχετικά με την κίνηση HTTP</h2>
	<h3 style="text-align: left;">Εδώ μπορείτε να βρείτε την ανάλυση των δεδομένων σχετικά με την κίνηση HTTP, σύμφωνα με την πληροφορία σε μορφή HAR που παρέχουν οι χρήστες</h3>
</div>
<div class="main">
	<h3>Διαθέσιμες Επιλογές:</h3>
	<h4>Απεικόνιση Βασικών Πληροφοριών</h4>
	<p>Έκθεση σχετικά με ορισμένες μετρικές της κίνησης του HTTP από τις πληροφορίες που παρέχουν οι χρήστες.</p>
	<button type="submit" class="button_submit" onclick="window.location.href='basicinfo.php'" style="width: auto">Δείτε περισσότερα</button>
	<h4>Ανάλυση Χρόνων Απόκρισης σε Αιτήσεις</h4>
	<p>Εμφανίζεται πληροφορία σχετικά με το μέσο χρόνο απόκρισης σε αιτήσεις σε συνάρτηση με το χρόνο. <br>Η πληροφορία προέρχεται από το πεδίο <b>timings</b> του αντικειμένου τύπου <b>entries</b> των αρχείων HAR.</p>
	<button type="submit" class="button_submit" onclick="window.location.href='responsetimes.php'" style="width: auto">Δείτε περισσότερα</button>
	<h4>Ανάλυση κεφαλίδων HTTP</h4>
	<p>Εμφανίζεται πληροφορία σχετικά με τη χρήση κρυφών μνημών. <br>Η πληροφορία προέρχεται από τα αντικείμενα τύπου <b>headers</b> των αρχείων HAR.</p>
	<button type="submit" class="button_submit" onclick="window.location.href='headers.php'" style="width: auto">Δείτε περισσότερα</button>
	<h4>Οπτικοποίηση Δεδομένων</h4>
	<p>Χάρτης με τις τοποθεσίες των IP διευθύνσεων στις οποίες έχουν αποσταλεί αιτήσεις HTTP. <br>Η πληροφορία προέρχεται από τα αντικείμενα τύπου <b>entries</b> των αρχείων HAR.</p>
	<button type="submit" class="button_submit" onclick="window.location.href='visualization.php'" style="width: auto">Δείτε περισσότερα</button>
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