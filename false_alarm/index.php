<?php
include "../connection.php";
$data = json_decode(file_get_contents('php://input'), true); //convert json form post to readable array in php

$update_sql = "UPDATE user SET panic_status=0, panic_id = 0
            WHERE user_id=?";

$statement = $con->prepare($update_sql);
$statement->bind_param('s',$data["auth_id"]);// s->string, d->double,i-> integer/boolean 
$updating = $statement->execute() or die("<b>Error:</b> Problem on Updating<br/>" . mysqli_connect_error());
if($updating){
    echo " | False Alarm! |\n";
}