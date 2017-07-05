<?php

if (isset($_REQUEST["changepwd"])) {
    $to = $_REQUEST["email"];
	$oldpwd=$_REQUEST["oldpwd"];
	$newpwd=$_REQUEST["newpwd"];;
	$subject = "Password Changed for Developer's Hub";


    include 'dbconnect.php';
    $result = $conn->query("SELECT user_name FROM users WHERE `email_id`='$to' AND `password`='$oldpwd';");
    $row_cnt = $result->num_rows;
	$row = $result->fetch_row();
            $name = $row[0];


    if ($row_cnt >= 1) {
        
        if ($result = $conn->query("UPDATE users SET password='$newpwd' WHERE `email_id`='$to';")) {
            
			$message = "<h2>Hi $name,</h2>";
            $message .= "Your password has been changed successfully";
            $message .= "<br/>your new password is <h3>$newpwd</h3>";
            $message .= "<br/><br/><small>If that was not you, please change your password by using above password.</small><br/><br/>Regards,<br/><b>Developer's Hub</b>";


            $header = "From:service@developers-hub.pe.hu \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $message, $header);
			
			$a = array("success" => "yes");
			echo json_encode($a);
            
        }
		else {
                $a = array("success" => "no", "error" => "2"); // pwd change fail
                echo json_encode($a);
            }
    }else {
                $a = array("success" => "no", "error" => "1"); // email/pwd not match
                echo json_encode($a);
            }

    $conn->close();
}