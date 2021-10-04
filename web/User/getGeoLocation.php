<?php
    require '../connect.php';

    session_start();
    $userid = $_SESSION['user_id'];

    $_POST ? '' : $_POST = json_decode(trim(file_get_contents('php://input')), true);
    var_dump($_POST);

    $entries = $_POST['entries'];
    foreach($entries as $item){
        if(isset($item['ip'])){
            $ip = $item['ip'];
            echo "ip: ".$ip;
        }
        if(isset($item['latitude'])){
            $latitude = $item['latitude'];
            echo "latitude: ".$latitude;
        }
        if(isset($item['longitude'])){
            $longitude = $item['longitude'];
            echo "longitude: ".$longitude;
        }
        mysqli_query($conn, "UPDATE har SET ServerIPgeoLocLat='".$latitude."', ServerIPgeoLocLong='".$longitude."' WHERE serverIPAddress='".$ip."' AND userid='".$userid."';");
    }
    echo "----Server Coordinates Successfully Updated!!----";
    mysqli_close($conn);
?>