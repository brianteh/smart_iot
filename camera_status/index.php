<?php
include "../connection.php"; 
$data = json_decode(file_get_contents('php://input'), true); //convert json form post to readable array in php
$update_sql = "UPDATE location SET camera_ip=?
        WHERE location_id=?";

$statement = $con->prepare($update_sql);
$statement->bind_param('si',$data['camera_ip'],$data['location_id']);// s->string, d->double,i-> integer/boolean 
$updating = $statement->execute() or die("<b>Error:</b> Problem on Updating<br/>" . mysqli_connect_error());
if($updating){
    echo " | Camera IP updated successfully! |\n";
}
