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
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<title>Administrator: Data Report</title>
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
	<h2 style="text-align: left;">Απεικόνιση Βασικών Πληροφοριών</h2>
	<p style="text-align: left;">Έκθεση σχετικά με ορισμένες μετρικές της κίνησης του HTTP από τις πληροφορίες που παρέχουν οι χρήστες.</p>
</div>
<div class="main">
	<h3>Εγγεγραμμένοι χρήστες</h3>
	<p>Παρακάτω εμφανίζεται ένας πίνακας με όλα τα στοιχεία των εγγεγραμμένων χρηστών</p>
	<?php include 'scripts/usersTable.php';?>
</div>
<div class="main">
	<h3>Πλήθος των εγγραφών στη βάση ανά τύπο αίτησης</h3>
	<p>Παρακάτω εμφανίζεται ένα γράφημα με το πλήθος των καταχωρήσεων στη βάση ανά μέθοδο αίτησης</p>
	<div class="main" style="width: 40%; margin-left: auto; margin-right: auto;">
	<canvas id="methodChart"></canvas>
	</div>
	<script src="scripts/reqMethods.js"></script>
</div>
<div class="main">
	<h3>Πλήθος των εγγραφών στη βάση ανά κωδικό απόκρισης</h3>
	<p>Παρακάτω εμφανίζεται ένα γράφημα με το πλήθος των καταχωρήσεων στη βάση ανά status απόκρισης</p>
	<div class="main" style="width: 40%; margin-left: auto; margin-right: auto;">
	<canvas id="statusChart"></canvas>
	</div>
	<script src="scripts/respStatus.js"></script>
</div>
<div class="main">
	<h3>Πλήθος των μοναδικών domains στη βάση</h3>
	<p>Παρακάτω εμφανίζεται ένας πίνακας με όλα τα domains που έχουν καταχωρηθεί στη βάση</p>
	<?php include 'scripts/domainsTable.php';?>
</div>
<div class="main">
	<h3>Πλήθος των μοναδικών παρόχων συνδεσιμότητας στη βάση</h3>
	<p>Παρακάτω εμφανίζεται ένας πίνακας με όλους τους μοναδικούς παρόχους συνδεσιμότητας που έχουν καταχωρηθεί στη βάση</p>
	<?php include 'scripts/ISPTable.php';?>
</div>
<div class="main">
	<h3>Μέση ηλικία των ιστοαντικειμένων τη στιγμή που ανακτήθηκαν ανά "CONTENT-TYPE"</h3>
	<p>Παρακάτω εμφανίζεται ένα γράφημα με τη μέση ηλικία των ιστοαντικειμένων ανά "CONTENT-TYPE"</p>
	<div class="main" style="width: 40%; margin-left: auto; margin-right: auto;">
	<canvas id="avgAgeChart"></canvas>
	</div>
	<script src="scripts/avgAge.js"></script>
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