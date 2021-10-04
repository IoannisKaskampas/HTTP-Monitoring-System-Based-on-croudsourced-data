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

<?php
$con = mysqli_connect('localhost','root','','webdb');
if (!$con)
{
	die('Error in connection: ' . mysqli_error($con));
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
<title>Administrator: HTTP Headers</title>
<script>
function showTable(str) {
  if (str == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","scripts/cacheTable.php?q="+str,true);
    xmlhttp.send();
  }
}
</script>
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
	<h2 style="text-align: left;">Ανάλυση κεφαλίδων HTTP</h2>
	<p style="text-align: left;">Εμφανίζεται πληροφορία σχετικά με τη χρήση κρυφών μνημών. <br>Η πληροφορία προέρχεται από τα αντικείμενα τύπου headers των αρχείων HAR.</p>
	<h4 style="text-align: left;">Φιλτράρισμα Δεδομένων με βάση τον πάροχο συνδεσιμότητας του χρήστη</h4>
	<select id="isp" style="float: left;">
		<option value="0">Πάροχος Συνδεσιμότητας</option>
		<?php
			$isp_query = mysqli_query($con, "SELECT distinct user_ISP FROM users WHERE user_ISP != ''");
			$isp = [];
			while($row = mysqli_fetch_assoc($isp_query))
			{
				$isp = $row['user_ISP'];
				echo "<option value='".$isp."'>".$isp."</option>";
			}
		?>
	</select><br><br>
	<button id="btn2" class="button_submit" style="width: auto; float: left;">Εφαρμογή φίλτρων</button><br>
</div>
<div class="main">
	<h3>Κατανομή TTL των ιστοαντικειμένων ανά Content-Type</h3>
	<p>Παρακάτω εμφανίζεται ένα ιστόγραμμα με την κατανομή TTL των ιστοαντικειμένων στη βάση ανά Content-Type</p>
	<div class="main" style="width: 40%; margin-left: auto; margin-right: auto;">
		<canvas id="histogram"></canvas>
	</div>
</div>
<script>
	function HistogramShow(maxage,type)
	{
		var ctx = document.getElementById('histogram').getContext('2d');
		var chart = new Chart(ctx, 
		{
			type: 'bar',
			data: 
			{
				labels: type,
				datasets: [{
					label: 'TTL distribution by Content-Type',
					backgroundColor: '#3399FF',
					borderColor: '#3399FF',
					data: maxage
				}]
			},
			options: {
				scales: {
					xAxes: [{
						display: false,
						barPercentage: 1.3,
						ticks: {
							max: 10,
						}
					}, {
						display: true,
						ticks: {
							autoSkip: false,
							max: 10,
						}
					}],
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}
		});
		//chart.update();
	}
	
    $("#btn2").click(function()
	{
		var uisp = $("#isp").val();
		console.log(uisp);
		
		if ($('#histogram').length)
		{
			$.ajax({
				url: 'scripts/getTTL.php',
				type: 'post',
				dataType: 'json',
				data: ({isp: uisp}),
				success:function(resp)
				{
					var ttl = resp[0];
					var type = resp[1];
					HistogramShow(ttl,type); //graph function
				}
			});
		}
    });
</script>
<div class="main">
	<h4 style="text-align: left;">Φιλτράρισμα Δεδομένων με βάση το Content-Type</h4>
	<form>
	<select id="type" style="float: left;">
		<option value="0">CONTENT-TYPE</option>
		<?php
			$type_query = mysqli_query($con, "SELECT DISTINCT content_type FROM har WHERE content_type !=''");
			$type = [];
			while($row = mysqli_fetch_assoc($type_query))
			{
				$type = $row['content_type'];
				echo "<option value='".$type."'>".$type."</option>";
			}
		?>
	</select>
	</form>
<script>
	document.getElementById("type").onchange = function() {getPercentages()};

	function getPercentages() {
		var sel = document.getElementById("type");
		console.log(sel.value);
		showTable(sel.value);
	}
</script>
</div>
<div class="main">
	<div id="txtHint"></div>
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