<?php
    require '../connect.php';
    session_start();
    $userid = $_SESSION['user_id'];

    $sql = "SELECT ServerIPgeoLocLat as latitude, ServerIPgeoLocLong as longtitude, userid FROM har WHERE ServerIPgeoLocLat IS NOT NULL AND ServerIPgeoLocLong IS NOT NULL AND userid='$userid'"; 

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $json_array = array();
        while($row = mysqli_fetch_assoc($result)) 
            { 
                $temp_array = array();
                array_push($temp_array,floatval($row["latitude"]));
                array_push($temp_array,floatval($row["longtitude"]));
                array_push($json_array,$temp_array);
            }
                echo json_encode($json_array);
        }
        else {
            echo "no data";
        }
?>