<?php 
    require 'connection.php';
    $state_data=array();
    $user_sql = "SELECT * FROM user";
    $user_grab = mysqli_query($con,$user_sql);
    while($row = mysqli_fetch_array($user_grab)){

        $i = new stdClass();

        $i->user_id = $row['user_id']; 
        $i->user_name = $row['user_name'];
        
        $i->panic_status = $row['panic_status'];
        $i->online_status = $row['online_status'];

        $panic_desc_sql = "SELECT panic_desc FROM panic WHERE panic_id = '".$row['panic_id']."';";
        $panic_desc_grab = mysqli_query($con,$panic_desc_sql);
        $panic_data = mysqli_fetch_assoc($panic_desc_grab);
        $i->panic_desc = $panic_data['panic_desc'];

        $location_name_sql = "SELECT location_name FROM location WHERE location_id = '".$row['location_id']."';";
        $location_name_grab = mysqli_query($con,$location_name_sql);
        $location_data = mysqli_fetch_assoc($location_name_grab);
        $i->location_name = $location_data['location_name'];

        $hr_data_sql = "SELECT hr_data,valid_date FROM hr_status WHERE user_id = '".$row['user_id']."'";
        $grab_hr_data = mysqli_query($con,$hr_data_sql);
       
        if(mysqli_num_rows($grab_hr_data)==0){
            $i->hr_data = [];
            $i->valid_date = null;
        }else{
            $data = mysqli_fetch_array($grab_hr_data);
            $i->hr_data = json_decode($data['hr_data']);
            $i->valid_date = $data['valid_date'];
        }

        $walk_sql = "SELECT steps FROM walk_record WHERE date = CURRENT_DATE() AND user_id = '".$row['user_id']."'";
        $walk_grab = mysqli_query($con,$walk_sql);
        if(mysqli_num_rows($walk_grab)==0){
            $i->steps=0;
        }else{
            $walk_data = mysqli_fetch_assoc($walk_grab);
            $i->steps=$walk_data['steps'];
        }

        $i->fall_status = $row['fall_status'];
        $state_data[]=$i;
    }
    
    echo json_encode($state_data);
?>