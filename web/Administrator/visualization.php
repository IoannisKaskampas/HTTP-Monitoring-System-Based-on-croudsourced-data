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

<!DOCTYPE html>
<meta charset="UTF-8"> 

<html>

<head>

<link rel = "stylesheet" type = "text/css" href = "../main_style.css">
<link rel = "stylesheet" type = "text/css" href = "../main_form_style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js" ></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<title>Administrator: Data Visualization</title>

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
	<h2 style="text-align: left;">Οπτικοποίηση Δεδομένων</h2>
	<p style="text-align: left;">Χάρτης με τις τοποθεσίες των IP διευθύνσεων στις οποίες έχουν αποσταλεί αιτήσεις HTTP. <br>Η πληροφορία προέρχεται από τα αντικείμενα τύπου entries των αρχείων HAR.</p>
</div>
<div class="main">
	<div id="mapid" style="float: center;"></div>
	<script>
		let mymap = L.map("mapid");
		let osmUrl = "https://tile.openstreetmap.org/{z}/{x}/{y}.png";
		let osmAttrib ='Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
		let osm = new L.TileLayer(osmUrl, { attribution: osmAttrib });
		mymap.addLayer(osm);
		mymap.setView([37.975538, 23.734857], 1.5);
				
		$.getJSON('scripts/getGeoLocation.php', function (collection) {
			new L.GeoJSON(collection).addTo(mymap);
		})
	</script>
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