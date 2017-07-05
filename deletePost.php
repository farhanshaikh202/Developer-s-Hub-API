<?php

if (isset($_REQUEST["deletepost"])) {

    $postid = $_REQUEST["post_id"];



    include 'dbconnect.php';


    $sql = "DELETE FROM posts WHERE post_id=$postid";
    if ($conn->query($sql) === TRUE) {
      
		$sql = "DELETE FROM images WHERE post_id=$postid";
    if ($conn->query($sql) === TRUE) {
       
        $sql = "DELETE FROM comments WHERE post_id=$postid";
		$conn->query($sql);
		
		$sql = "DELETE FROM likes WHERE post_id=$postid";
		$conn->query($sql);
		
		$sql = "DELETE FROM ratings WHERE post_id=$postid";
		
    if ($conn->query($sql) === TRUE) {
       
        $a = array("success" => "yes");
        echo json_encode($a);
    } else {
        $a = array("success" => "no","error"=>$conn->error);
        echo json_encode($a);
    }
    } else {
        $a = array("success" => "no","error"=>$conn->error);
        echo json_encode($a);
    }
    } else {
        $a = array("success" => "no","error"=>$conn->error);
        echo json_encode($a);
    }

	
    $conn->close();
} else {
    echo "Don't try to hack..!!";
}