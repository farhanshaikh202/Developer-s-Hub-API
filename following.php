<?php

if (isset($_REQUEST["userid"])) {

	$userid=$_REQUEST["userid"];
     
    include 'dbconnect.php';
	
    if ($result = $conn->query("SELECT u.user_id,user_name,photo_link,
(SELECT COUNT(*) FROM posts WHERE user_id=p.user_id) AS posts,
(SELECT COUNT(*) FROM profile_likes WHERE user_id=p.user_id) AS followers,
(SELECT COUNT(*) FROM profile_likes WHERE liker_id=p.user_id) AS following FROM users u , profile_likes p WHERE p.liker_id='$userid' AND u.user_id=p.user_id;")) {
        $myArray = array();
        while ($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = $row;
        }
		
        echo json_encode($myArray);
        $result->close();
    }
    $conn->close();
    
} else {
    echo "Don't try to hack..!!";
}
