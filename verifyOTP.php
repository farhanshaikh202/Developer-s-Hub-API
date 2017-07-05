<?php

if (isset($_REQUEST["verifyemail"])) {
    $to = $_REQUEST["email"];
    $name = $_REQUEST["username"];
    $subject = "Confirm registeration for Developer's Hub";


    include 'dbconnect.php';
    $result = $conn->query("SELECT user_id FROM users WHERE `email_id`='$to';");
    $row_cnt = $result->num_rows;
    
    if($row_cnt>=1){
        $a = array("success" => "no", "error" => "1");//acc alreasy exist
        echo json_encode($a);
    } else {
        $digits_needed = 6;
        $random_number = ''; // set up a blank string
        $count = 0;
        while ($count < $digits_needed) {
            $random_digit = mt_rand(0, 9);
            $random_number .= $random_digit;
            $count++;
        }

        $message = "<h2>Hi $name,</h2><h3>Welcome to Developer's Hub</h3>";
        $message .= "Just one more step to get ready.<br/>Kindly confirm your registeration to enable your account.<br/><br/>Enter following OTP into Developer's Hub App";
        $message .= "<h1>$random_number</h1>";
        $message .= "<br/><br/>Regards,<br/><b>Developer's Hub</b>";


        $header = "From:service@developers-hub.pe.hu \r\n";
        
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";


        $retval = mail($to, $subject, $message, $header);


        if ($retval == true) {
            $a = array("success" => "yes", "otp" => "$random_number");
            echo json_encode($a);
        } else {
            $a = array("success" => "no","error"=>"2");//mail not sent
            echo json_encode($a);
        }
    }

    $conn->close();
}