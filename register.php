<?php
 

/**
 * Description of register
 *
 * @author Farhan
 */

if(isset($_REQUEST["registerfromapp"])){
    $email=$_REQUEST["email"];
    $password=$_REQUEST["pwd"];
    $username=$_REQUEST["username"];
    
    
    $email= str_replace("\"", "\\\"", $email);
    $email= str_replace("'", "\\'", $email);
    $password= str_replace("\"", "\\\"", $password);
    $password= str_replace("'", "\\'", $password);
    
    
    
    include 'dbconnect.php';
    
    $sql = "INSERT INTO users (`user_name`,`email_id`,`password`) VALUES('$username','$email','$password');";


    if ($conn->query($sql) === TRUE) {

        $id = mysqli_insert_id($conn);
		
		$result=$conn->query("SELECT * FROM users WHERE `user_id`='$id';");
    
    $row_cnt = $result->num_rows;
    $row = $result->fetch_row();
    if($row_cnt>=1){
        $a=array("success"=>"yes","returnId"=>$row[0],"email"=>$row[2],"username"=>$row[1],"photo_link"=>$row[4]);
        echo json_encode($a);
		}else {
        $a = array("success" => "no");
        echo json_encode($a);
        //echo "Error: " . $sql . "<br>" . $conn->error;
    }
    } else {
        $a = array("success" => "no");
        echo json_encode($a);
        //echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
else{
    echo "Don't try to hack..!!";
}