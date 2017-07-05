<?php

if (isset($_REQUEST["user_id"])) {

    $userid = $_REQUEST["user_id"];
    include 'dbconnect.php';
    $sql = "SELECT comments.*,ratings.rating_no,users.user_name,users.photo_link FROM ratings ,users, comments WHERE ratings.rate_id = comments.rate_id AND comments.user_id =$userid AND comments.user_id=users.user_id ORDER BY timestamp DESC";
    
    if ($result = $conn->query($sql)) {
        $myArray = array();
        while ($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = $row;
        }
        echo json_encode($myArray);
        $result->close();
    }

    //$row=mysqli_fetch_array($result);
} else {
    echo "Don't try to hack..!!";
}
