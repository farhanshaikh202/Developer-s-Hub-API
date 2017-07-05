<?php

if (isset($_REQUEST["rename"])) {
    $to = $_REQUEST["email"];
	$name=$_REQUEST["name"];
	

    include 'dbconnect.php';
    
        
        if ($result = $conn->query("UPDATE users SET user_name='$name' WHERE `email_id`='$to';")) {
            			
			$a = array("success" => "yes");
			echo json_encode($a);
            
        }
		else {
                $a = array("success" => "no", "error" => "1"); // rename fail
                echo json_encode($a);
            }
			
    $conn->close();
}