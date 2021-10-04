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
<title>Administrator: Response Times</title>
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
	<h2 style="text-align: left;">Ανάλυση Χρόνων Απόκρισης σε Αιτήσεις</h2>
	<p style="text-align: left;">Εμφανίζεται πληροφορία σχετικά με το μέσο χρόνο απόκρισης σε αιτήσεις ανά ώρα της ημέρας [0-23]. <br>Η πληροφορία προέρχεται από το πεδίο timings του αντικειμένου τύπου entries των αρχείων HAR.</p>
</div>
<div class="main">
	<h3>Μέσος χρόνος απόκρισης ανά αίτηση ανά ώρα της ημέρας</h3>
	<p>Το παρακάτω διάγραμμα, παραμετροποιείται από τα παρακάτω φίλτρα</p>
	<table style="width: 50%; margin-left: auto; margin-right: auto;">
		<tr>
			<td style="border: 1px solid #fff;">
				<select id="type">
					<option value="0">CONTENT-TYPE</option>
					<?php
						$type_query = mysqli_query($con, "SELECT DISTINCT content_type FROM har WHERE content_type !='' ");
						$type = [];
						
						while($row = mysqli_fetch_assoc($type_query))
						{
							$type = $row['content_type'];
							
							echo "<option value='".$type."'>".$type."</option>";
						}
					?>
				</select>
			</td>
			<td style="border: 1px solid #fff;">
				<select id="weekday">
					<option value="0">Ημέρα της εβδομάδας</option>
					<option value='Sunday'>Κυριακή</option>
					<option value='Monday'>Δευτέρα</option>
					<option value='Tuesday'>Τρίτη</option>
					<option value='Wednesday'>Τετάρτη</option>
					<option value='Thursday'>Πέμπτη</option>
					<option value='Friday'>Παρασκευή</option>
					<option value='Saturday'>Σάββατο</option>
				</select>
			</td>
			<td style="border: 1px solid #fff;">
				<select id="method">
					<option value="0">Request Method</option>
					<?php
						$req_query = mysqli_query($con, "SELECT DISTINCT req_method as method FROM har");
						$req = [];
						
						while($row = mysqli_fetch_assoc($req_query))
						{
							$req = $row['method'];
							
							echo "<option value='".$req."'>".$req."</option>";
						}
					?>
				</select>
			</td>
			<td style="border: 1px solid #fff;">
				<select id="isp">
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
				</select>
			</td>
		</tr>
	</table>
	<button id="btn1" class="button_submit" style="width: auto">Εφαρμογή φίλτρων</button>
</div>
<div id="graph" class="main" style="width: 60%; margin-left: auto; margin-right: auto;">
	<canvas id="timingsChart"></canvas>
</div>
<script>
	function TimingsChartShow(wait,hours)
	{
		var ctx = document.getElementById('timingsChart').getContext('2d');
		var chart = new Chart(ctx, 
		{
			type: 'bar',
			data: 
			{
				labels: hours,
				datasets: [{
					label: 'Average response time per request',
					backgroundColor: '#3399FF',
					borderColor: '#3399FF',
					data: wait
				}]
			},
			options: 
			{
				scales: 
				{
					yAxes: [{
						ticks: 
						{
							beginAtZero: true,
						}
					}]
				}
			}
		});
		//chart.update();
	}
	
    $("#btn1").click(function()
	{
        var ctype = $("#type").val();
		console.log(ctype);
		var wday = $("#weekday").val();
		console.log(wday);
		var req = $("#method").val();
		console.log(req);
		var uisp = $("#isp").val();
		console.log(uisp);
		
		
		if ($('#timingsChart').length)
		{
			$.ajax({
				url: 'scripts/getTimings.php',
				type: 'post',
				dataType: 'json',
				data: ({type: ctype, day: wday, method: req, isp: uisp}),
				success:function(resp)
				{
					var timings = resp[0];
					var hour = resp[1];
					TimingsChartShow(timings,hour); //graph function
				}
			});
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
<?php
	mysqli_close($con);
?>
</body>

</html>