<?php

if (isset($_REQUEST["postid"])) {

    $postid = $_REQUEST["postid"];
    include 'dbconnect.php';

    $sql = "SELECT c.*,u.user_name,u.photo_link,(SELECT rating_no FROM ratings WHERE post_id=$postid AND user_id=c.user_id) as rating FROM comments c, users u WHERE c.post_id=$postid AND u.user_id=c.user_id ";

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