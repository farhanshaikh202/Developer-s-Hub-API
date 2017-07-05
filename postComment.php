<?php

if (isset($_REQUEST["postcomment"])) {

    $userid = $_REQUEST["userid"];
    $postid = $_REQUEST["postid"];
    $rate = $_REQUEST["rating"];
    $comment = $_REQUEST["comment"];
    $comment= str_replace("\"", "\\\"", $comment);
    $comment= str_replace("'", "\\'", $comment);


    include 'dbconnect.php';

	$result=$conn->query("SELECT * FROM ratings WHERE `user_id`='$userid' AND `post_id`='$postid';");
  
    $row_cnt = $result->num_rows;
    if($row_cnt>=1){
			    $sql = "DELETE FROM ratings WHERE `user_id`='$userid' AND `post_id`='$postid';";

    if ($conn->query($sql) === TRUE) {} 
	    $sql = "DELETE FROM comments WHERE `user_id`='$userid' AND `post_id`='$postid';";

    if ($conn->query($sql) === TRUE) {}
	}
    //first add rating than comment
    $sql = "INSERT INTO ratings (user_id,post_id,rating_no) VALUES($userid,$postid,$rate)";
    if ($conn->query($sql) === TRUE) {
        $id = mysqli_insert_id($conn);
        $sql = "INSERT INTO comments (user_id,post_id,rate_id,comment_text) VALUES($userid,$postid,$id,'$comment')";
        if ($conn->query($sql) === TRUE) {
            $id = mysqli_insert_id($conn);
            $a = array("success" => "yes");
            echo json_encode($a);
        } else {
            $a = array("success" => "no","error"=>$conn->error);
            echo json_encode($a);
            //echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $a = array("success" => "yes");
        echo json_encode($a);
    } else {
        $a = array("success" => "no","error"=>$conn->error);
        echo json_encode($a);
        //echo "Error: " . $sql . "<br>" . $conn->error;
    }

	
    $conn->close();
} else {
    echo "Don't try to hack..!!";
}