<?php
if (isset($_REQUEST["uploadimage"])) {

    $userid = $_REQUEST["user_id"];
	$postid = $_REQUEST["post_id"];
	
	error_reporting(E_ALL ^ E_STRICT);
	
	function uploadImage($conn,$userid,$postid) {
        $dir="post_images/";
        
            $xx=$_FILES["image"]["name"];
            $ext = end(explode(".", $xx));
            $filename = md5($xx). date("YmdHis");
            $newfilename = $filename . "." . $ext;
            
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $dir . $newfilename)){
                $sql="INSERT INTO `images`(`user_id`, `post_id`, `image_url`) VALUES ('$userid','$postid','$dir$newfilename')";
                if ($conn->query($sql) === TRUE) {
                    $a = array("success" => "yes");
					echo json_encode($a);
				} else {
					$a = array("success" => "no","error"=>$conn->error);
					echo json_encode($a);
				}
            }   
    }
	
    include 'dbconnect.php';

	uploadImage($conn,$userid,$postid);
	
    $conn->close();
} else {
    echo "Don't try to hack..!!";
}
