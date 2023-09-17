<?php
include "../connection.php";
$data = json_decode(file_get_contents('php://input'), true); //convert json form post to readable array in php
$update_sql = "UPDATE user SET panic_id=?,panic_status=1
            WHERE user_id=?";

$statement = $con->prepare($update_sql);
$statement->bind_param('is',$data["panic_id"],$data["auth_id"]);// s->string, d->double,i-> integer/boolean 
$updating = $statement->execute() or die("<b>Error:</b> Problem on Updating<br/>" . mysqli_connect_error());
if($updating){
    echo " | Panic Alert! |\n";
}

$insert_sql = "INSERT INTO panic_record(panic_id,user_id,date) VALUES( panic_id=?,user_id=?,now())";

$insert_statement = $con->prepare($insert_sql);
$insert_statement->bind_param('is',$data["panic_id"],$data["auth_id"]);// s->string, d->double,i-> integer/boolean 
$inserting = $insert_statement->execute() or die("<b>Error:</b> Problem on Updating<br/>" . mysqli_connect_error());
if($inserting){
    echo " | Panic record successfully! |\n";
}