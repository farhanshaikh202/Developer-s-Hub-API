<?php
 

/**
 * Description of update
 *
 * @author Farhan
 */

if(isset($_REQUEST["updateprofile"])){
    
    $password=$_REQUEST["password"];
    $username=$_REQUEST["username"];
    $username= str_replace("\"", "\\\"", $username);
    $username= str_replace("'", "\\'", $username);
    $password= str_replace("\"", "\\\"", $password);
    $password= str_replace("'", "\\'", $password);
    
    
    include 'dbconnect.php';
    
    $sql = "UPDATE users SET `user_name`='$username',`password`='$password' WHERE `user_id`=$userid;";


    if ($conn->query($sql) === TRUE) {

        $id = mysqli_insert_id($conn);
        $a = array("success" => "yes");
        echo json_encode($a);
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