<?php include "connection.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body{
            background-color: #1c1c1c;
        }
        .container{
            border-radius: 25px;
            border: none;
            color: white;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            font-family: monospace;
            margin: 10px;
        }
        .online{
            background: linear-gradient(45deg, #51adba, #03587a);
            border-radius: 25px;
            border: none;
            color: white;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            font-family: monospace;
            margin: 10px;
        }
        .offline{
            background: linear-gradient(45deg, #a83246,#a83232);
            border-radius: 25px;
            border: none;
            color: white;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            font-family: monospace;
            margin: 10px;
        }
        #info{
            padding: 10px;
        }
        .alert_false{
            background: linear-gradient(45deg, #6ffc03, #7dba04);
            border-radius: 10px;
            border: solid #03587a 5px;
            padding:20px;
        }
        .alert_true{
            background: linear-gradient(45deg, #ba6451, #d11024);
            border-radius: 10px;
            border: solid #03587a 5px;
            padding:20px;
        }
        .graph{
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>
<body>
    <div id="root"></div>
    
    
      
        <script>
            let root = document.getElementById('root');
            let chartInstances={};
            function update_user_data(){
                let request=new XMLHttpRequest();
                let url="grab_user_data.php";
                request.open("POST",url,true);
                request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                let $POST="";
                request.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        let data = JSON.parse(this.responseText);
                        let num = data.length;
                        //data_list[data[0]['user_id']].push(data[0]['hr_data']);
                        if(!root.firstChild){
                            for(let i=0;i<num;i++){

                                let container = document.createElement('div');
                                container.className="container";
                                if(data[i]['online_status']==1){
                                    container.className ='online';
                                }else{
                                    container.className ='offline';
                                }
                                container.id=`container${i}`;

                                let user_info = document.createElement('div');
                                user_info.id = `user_info${i}`;
                                let user_id = document.createElement('span');
                                let user_name = document.createElement('span');
                                user_id.innerHTML = "User ID"+" : "+data[i]["user_id"];
                                user_name.innerHTML = "Username"+" : "+data[i]["user_name"];
                                user_id.id = `user_id${i}`;
                                user_name.id = `user_name${i}`;
                                user_info.appendChild(user_id);
                                user_info.appendChild(document.createElement("br"));
                                user_info.appendChild(user_name);

                                let alert_info = document.createElement('div');
                                alert_info.id = `alert_info${i}`;
                                if(data[i]['panic_status']  == 1){
                                    alert_info.className="alert_true";
                                }else{
                                    alert_info.className="alert_false"; 
                                }
                                let panic_desc = document.createElement('span');
                                panic_desc.innerHTML = "Panic Mode"+" : "+data[i]['panic_desc'];
                                panic_desc.id = `panic_desc${i}`;
                                alert_info.appendChild(panic_desc);

                                let fall_info = document.createElement('div');
                                let fall_desc = document.createElement('span');
                                fall_info.id = `fall_info${i}`;
                                fall_desc.id=`fall_desc${i}`;
                                if(data[i]['fall_status']==1){
                                    fall_info.className="alert_true";
                                    fall_desc.innerHTML = 'Fall Status';
                                }else{
                                    fall_info.className="alert_false"; 
                                    fall_desc.innerHTML = 'Fall Status';
                                    
                                }
                                
                                fall_info.appendChild(fall_desc);
                                 
                                 

                                let location_info = document.createElement('div');
                                location_info.id = `location_info${i}`;
                                let location_name = document.createElement('span');
                                location_name.innerHTML = "Location"+" : "+data[i]['location_name'];
                                location_name.id = `location_name${i}`;
                                location_info.appendChild(location_name);

                                let walk_info = document.createElement('div');
                                walk_info.id = `walk_info${i}`;
                                let steps = document.createElement('span');
                                steps.innerHTML = "Steps Taken"+" : "+data[i]['steps'];
                                steps.id = `steps${i}`;
                                walk_info.appendChild(steps);


                                let canvas = document.createElement('canvas');
                                canvas.id = data[i]['user_id'];

                                const ctx = canvas.getContext("2d");
                                const myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: ['','','','','','','','','',''],
                                    datasets: [{
                                    label: 'Heart Rate',
                                    data: data[i]['hr_data'],
                                    borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                    }
                                }
                                });

                                chartInstances[data[i]['user_id']]=myChart;
                                

                                container.appendChild(user_info);
                                container.appendChild(alert_info);
                                container.appendChild(fall_info);
                                container.appendChild(location_info);
                                container.appendChild(walk_info);
                                container.appendChild(canvas);
                                root.appendChild(container);

                            }
                        }else if(root.childElementCount<num){
                            for(let i=0;i<root.childElementCount;i++){
                                
                                let container = document.getElementById(`container${i}`);
                                if(data[i]['online_status']==1){
                                    container.className ='online';
                                }else{
                                    container.className ='offline';
                                }

                                let user_id = document.getElementById(`user_id${i}`);
                                let user_name = document.getElementById(`user_name${i}`);
                                user_id.innerHTML= "User ID"+" : "+data[i]["user_id"];
                                user_name.innerHTML= "Username"+" : "+data[i]["user_name"];
                               
                                let alert_info = document.getElementById(`alert_info${i}`);
                                if(data[i]['panic_status']){
                                    alert_info.className="alert_true";
                                }else{
                                    alert_info.className="alert_false"; 
                                }

                                let panic_desc = document.getElementById(`panic_desc${i}`);
                                panic_desc.innerHTML = "Panic Mode"+" : "+data[i]['panic_desc'];

                                
                                let location_name = document.getElementById(`location_name${i}`);
                                location_name.innerHTML = "Location"+" : "+data[i]['location_name'];


                                let fall_info = document.getElementById(`fall_info${i}`);
                                let fall_desc = document.getElementById(`fall_desc${i}`);
                                if(data[i]['fall_status']==1){
                                    fall_info.className="alert_true";
                                    fall_desc.innerHTML = 'Fall Status';
                                }else{
                                    fall_info.className="alert_false"; 
                                    fall_desc.innerHTML = 'Fall Status ';
                                }

                                let steps = document.getElementById(`steps${i}`);
                                steps.innerHTML = "Steps Taken"+" : "+data[i]['steps'];

                                let canvas =document.getElementById(data[i]['user_id']);
                                // Chart settings
                                chartInstances[data[i]['user_id']].config.data.datasets[0].data = data[i]['hr_data'];
                                chartInstances[data[i]['user_id']].update();
                                
                                
                            }
                            for(let i=root.childElementCount;i<num;i++){

                                let container = document.createElement('div');
                                container.className="container";
                                if(data[i]['online_status']==1){
                                    container.className ='online';
                                }else{
                                    container.className ='offline';
                                }
                                container.id=`container${i}`;

                                let user_info = document.createElement('div');
                                user_info.id = `user_info${i}`;
                                let user_id = document.createElement('span');
                                let user_name = document.createElement('span');
                                user_id.innerHTML = "User ID"+" : "+data[i]["user_id"];
                                user_name.innerHTML = "Username"+" : "+data[i]["user_name"];
                                user_id.id = `user_id${i}`;
                                user_name.id = `user_name${i}`;
                                user_info.appendChild(user_id);
                                user_info.appendChild(document.createElement("br"));
                                user_info.appendChild(user_name);

                                let alert_info = document.createElement('div');
                                alert_info.id = `alert_info${i}`;
                                if(data[i]['panic_status']  == 1){
                                    alert_info.className="alert_true";
                                }else{
                                    alert_info.className="alert_false"; 
                                }
                                let panic_desc = document.createElement('span');
                                panic_desc.innerHTML = "Panic Mode"+" : "+data[i]['panic_desc'];
                                panic_desc.id = `panic_desc${i}`;
                                alert_info.appendChild(panic_desc);

                                let fall_info = document.createElement('div');
                                let fall_desc = document.createElement('span');
                                fall_desc.id=`fall_desc${i}`;
                                fall_info.id = `fall_info${i}`;
                                if(data[i]['fall_status']==1){
                                    fall_info.className="alert_true";
                                    fall_desc.innerHTML = 'Fall Status ';
                                }else{
                                    fall_info.className="alert_false"; 
                                    fall_desc.innerHTML = 'Fall Status ';
                                    
                                }
                                
                                fall_info.appendChild(fall_desc);

                                let location_info = document.createElement('div');
                                location_info.id = `location_info${i}`;
                                let location_name = document.createElement('span');
                                location_name.innerHTML = "Location"+" : "+data[i]['location_name'];
                                location_name.id = `location_name${i}`;
                                location_info.appendChild(location_name);

                                
                                let walk_info = document.createElement('div');
                                walk_info.id = `walk_info${i}`;
                                let steps = document.createElement('span');
                                steps.innerHTML = "Steps Taken"+" : "+data[i]['steps'];
                                steps.id = `steps${i}`;
                                walk_info.appendChild(steps);

                                
                               



                                let canvas = document.createElement('canvas');
                                canvas.id = data[i]['user_id'];
                                const ctx = canvas.getContext("2d");
                                const myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: ['','','','','','','','','',''],
                                    datasets: [{
                                    label: 'Heart Rate',
                                    data: data[i]['hr_data'],
                                    borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                    }
                                }
                                });

                                chartInstances[data[i]['user_id']]=myChart;
                               
                           
                                
                                
                                    
                                container.appendChild(user_info);
                                container.appendChild(alert_info);
                                container.appendChild(fall_info);
                                container.appendChild(location_info);
                                container.appendChild(walk_info);
                                container.appendChild(canvas);
                                root.appendChild(container);
                            }
                        }else{
                            for(let i=0;i<num;i++){

                                let container = document.getElementById(`container${i}`);
                                if(data[i]['online_status']==1){
                                    container.className ='online';
                                }else{
                                    container.className ='offline';
                                }

                                let user_id = document.getElementById(`user_id${i}`);
                                let user_name = document.getElementById(`user_name${i}`);
                                user_id.innerHTML= "User ID"+" : "+data[i]["user_id"];
                                user_name.innerHTML= "Username"+" : "+data[i]["user_name"];
                               
                                let alert_info = document.getElementById(`alert_info${i}`);
                                if(data[i]['panic_status'] == 1){
                                    alert_info.className="alert_true";
                                }else{
                                    alert_info.className="alert_false"; 
                                }

                                let panic_desc = document.getElementById(`panic_desc${i}`);
                                panic_desc.innerHTML = "Panic Mode"+" : "+data[i]['panic_desc'];

                                
                                let location_name = document.getElementById(`location_name${i}`);
                                location_name.innerHTML = "Location"+" : "+data[i]['location_name'];

                                
                                let fall_info = document.getElementById(`fall_info${i}`);
                                let fall_desc = document.getElementById(`fall_desc${i}`);
                                if(data[i]['fall_status']==1){
                                    fall_info.className="alert_true";
                                    fall_desc.innerTHML="Fall Status ";
                                }else{
                                    fall_info.className="alert_false"; 
                                    fall_desc.innerHTML="Fall Status ";
                                }
                                

                                let steps = document.getElementById(`steps${i}`);
                                steps.innerHTML = "Steps Taken"+" : "+data[i]['steps'];


                                let canvas =document.getElementById(data[i]['user_id']);
                                // Chart settings
                            
                                chartInstances[data[i]['user_id']].config.data.datasets[0].data = data[i]['hr_data'];
                                chartInstances[data[i]['user_id']].update();
                                
                                

                            }
                        }
                        
                    }
                }
                request.send($POST);
            }
            setInterval(update_user_data,200);
        </script>
        
        
    </div>
    <div id="camera_footages">
        <?php 
            $camera_sql= "SELECT * FROM location";
            $camera_grab = mysqli_query($con,$camera_sql);
            while($row=mysqli_fetch_array($camera_grab)){
            
                $ipAddress = $row['camera_ip']; // Replace with the IP address you want to check
                $port = 80; // Port to check (e.g., 80 for HTTP)
                
                // Attempt to open a socket connection
                $socket = @fsockopen($ipAddress, $port, $errno, $errstr, 1);
                
                // Check if the socket was successfully opened
                if ($socket) {
                    fclose($socket); // Close the socket
        ?>  
        <br>
                <div id="camera_frame" style="padding:20px;">
                    <label for="" style="font-size:1.5rem;color:white;font-family:monospace;">Location: <?php echo $row['location_name'];?></label><br>
                    <img style="display: block;-webkit-user-select: none;margin: auto;background-color: hsl(0, 0%, 25%);" src='<?php echo "http://".$row['camera_ip'];?>'>
                </div>
        <br>
        <?php
                }else {
        ?>

        <?php            
                }
            } 
        ?>
    </div>
    
    <script>
        function uniqid() {
        // Generate a random number and convert it to a base36 string
            const randomPart = Math.random().toString(36).substr(2, 9);

        // Get the current timestamp in milliseconds
            const timestamp = new Date().getTime().toString(36);

        // Combine the random part and timestamp to create a unique ID
            const uniqueId = randomPart + timestamp;

            return uniqueId;
        }
        
        

        const socket = new WebSocket('ws://'+window.location.hostname+':12345');
        socket.addEventListener("open", (e)=>{
            socket.send(JSON.stringify({
                client_type:1,
                auth_id:uniqid()
            }));
        });
       

        
            
    </script>
</body>
</html>