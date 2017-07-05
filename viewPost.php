<?php

if (isset($_REQUEST["postid"])) {

    $postid = $_REQUEST["postid"];
	
    include 'dbconnect.php';

    $sql = "SELECT p.*,u.user_name,u.photo_link,c.*
	,(SELECT COUNT(*) FROM profile_likes WHERE user_id=u.user_id) as profile_likes
,    (SELECT COUNT(*) FROM likes WHERE post_id=p.post_id) as LIKE_COUNT
,    (SELECT COUNT(*) FROM comments WHERE post_id=p.post_id) as COMMENT_COUNT
,    (SELECT AVG(rating_no) FROM ratings WHERE post_id=p.post_id) as RATING
,    (SELECT image_url FROM images WHERE post_id=p.post_id LIMIT 1) as image_url 
FROM posts p,users u,categories c WHERE p.post_id=$postid AND u.user_id=p.user_id AND p.category_id=c.category_id ";

    $myArray = array();
    if ($result = $conn->query($sql)) {

        $row = $result->fetch_array(MYSQL_ASSOC);
            $myArray[0] = $row;
        
        
        $result->close();
    }

    // rate bars
    $sql = "SELECT (SELECT COUNT(*) FROM ratings WHERE post_id=$postid AND rating_no=5) as FIVE_STAR
,(SELECT COUNT(*) FROM ratings WHERE post_id=$postid AND rating_no=4) as FOUR_STAR
    ,(SELECT COUNT(*) FROM ratings WHERE post_id=$postid AND rating_no=3) as THREE_STAR
        ,(SELECT COUNT(*) FROM ratings WHERE post_id=$postid AND rating_no=2) as TWO_STAR
            ,(SELECT COUNT(*) FROM ratings WHERE post_id=$postid AND rating_no=1) as ONE_STAR ";

    if ($result = $conn->query($sql)) {

        $row = $result->fetch_array(MYSQL_ASSOC);
            $myArray[1] = $row;
        
        
        $result->close();
    }
	
	if (isset($_REQUEST["myid"])) {
	$myid = $_REQUEST["myid"];
	
	//does i liked it?
    $sql = "SELECT * FROM likes WHERE post_id=$postid AND user_id=$myid";
    $result = $conn->query($sql) ;
	$row_cnt = $result->num_rows;
    if($row_cnt>=1){
            $myArray[2] = array("liked"=>"yes");
    }else{
		$myArray[2] = array("liked"=>"no");
	}
        $result->close();
	
    
    //mycomment
	    $sql = "SELECT *,(SELECT rating_no FROM ratings WHERE post_id=$postid AND user_id=$myid) as rating FROM comments WHERE post_id=$postid AND user_id=$myid ";

    if ($result = $conn->query($sql)) {

        while($row = $result->fetch_array(MYSQL_ASSOC)){
            $myArray[3] = $row;
			break;
        }
        $result->close();
    }
	
	}

	
	
    echo json_encode($myArray);
    $conn->close();
    
} else {
    echo "Don't try to hack..!!";
}