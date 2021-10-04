<?php
	$con = mysqli_connect('localhost','root','','webdb');
	if (!$con)
	{
		die('Error in connection: ' . mysqli_error($con));
	}
	
	function createFeature () {
    	$feature = new stdClass();
	    $feature->type = 'Feature';
    	$feature->properties = new stdClass();
    	$feature->geometry = new stdClass();
    	$feature->geometry->type = 'Point';
    	$feature->geometry->coordinates = array();
    	return $feature;
	}

	function createCollection () {
	    $collection = new stdClass();
	    $collection->type = 'FeatureCollection';
	    $collection->features = array();
    	return $collection;
	}
	
	if($loc = mysqli_query($con,"SELECT ServerIPgeoLocLat as latitude, ServerIPgeoLocLong as longitude FROM har WHERE ServerIPgeoLocLat IS NOT NULL AND ServerIPgeoLocLong IS NOT NULL"))
	{
		$collection = createCollection();
		 
		while ($row = $loc->fetch_object()) {

        	$feature = createFeature();

        	$feature->geometry->coordinates[] = $row->longitude;
        	$feature->geometry->coordinates[] = $row->latitude;

        	$collection->features[] = $feature;
    	}

    	echo json_encode($collection);
	}
	
	mysqli_close($con);
?>