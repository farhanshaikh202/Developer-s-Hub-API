<?php
 
if(isset($_REQUEST["likeprofile"])){
    
    $userid=$_REQUEST["userid"];
    $liker=$_REQUEST["likerid"];
     
    
    include 'dbconnect.php';
    
		$result=$conn->query("SELECT * FROM profile_likes WHERE `user_id`='$userid' AND `liker_id`='$liker';");
  
    $row_cnt = $result->num_rows;
    if($row_cnt>=1){//decreament
    $sql = "DELETE FROM profile_likes WHERE `user_id`='$userid' AND `liker_id`='$liker';";

    if ($conn->query($sql) === TRUE) {
        $a = array("success" => "yes","follow"=>"no");
        echo json_encode($a);
    } else {
        $a = array("success" => "no");
        echo json_encode($a);
    }
	
	}else{//increament
		    
			    $sql = "INSERT INTO profile_likes (user_id,liker_id) VALUES($userid,$liker)";


    if ($conn->query($sql) === TRUE) {
        $a = array("success" => "yes","follow"=>"yes");
        echo json_encode($a);
    } else {
        $a = array("success" => "no");
        echo json_encode($a);
    }
	
	}

    $conn->close();
}
else{
    echo "Don't try to hack..!!";
}