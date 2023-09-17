<?php
include "../connection.php";
$data = json_decode(file_get_contents('php://input'), true); //convert json form post to readable array in php

$search_sql ="SELECT location_id FROM location WHERE location_side = '".$data['location_id']."' OR location_front = '".$data['location_id']."'";
$searching = mysqli_query($con,$search_sql);

if(mysqli_num_rows($searching)>0){
    $row = mysqli_fetch_assoc($searching);
    $update_sql = "UPDATE user SET location_id=?
            WHERE user_id=?";

    $statement = $con->prepare($update_sql);
    $statement->bind_param('ss',$row['location_id'],$data['auth_id']);// s->string, d->double,i-> integer/boolean 
    $updating = $statement->execute() or die("<b>Error:</b> Problem on Updating<br/>" . mysqli_connect_error());
    if($updating){
        echo " | Location updated successfully! |\n";
    }

}else{
    echo " | Error |\n";
}
