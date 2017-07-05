<?php

if(isset($_REQUEST["loginfromapp"]))
{
    $email=$_REQUEST["email"];
    $pass=$_REQUEST["pwd"];
    $email= str_replace("\"", "\\\"", $email);
    $email= str_replace("'", "\\'", $email);
    $pass= str_replace("\"", "\\\"", $pass);
    $pass= str_replace("'", "\\'", $pass);
    
    include 'dbconnect.php';
    $result=$conn->query("SELECT * FROM users WHERE `email_id`='$email' AND password='$pass';");
    //$row=mysqli_fetch_array($result);
    $row_cnt = $result->num_rows;
    $row = $result->fetch_row();
    if($row_cnt>=1){
        $a=array("success"=>"yes","returnId"=>$row[0],"email"=>$row[2],"username"=>$row[1],"photo_link"=>$row[4]);
        echo json_encode($a);
    }else{
        $a=array("success"=>"no");
        echo json_encode($a);
    }
    
    $conn->close();
}
else{
    echo "Don't try to hack..!!";
}