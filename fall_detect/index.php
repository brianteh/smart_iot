<?php
include "../connection.php"; 
$data = json_decode(file_get_contents('php://input'), true); //convert json form post to readable array in php

$search_sql ="SELECT location_id FROM location WHERE location_side = '".$data['location_id']."' OR location_front = '".$data['location_id']."'";
$searching = mysqli_query($con,$search_sql);

if(mysqli_num_rows($searching)>0){
    $row = mysqli_fetch_assoc($searching);
    $sql = "INSERT INTO fall_record(user_id,timestamp,location_id) 
        VALUES(?,now(),?)";
    
    $statement = $con->prepare($sql);
    $statement->bind_param('ss',$data["auth_id"],$row["location_id"]);// s->string, d->double,i-> integer/boolean 
    $upload_record = $statement->execute() or die("<b>Error:</b> Problem on Recording<br/>" . mysqli_connect_error());
    if($upload_record){
        echo " | Fall record successfully! |\n";
    }
    $sql = "UPDATE user SET fall_status=1 WHERE user_id =?"; 
        
    
    $statement = $con->prepare($sql);
    $statement->bind_param('s',$data["auth_id"]);// s->string, d->double,i-> integer/boolean 
    $upload_record = $statement->execute() or die("<b>Error:</b> Problem on Recording<br/>" . mysqli_connect_error());
    if($upload_record){
        echo " | Fall update successfully! |\n";
    }
}else if(mysqli_num_rows($searching)==0){
    $sql = "INSERT INTO fall_record(user_id,timestamp,location_id) 
        VALUES(?,now(),1)";
    
    $statement = $con->prepare($sql);
    $statement->bind_param('s',$data["auth_id"]);// s->string, d->double,i-> integer/boolean 
    $upload_record = $statement->execute() or die("<b>Error:</b> Problem on Recording<br/>" . mysqli_connect_error());
    if($upload_record){
        echo " | Fall record successfully! |\n";
    }
    
}
