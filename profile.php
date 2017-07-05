<?php

if (isset($_REQUEST["user_id"])) {

    $userid = $_REQUEST["user_id"];
    include 'dbconnect.php';
    
    if ($result = $conn->query("SELECT user_name,photo_link,
(SELECT COUNT(*) FROM posts WHERE user_id=$userid) AS posts,
(SELECT COUNT(*) FROM profile_likes WHERE user_id=$userid) AS followers,
(SELECT COUNT(*) FROM profile_likes WHERE liker_id=$userid) AS following FROM users WHERE user_id=$userid;")) {
        $myArray = array();
        while ($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = $row;
			break;
        }
		
		if(isset($_REQUEST["liker"])){
		$liker=$_REQUEST["liker"];
		$result=$conn->query("SELECT * FROM profile_likes WHERE `user_id`='$userid' AND `liker_id`='$liker';");
  
    $row_cnt = $result->num_rows;
    if($row_cnt>=1){
	$myArray[1]=array("following"=>"yes");
	}else{
		$myArray[1]=array("following"=>"no");
	}
	
	}
        echo json_encode($myArray);
        $result->close();
    }
    $conn->close();
    
} else {
    echo "Don't try to hack..!!";
}
