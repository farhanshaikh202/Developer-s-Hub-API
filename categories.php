<?php

if (isset($_REQUEST["categories"])) {
    include 'dbconnect.php';
    
    if ($result = $conn->query("SELECT * FROM categories;")) {
        $myArray = array();
        while ($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = $row;
        }
        echo json_encode($myArray);
        $result->close();
    }
    $conn->close();
    //$row=mysqli_fetch_array($result);
} else {
    echo "Don't try to hack..!!";
}
