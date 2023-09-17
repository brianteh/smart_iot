<?php
include "../connection.php";
$data = json_decode(file_get_contents('php://input'), true); //convert json form post to readable array in php


$search_sql ="SELECT * FROM walk_record WHERE date=CURRENT_DATE() AND user_id = '".$data['auth_id']."'";
$searching = mysqli_query($con,$search_sql);

if(mysqli_num_rows($searching)>0){
    $row = mysqli_fetch_assoc($searching);
    $update_sql = "UPDATE walk_record SET steps=steps+1
            WHERE user_id=?";

    $statement = $con->prepare($update_sql);
    $statement->bind_param('s',$data['auth_id']);// s->string, d->double,i-> integer/boolean 
    $updating = $statement->execute() or die("<b>Error:</b> Problem on Updating<br/>" . mysqli_connect_error());
    if($updating){
        echo " | Walk updated successfully! |\n";
    }

}else{
    $sql = "INSERT INTO walk_record(user_id,steps,date) 
        VALUES(?,1,CURRENT_DATE())";
    
    $statement = $con->prepare($sql);
    $statement->bind_param('s',$data["auth_id"]);// s->string, d->double,i-> integer/boolean 
    $upload_record = $statement->execute() or die("<b>Error:</b> Problem on Recording<br/>" . mysqli_connect_error());
    if($upload_record){
        echo " | Walk record successfully! |\n";
    }
    
}