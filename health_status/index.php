<?php
include "../connection.php";
$data = json_decode(file_get_contents('php://input'), true); //convert json form post to readable array in php

$search_sql ="SELECT location_id FROM location WHERE location_side = '".$data['location_id']."' OR location_front = '".$data['location_id']."'";
$searching = mysqli_query($con,$search_sql);

if(mysqli_num_rows($searching)>0){
    $row = mysqli_fetch_assoc($searching);
    $sql = "INSERT INTO hr_record(user_id,hr_rate,timestamp,location_id) 
        VALUES(?,?,now(),?)";
    
    $statement = $con->prepare($sql);
    $statement->bind_param('sis',$data["auth_id"],$data["hr"],$row["location_id"]);// s->string, d->double,i-> integer/boolean 
    $upload_record = $statement->execute() or die("<b>Error:</b> Problem on Recording<br/>" . mysqli_connect_error());
    if($upload_record){
        echo " | Heart rate record successfully! |\n";
    }
}else{
    echo " | Error |\n";
}
