<?php

if (isset($_REQUEST["createpost"])) {

    $userid = $_REQUEST["user_id"];
	$catid = $_REQUEST["category_id"];
	$ptitle = $_REQUEST["post_title"];
	$pdescription = $_REQUEST["post_description"];
	$durl = $_REQUEST["download_url"];
    
	$durl= str_replace("\"", "\\\"", $durl);
    $durl= str_replace("'", "\\'", $durl);
	$ptitle= str_replace("\"", "\\\"", $ptitle);
    $ptitle= str_replace("'", "\\'", $ptitle);
    $pdescription= str_replace("\"", "\\\"", $pdescription);
    $pdescription= str_replace("'", "\\'", $pdescription);


    include 'dbconnect.php';


    $sql = "INSERT INTO posts (user_id,category_id,post_title,post_description,download_url) VALUES($userid,$catid,'$ptitle','$pdescription','$durl')";
    if ($conn->query($sql) === TRUE) {
        $id = mysqli_insert_id($conn);
        $a = array("success" => "yes","id"=>$id);
        echo json_encode($a);
    } else {
        $a = array("success" => "no","error"=>$conn->error);
        echo json_encode($a);
    }

	
    $conn->close();
} else {
    echo "Don't try to hack..!!";
}