<?php
 
if(isset($_REQUEST["likepost"])){
    
    $userid=$_REQUEST["user_id"];
    $postid=$_REQUEST["post_id"];
     
    
    include 'dbconnect.php';
    
	$result=$conn->query("SELECT * FROM likes WHERE `user_id`='$userid' AND `post_id`='$postid';");
  
    $row_cnt = $result->num_rows;
    if($row_cnt>=1){//decreament
    $sql = "DELETE FROM likes WHERE `user_id`='$userid' AND `post_id`='$postid';";

    if ($conn->query($sql) === TRUE) {
        $a = array("success" => "yes","like"=>"dec");
        echo json_encode($a);
    } else {
        $a = array("success" => "no");
        echo json_encode($a);
    }
	
	}else{//increament
		    $sql = "INSERT INTO likes (user_id,post_id) VALUES($userid,$postid)";

    if ($conn->query($sql) === TRUE) {
        $a = array("success" => "yes","like"=>"inc");
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