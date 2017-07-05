<?php

if (isset($_REQUEST["user_id"])) {

    $userid = $_REQUEST["user_id"];
    
    
    //i.e. 1,2,4,5,8
    $categories = $_REQUEST["categories"];
    $sorting="LIKE_COUNT";
    if(isset($_REQUEST["byrating"])){
        $sorting="RATING";
    }
    if(isset($_REQUEST["bylike"])){
        $sorting="LIKE_COUNT";
    }
    if(isset($_REQUEST["bytime"])){
        $sorting="timestamp";
    }
    $asc="";
    if(isset($_REQUEST["asc"])){
        $asc="ASC";
    } else {
        $asc="DESC";
    }
    $limit="LIMIT 0,9";
    if(isset($_REQUEST["lastpost"])){
        $no= intval($_REQUEST["lastpost"]);
        $limit="LIMIT $no,10";
    }
    
    include 'dbconnect.php';
    $sql = "SELECT p.*,u.user_name,u.photo_link,c.*
	,(SELECT COUNT(*) FROM profile_likes WHERE user_id=u.user_id) as profile_likes
,    (SELECT COUNT(*) FROM likes WHERE post_id=p.post_id) as LIKE_COUNT
,    (SELECT COUNT(*) FROM comments WHERE post_id=p.post_id) as COMMENT_COUNT
,    (SELECT AVG(rating_no) FROM ratings WHERE post_id=p.post_id) as RATING
,    (SELECT image_url FROM images WHERE post_id=p.post_id LIMIT 1) as image_url 
FROM posts p,users u,categories c WHERE p.category_id IN ($categories)  AND u.user_id=p.user_id AND p.user_id=$userid AND p.category_id=c.category_id ORDER BY $sorting $asc $limit";
    
	//echo $sql;
    if ($result = $conn->query($sql)) {
        $myArray = array();
        while ($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = $row;
        }
        echo json_encode($myArray);
        $result->close();
    }

    $conn->close();

} else {
    echo "Don't try to hack..!!";
}
