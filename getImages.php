<?php

if (isset($_REQUEST["postid"])) {

    $postid = $_REQUEST["postid"];
    include 'dbconnect.php';

    $sql = "SELECT * FROM images WHERE post_id=$postid";

    $myArray = array();
    if ($result = $conn->query($sql)) {

        while($row = $result->fetch_array(MYSQL_ASSOC)){
            $myArray[] = $row;
        }
        $result->close();
    }
    
    echo json_encode($myArray);
    $conn->close();
    
} else {
    echo "Don't try to hack..!!";
}