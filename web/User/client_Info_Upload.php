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

<!DOCTYPE html>
<meta charset="UTF-8">


 
<html>

	<head>
		<link rel = "stylesheet" type = "text/css" href = "../main_style.css">
		<link rel = "stylesheet" type = "text/css" href = "../main_form_style.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<title>Client</title>
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
		
		
		<div class="main">
			<h2 style="text-align: middle;">
			Πληροφορίες σχετικά με το ανέβασμα αρχείων από το χρήστη: 
			<?php
				echo $_SESSION['username'];
			?><br>
		    </h2>
			
				<!-- ΠΕΔΙΟ ΓΙΑ ΤΗΝ ΕΙΣΑΓΩΓΗ ΔΕΔΟΜΕΝΩΝ ΑΠΟ ΤΗΝ ΒΑΣΗ -->
				<div class="main">
					<h4 style="text-align: middle"; >Η τελευταία μεταφόρτωση αρχείου σας έγινε στις : </h4>
					 <div id="lastUpload"> </div>
				</div>
				
				<!-- ΠΕΔΙΟ ΓΙΑ ΤΗΝ ΕΙΣΑΓΩΓΗ ΔΕΔΟΜΕΝΩΝ ΑΠΟ ΤΗΝ ΒΑΣΗ -->
				<div class="main">
					<h4 style="text-align: middle";>Το πλήθος των μεταφορτώσεων σας είναι :</h4>
					<div id="uploads"> </div>
					<br>
				</div>
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
				
		<script>
			//script ΓΙΑ AJAX ΜΕ ΤΗΝ ΒΙΒΛΙΟΘΗΚΗ JQUERY
			$(document).ready(function(){
				$("#lastUpload").load("clientLastUpload.php");
				$("#uploads").load("clientUploads.php");
			});
		</script>
	</body>
	
</html>