<?php
    session_start();
    //$jsonReceiveData = json_encode($_POST);
    //echo $jsonReceiveData;

    //UPLOADING STEPS
    //1. DB Connection
    $con = mysqli_connect('localhost','root','','webdb');
	if (!$con)
	{
		die('Error in connection: ' . mysqli_error($con));
	}
    
    //2. Fetch JSON
    $_POST ? '' : $_POST = json_decode(trim(file_get_contents('php://input')), true);
    var_dump($_POST);

    //3. JSON Extract Values to local Variables
    $entries = $_POST['log']['entries'];
    $userid = $_SESSION['user_id'];
    
    foreach($entries as $item){
        //Initialize all variables
        $starteddatetime = null;
        $timingswait = null;
        $serveripaddress = null;
        $method = null;
        $url = null;
        $status = null;
        $statustext = null;
        $contenttype = null;
        $cachecontroldirective = null;
        $cachecontrolvalue = null;
        $resp_cachecontroldirective = null;
        $resp_cachecontrolvalue = null;
        $pragma = null;
        $resp_pragma = null;
        $expires = null;
        $age = null;
        $lastmodified = null;
        $host = null;
        $uploaddate = null;
        if(isset($item['uploadDate']))
        {
            $uploaddate = $item['uploadDate'];
            //echo "Uploaded Date: ".$uploaddate;
        }
        if(isset($item['startedDateTime']))
        {
            $starteddatetime = $item['startedDateTime'];
            //echo "Started Date time: ".$starteddatetime;
        }
        if(isset($item['serverIPAddress'])){
            $serveripaddress = $item['serverIPAddress'];
            //echo "Server IP Address: ".$serveripaddress;
        }
        if(isset($item['timings'])){
            $timingswait = $item['timings']['wait'];
            //echo "Timings wait: ".$timingswait;
        }
        if(isset($item['request'])){
            $method = $item['request']['method'];
            //echo "Request method: ".$method;
            $url = $item['request']['url'];
            $url = parse_url($url, PHP_URL_HOST);
            //echo "Request URL: ".$url;
            $reqheaders = $item['request']['headers'] ?? "";
            if(is_array($reqheaders) || is_object($reqheaders)){
                foreach($reqheaders as $item2){
                    if($item2['name'] == "Cache-Control" || $item2['name'] == "cache-control"){
                        $cachecontrol = $item2['value'];
                        $cachecontrolvalue = preg_replace("/[^0-9.]/", '', $cachecontrol);
                        $cachecontroldirective = preg_replace("/[^a-zA-z-]/", '', $cachecontrol);
                        //echo "Cache Control Directive:".$cachecontroldirective."Value: ".$cachecontrolvalue;
                    }
                    else if($item2['name'] == "pragma" || $item2['name'] == "Pragma"){
                        $pragma = $item2['value'];
                        //echo "Pragma :".$pragma;
                    }
                    else if($item2['name'] == "Host" || $item2['name'] == "host"){
                        $host = $item2['value'];
                        //echo "host :".$host;
                    }
                }
            }
        }
        if(isset($item['response'])){
            $status = $item['response']['status'];
            //echo "Response status: ".$status;
            $statustext = $item['response']['statusText'];
            //echo "Response statusText: ".$statustext;
            $respheaders = $item['response']['headers'] ?? "";
            if(is_array($respheaders) || is_object($respheaders)){
                foreach($respheaders as $item2){
                    if($item2['name'] == "Content-Type" || $item2['name'] == "content-type"){ //Κατά παραδοχή, κρατάμε μόνο το content-type από το response, καθώς στο response αναφέρεται συνήθως το content type, ενώ όσες φορές παρατηρήθηκε να αναγράφεται content type στο request ήταν το ίδιο με το response.
                        $contenttype = $item2['value'];
                        //echo "Content Type :".$contenttype;
                    }
                    else if($item2['name'] == "Cache-Control" || $item2['name'] == "cache-control"){
                        $resp_cachecontrol = $item2['value'];
                        $resp_cachecontrolvalue = preg_replace("/[^0-9.]/", '', $resp_cachecontrol);
                        $resp_cachecontroldirective = preg_replace("/[^a-zA-z-]/", '', $resp_cachecontrol);
                        //echo "Cache Control Directive:".$cachecontroldirective." Value: ".$cachecontrolvalue;
                    }
                    else if($item2['name'] == "pragma" || $item2['name'] == "Pragma"){
                        $resp_pragma = $item2['value'];
                        //echo "Pragma :".$pragma;
                    }
                    else if($item2['name'] == "expires" || $item2['name'] == "Expires"){
                        $expires = $item2['value'];
                        //echo "expires :".$expires;
                    }
                    else if($item2['name'] == "age" || $item2['name'] == "Age"){
                        $age = $item2['value'];
                        //echo "age :".$age;
                    }
                    else if($item2['name'] == "last-modified" || $item2['name'] == "Last-Modified"){
                        $lastmodified = $item2['value'];
                        //echo "last-modified :".$lastmodified;
                    }
                }
            }
        }
        //4. Query Insert to DB
        mysqli_query($con, "INSERT INTO har (userid, dateAndTime, startedDateTime, timingsWait, serverIPAddress, req_method, url, statusRes, statusText, content_type, cache_control, cache_control_value, resp_cache_control, resp_cache_control_value, pragma, resp_pragma, expires, age, last_modified, hhost) VALUES('".$userid."', '".$uploaddate."', '".$starteddatetime."', '".$timingswait."', '".$serveripaddress."', '".$method."', '".$url."', '".$status."', '".$statustext."', '".$contenttype."', '".$cachecontroldirective."', '".$cachecontrolvalue."', '".$resp_cachecontroldirective."', '".$resp_cachecontrolvalue."', '".$pragma."', '".$resp_pragma."', '".$expires."', '".$age."', '".$lastmodified."', '".$host."')");
    }
    mysqli_close($con);
?>