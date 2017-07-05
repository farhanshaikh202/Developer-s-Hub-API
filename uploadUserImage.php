<?php
 
include 'dbconnect.php';
if(isset($_REQUEST['image'])){
// Path to move uploaded files
$target_path = "user_photo/";
 $root=$target_path;
// array for final json respone
$response = array();
 
// getting server ip address
//$server_ip = gethostbyname(gethostname());
 
// final file url that is being uploaded
$file_upload_url = 'http://developers-hub.pe.hu/api/'. $target_path;
 
 
if (isset($_FILES['image']['name'])) {
    
 
    // reading other post parameters
    $number = isset($_POST['uid']) ? $_POST['uid'] : '';
    $email=$_REQUEST['email'];

    $fileName="PIC_".$number."_".time()."_".basename($_FILES['image']['name']);
    $target_path=$target_path.$fileName;
    $response['file_name'] = $fileName;
    
 
    try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }else{
		
        // File successfully uploaded
        $response['message'] = 'File uploaded successfully!';
        
        $response['url'] = $file_upload_url . $fileName;
        $url=$response['url'];

         if ($result = $conn->query("UPDATE users SET photo_link='$url' WHERE email_id='$email';")){
		 $response['error'] = false;
		 }
        } 
    } catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }
} else {
    // File parameter is missing
    $response['error'] = true;
    $response['message'] = 'Not received any file!F';
}
 
// Echo final json response to client
echo json_encode($response);

}
?>