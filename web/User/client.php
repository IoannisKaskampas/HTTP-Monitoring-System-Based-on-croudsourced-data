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

<!-- Υλοποίηση αρχικής σελίδας χρήστη, για την υποβολή των αρχείων-->
<!DOCTYPE html>
<meta charset="UTF-8">
 
<html>

<head>

<link rel = "stylesheet" type = "text/css" href = "../main_style.css">
<link rel = "stylesheet" type = "text/css" href = "../main_form_style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<title>Υποβολή Αρχείου</title>

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
	<h4 style="text-align: left;">
		Καλωσήλθατε 
		<?php
			echo $_SESSION['username'];
		?>!<br>
	</h4>
	<h2 style="text-align: left;">Υποβολή ενός αρχείου HAR στην εφαρμογή</h2>
	<p style="text-align: left;">Σε αυτή τη σελίδα μπορείτε να υποβάλλετε ένα αρχείο HAR στην εφαρμογή.
	<br>Το αρχείο θα επεξεργαστεί ώστε να εξασφαλιστεί η ιδιωτικότητα του χρήστη. 
	<br>Στη συνέχεια, δίνεται η δυνατότητα λήψεως του αρχείου har απαλλαγμένου από προσωπικά δεδομένα ή η δυνατότητα υποβολής του αρχείου στη βάση δεδομένων της εφαρμογής.</p>
</div>
<script type="text/javascript">
	var result = {};
	result.userid = '<?php echo $_SESSION['user_id'];?>';
	$.getJSON('http://ip-api.com/json', function(data) {
		console.log(JSON.stringify(data, null, 2)); //Console print for debugging purposes only.
		result.isp = data.isp;
		result.latitude = data.lat;
		result.longitude = data.lon;
		//alert(JSON.stringify(result)); //for debugging purposes only.
		postIPdetails();
	});

	function postIPdetails(){
		$.ajax({
			url: 'getISP.php',
			type: 'post',
			//dataType: 'json', //comment if ajax returns error.
			data: result,
			//contentType: 'application/json',
			success: function (data) {
				//alert("ISP and Location Data Updated\n"+data);
			},
			error: function () {
				alert('Error');
			}
		});
	}
</script>
<div class="main">
	<div class="main">
		<h2><label for="select-file"><h2>Επιλογή ενός αρχείου HAR προς επεξεργασία</h2></label><br>
		<input type="file" id="select-file" name="selectfile" required><br>
		<h3 id="output"></h3>
		<h3 id="output2"></h3>
		<h3 id="output3"></h3>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script type="text/javascript">
			const output = document.getElementById('output'); //output html object variable
			if (window.FileList && window.File) { //if file chosen
				document.getElementById('select-file').addEventListener('change', function() { //on change event
					var reader = new FileReader();
					reader.onload = function(){
					/*Parse JSON HAR File*/
					var inputhar = JSON.parse(reader.result);

            		/*Keep only selected items from JSON HAR Input*/
   					var selected_log = ['entries'];
					var sel_entries = ['startedDateTime','serverIPAddress','timings', 'request', 'response', 'headers'];
					var sel_timings = ['wait'];
					var sel_request = ['method','url','headers'];
					var sel_response = ['status','statusText','headers'];
					var sel_headers = ['content-type','Content-Type','cache-control','Cache-Control','pragma','Pragma','Expires','expires','Age','age','Last-Modified','last-modified','host','Host'];
					
					for(let k in inputhar.log){
						if(selected_log.indexOf(k) < 0){
							delete inputhar.log[k];
						}
					}

					for(let index in inputhar.log.entries){
						for(let k in inputhar.log.entries[index]){
							if(sel_entries.indexOf(k) < 0){
								delete inputhar.log.entries[index][k];
							}
						}
					
						for(let k in inputhar.log.entries[index].timings){
							if(sel_timings.indexOf(k) < 0){
								delete inputhar.log.entries[index].timings[k];
							}
						}
						
						for(let k in inputhar.log.entries[index].request){
							if(sel_request.indexOf(k) < 0){
								delete inputhar.log.entries[index].request[k];
							}
						}
						
						for(let k in inputhar.log.entries[index].response){
							if(sel_response.indexOf(k) < 0){
								delete inputhar.log.entries[index].response[k];
							}
						}
					}

					//HEADERS
					/*Function to delete JSON Array object by name*/
					function findAndRemove(array, property, value) {
						array.forEach(function(result, index) {
   							if(result[property] === value) {
   								array.splice(index, 1); //Remove object from array
   							}
						});
					}

           			//HEADERS - REQUEST
           			var headers = [];

					for(let index in inputhar.log.entries){
						for(var i = 0; i < (inputhar.log.entries[index].request.headers).length; i++){	
							headers.push(inputhar.log.entries[index].request.headers[i]["name"]);
						}
					}

            		//Array difference
					var diff1 = headers.filter(x => !sel_headers.includes(x));
				
    				//remove unwanted header objects
					for(let index in inputhar.log.entries){
						for(let v in diff1){
							findAndRemove(inputhar.log.entries[index].request.headers, 'name', diff1[v]);
						}
					}

            		//HEADERS - RESPONSE
					headers = [];

					for(let index in inputhar.log.entries){
						for(var i = 0; i < (inputhar.log.entries[index].response.headers).length; i++){	
							headers.push(inputhar.log.entries[index].response.headers[i]["name"]);
						}
					}

           			//Array difference
					var diff2 = headers.filter(x => !sel_headers.includes(x));
					
					//remove unwanted header objects
					for(let index in inputhar.log.entries){
						for(let v in diff2){
							findAndRemove(inputhar.log.entries[index].response.headers, 'name', diff2[v]);
						}
					}

					/*View results on browser*/
					var har_export = JSON.stringify(inputhar);
			
					//document.getElementById('output').textContent = har_export; //for debugging purposes only
            		document.getElementById('output2').style.color = "green";
            		document.getElementById('output2').textContent = "Η τοπική επεξεργασία του αρχείου έγινε με επιτυχία!";
            		document.getElementById('output3').textContent = "Επιλέξτε ένα από τα παρακάτω:";

            		document.getElementById("upload_button").style.display = "inline";
            		document.getElementById("download_button").style.display = "inline";

            		//Download HAR File after processing
            		function download(jsonstr, fileName, contentType) {
                		var a = document.createElement("a");
                		var file = new Blob([jsonstr], {type: contentType});
                		a.href = URL.createObjectURL(file);
                		a.download = fileName;
                		a.click();
            		}
					document.getElementById("download_button").onclick = function(){download(har_export, 'export.har', 'text/plain')};

					//Encode Upload Date and Time to HAR JSON Before sending to server.
					var currentdate = new Date(); 
					var datetime = currentdate.getFullYear() + "-" + (currentdate.getMonth()+1)  + "-" + currentdate.getDate() + " " + currentdate.getHours() + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();
					for(let d in inputhar.log.entries){
						inputhar.log.entries[d].uploadDate = datetime;
					}

					//Extract Responding Server IP to fetch server's geolocation
					var ipobj = {
						"entries": []
						//"latitude": [],
						//"longitude": []
					};
					for(let i in inputhar.log.entries){
						var serveripaddr = inputhar.log.entries[i].serverIPAddress;
						if(serveripaddr != undefined){
							var flag = false;
							for(let index=0; index<ipobj.entries.length; ++index){
								var thisipobj = ipobj.entries[index];
								if(thisipobj.ip == serveripaddr){
									flag = true;
									break;
								}
							}
							if(flag == false){
								ipobj.entries.push({"ip": serveripaddr, "latitude": "null", "longitude": "null"});
							}
						}
					}
					console.log(JSON.stringify(ipobj));
					function getServerLocation(){
						var entrieslength = ipobj.entries.length;
						for(let i in ipobj.entries){
							var serverip = ipobj.entries[i].ip;
							$.getJSON('http://ip-api.com/json/'+serverip, function(data) {
								console.log(JSON.stringify(data, null, 2)); //Console print for debugging purposes only.
								ipobj.entries[i].latitude = data.lat;
								ipobj.entries[i].longitude = data.lon;
								if(ipobj.entries[entrieslength-1].longitude != "null"){
									console.log(JSON.stringify(ipobj));
									postServerLocation();
								}
							});
						}
					}
					function postServerLocation(){
						$.ajax({
							url: 'getGeoLocation.php',
							type: 'post',
							//dataType: 'json', //comment if ajax returns error.
							data: ipobj,
							//contentType: 'application/json',
							success: function (data) {
								//alert(data);
								UploadSuccess();
							},
							error: function () {
								alert('Error');
							}
						});
					}

					//On upload success change the page content
					function UploadSuccess(){
						document.getElementById('output2').style.color = "green";
            			document.getElementById('output2').textContent = "Το αρχείο που υποβάλλατε εστάλη επιτυχώς. Για να υποβάλλετε άλλο αρχείο κάνετε ανανέωση της σελίδας";
						document.getElementById('output3').style.display = "none";
            			document.getElementById("upload_button").style.display = "none";
	            		document.getElementById("download_button").style.display = "none";
						document.getElementById("image_success").style.display = "block";
						document.getElementById("select-file").style.display = "none";
					}
					//Upload HAR JSON Data to server.
					$("#upload_button").on('click', function(){
						$.ajax({
							url: 'receive.php',
							type: 'post',
							//dataType: 'json', //comment if ajax returns error.
							data: inputhar,
							//contentType: 'application/json', //comment if ajax returns error.
							success: function (data) {
								//alert(data);
								//UploadSuccess();
								getServerLocation();
							},
							error: function () {
								alert('Error');
							}
						});
					});
				}
				reader.readAsText(this.files[0]);
			})
		}
		</script>
		<img id="image_success" src="../images/success-green-check-mark.png" alt="upload success" style="display: none; margin-left: auto; margin-right: auto; width: 15%;">
		<button type="submit" class="button_submit" name="upload_button" id="upload_button" value="upload_button" style="width: 250px; display: none">Υποβολή</button> &nbsp;
		<button type="submit" class="button_submit" name="download_button" id="download_button" value="download_button" style="width: 250px; display: none">Λήψη επεξεργασμένου αρχείου</button> &nbsp;
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

</body>

</html>