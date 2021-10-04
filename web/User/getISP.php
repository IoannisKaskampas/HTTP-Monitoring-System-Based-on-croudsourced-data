<?php
    $con = mysqli_connect('localhost','root','','webdb');
	if (!$con)
	{
		die('Error in connection: ' . mysqli_error($con));
	}

    $_POST ? '' : $_POST = json_decode(trim(file_get_contents('php://input')), true);
    var_dump($_POST);
    $userid = $_POST['userid'];
    echo "----USER ID: ".$userid."----";
    $isp = $_POST['isp'];
    echo "----ISP: ".$isp."----";
    $lat = $_POST['latitude'];
    echo "----LOCATION->LATITUDE: ".$lat."----";
    $long = $_POST['longitude'];
    echo "----LOCATION->LONGITUDE: ".$long."----";

    mysqli_query($con, "UPDATE users SET user_ISP='".$isp."', user_cityCoordsLat='".$lat."', user_cityCoordsLong='".$long."' WHERE user_id='".$userid."';");
    echo "----User ISP and Coordinates Successfully Updated!!----";
    mysqli_close($con);
?>