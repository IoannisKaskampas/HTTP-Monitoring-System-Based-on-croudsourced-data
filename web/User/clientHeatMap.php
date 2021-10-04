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

	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
	<link rel = "stylesheet" type = "text/css" href = "../main_style.css">
	<link rel = "stylesheet" type = "text/css" href = "../main_form_style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!--script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script-->
	<script src="https://cdn.jsdelivr.net/npm/heatmapjs@2.0.2/heatmap.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/leaflet-heatmap@1.0.0/leaflet-heatmap.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<title>Client Heatmap</title>

	<style>
	#map {
		width: 100%;
		height: 80vh;
	}
</style>

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
		<h2>Οπτικοποίηση Δεδομένων</h2>
		<div class="main">
		<p>
			Heatmap har αρχείων. 
		</p>	
		<p></p>
			<div id="map"></div>
			<!--Κάπου εδώ μπαίνει ο χάρτης για να φαίνεται στη σελίδα-->
		</div>
	</div>
	<script>
		 var baseLayer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
		 var cfg = {"radius": 40,
			"maxOpacity": 2,
			"scaleRadius": false,
			"useLocalExtrema": false,
			
			latField: 'lat',
			
			lngField: 'lng'};	
	
		 var heatmapLayer = new HeatmapOverlay(cfg);
		 
         var map = new L.map('map', {
			center: [38.246242, 21.735085],
            zoom: 7,
			layers: [baseLayer, heatmapLayer]
		 	});

		 $.ajax({
		  
			url:'geoloc.php',
		
			type:'post',

			success:function(latlng){
					var data_array = JSON.parse(latlng);
					console.log(data_array)
					var coords = data_array.map(function(x) { 
						return { 
						lat: x[0], 
						lng: x[1]
						}; 
						});

				var testData = {
					max: 10, 
					data: coords};

				heatmapLayer.setData(testData);
		  	}
		 });
	</script>
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