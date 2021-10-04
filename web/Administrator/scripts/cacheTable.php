<?php
	$q = $_GET['q'];
	$con = mysqli_connect('localhost','root','','webdb');
	if (!$con)
	{
		die('Error in connection: ' . mysqli_error($con));
	}
	
	$cache = mysqli_query($con,"SELECT cache_control as directive, (Count(cache_control)* 100 / (Select Count(*) From har)) as percentage from har where cache_control='max-stale' OR cache_control='min-fresh' AND content_type='".$q."' group by cache_control, content_type");
	
	echo '<h3>Ποσοστό max-stale και min-fresh directives ανά Content-Type</h3><p>Παρακάτω εμφανίζεται ένας πίνακας με τα ποσοστά</p>';
	
	echo '<table style="width: 50%; margin-left: auto; margin-right: auto;">
			<thead>
				<th>Directive</th>
				<th>Ποσοστό</th>
			</thead>';
	
	while($row = mysqli_fetch_array($cache))
	{
		echo '<tr>';
		echo '<td>' . $row['directive'] . '</td>';
		echo '<td>' . $row['percentage'] . '%</td>';
		echo '</tr>';
	}
	
	echo '</table>';
	
	$pragma = mysqli_query($con,"SELECT resp_pragma, (Count(resp_pragma)* 100 / (Select Count(*) From har)) as percent from har where content_type='".$q."' and resp_pragma !='' group by resp_pragma, content_type");
	
	echo '<h3>Ποσοστό cacheability directives ανά Content-Type</h3><p>Παρακάτω εμφανίζεται ένας πίνακας με τα ποσοστά</p>';
	
	echo '<table style="width: 50%; margin-left: auto; margin-right: auto;">
			<thead>
				<th>Directive</th>
				<th>Ποσοστό</th>
			</thead>';
	
	while($row2 = mysqli_fetch_array($pragma))
	{
		echo '<tr>';
		echo '<td>' . $row2['resp_pragma'] . '</td>';
		echo '<td>' . $row2['percent'] . '%</td>';
		echo '</tr>';
	}
	
	echo '</table>';
	
	mysqli_close($con);
?>