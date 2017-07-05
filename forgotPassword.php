<?php

if (isset($_REQUEST["forgotpwd"])) {
    $to = $_REQUEST["email"];
    $name = "";
    $subject = "Password for Developer's Hub";


    include 'dbconnect.php';
    $result = $conn->query("SELECT user_name FROM users WHERE `email_id`='$to';");
    $row_cnt = $result->num_rows;
	$row = $result->fetch_row();
            $name = $row[0];

    if ($row_cnt >= 1) {

        $pwd="none";
        
        if ($result = $conn->query("SELECT password FROM users WHERE `email_id`='$to';")) {
            $row = $result->fetch_row();
            $pwd = $row[0];
            //echo print_r($result);
            $result->close();


            $message = "<h2>Hi $name,</h2>";
            $message .= "Following is your password";
            $message .= "<h3>$pwd</h3>";
            $message .= "<br/><br/><small>If you didn't request for password, kindly ignore this email, Your Account is safe</small><br/><br/>Regards,<br/><b>Developer's Hub</b>";


            $header = "From:service@developers-hub.pe.hu \r\n";
            //$header .= "Cc:afgh@somedomain.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $message, $header);

            if ($retval == true) {
                $a = array("success" => "yes");
                echo json_encode($a);
            } else {
                $a = array("success" => "no", "error" => "2"); //mail not sent
                echo json_encode($a);
            }
        }
    }else {
                $a = array("success" => "no", "error" => "1"); // email not found
                echo json_encode($a);
            }

    $conn->close();
}