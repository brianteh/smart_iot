const WebSocket = require('ws');
const socket = new WebSocket.Server({port:12345});

//Database connection
let mysql = require('mysql');
let con = mysql.createConnection({
    host:"localhost",
    user:"root",
    password: "",
    database:"nursing_guardian"
});
con.connect((err)=>{
    if(err) throw err;
});

let data_list = {};

//Client data
class Clients{
    constructor(){
        this.client_type_1={};
        this.client_type_2={};
        this.saveClient_type_1 = this.saveClient_type_1.bind(this);
        this.saveClient_type_2 = this.saveClient_type_2.bind(this);
    }
    saveClient_type_1(auth_id, client){
        this.client_type_1[auth_id] = client;
    }
    saveClient_type_2(auth_id, client){
        this.client_type_2[auth_id] = client;
    }
}
const clients = new Clients(); 

// Socket Connection
socket.on("connection", (client) =>{
    
    console.log("Client connect!");
    client.send(Object.keys(clients.client_type_1).length);

    client.on("message",(data) =>{

        console.log(`${data}`);

        const parsedMsg = JSON.parse(data);

        if(parsedMsg.client_type==1){
            console.log("from type 1");
            if(clients.client_type_1[parsedMsg.auth_id] == undefined ){
                clients.saveClient_type_1(parsedMsg.auth_id,client);
            }
            for (let auth_id in clients.client_type_2) {
                clients.client_type_2[auth_id].send(Object.keys(clients.client_type_1).length);
            } 
        
        }else if(parsedMsg.client_type==2){
            console.log("from type 2");
            if(clients.client_type_2[parsedMsg.auth_id] == undefined ){
                clients.saveClient_type_2(parsedMsg.auth_id,client);
            }
            /*
            for (let auth_id in clients.client_type_1) {
                clients.client_type_1[auth_id].send(`${data}`);
            } 
            */
            let update_query = "UPDATE user SET online_status = ? WHERE user_id = ?";
            let update_val_arr = [1,parsedMsg.auth_id];
            con.query(update_query,update_val_arr,(err,res)=>{
                if(err) throw err;
            });
            
            let auth_id = parsedMsg.auth_id;

            if(data_list[auth_id] === undefined && parsedMsg.hr !== undefined){
                data_list[auth_id]=[];
                data_list[auth_id].push(parsedMsg.hr);
            }else if(parsedMsg.hr !== undefined){
                if(data_list[auth_id].length == 10){
                    let temp = data_list[auth_id];
                    data_list[auth_id]=[];
                    for(let i =0; i<9;i++){
                        data_list[auth_id][i]=temp[i+1];
                    }
                    data_list[auth_id].push(parsedMsg.hr);
                }else{
                    data_list[auth_id].push(parsedMsg.hr);
                }
                
            }
            if(data_list[auth_id] !== undefined){
                let jsonString = JSON.stringify(data_list[auth_id]);
                let search_sql = "SELECT user_id FROM hr_status WHERE user_id = ?";
                con.query(search_sql,[auth_id],(err,res)=>{
                    if(err) throw err;
                    if(res.length==0){
                        let insert_sql = "INSERT INTO hr_status(user_id,hr_data,valid_date) VALUES(?,?,now())";
                        let data_arr=[auth_id,jsonString];
                        con.query(insert_sql,data_arr,(err,res)=>{
                            if(err) throw err;
                        });
                    }else{
                        let update_sql = "UPDATE hr_status SET hr_data = ? , valid_date = now() WHERE user_id = ?";
                        let data_arr=[jsonString,auth_id];
                        con.query(update_sql,data_arr,(err,res)=>{
                            if(err) throw err;
                        });
                    }
                });
            }

        }
        
    });
    
    client.on("close",()=>{
        console.log("Client disconnect!");
        if(findKeyByValue(clients.client_type_1,client) !==null){
            let auth_id = findKeyByValue(clients.client_type_1,client);
            delete clients.client_type_1[auth_id];   
        }
        for (let auth_id in clients.client_type_2) {
            clients.client_type_2[auth_id].send(Object.keys(clients.client_type_1).length);
        } 

        if(findKeyByValue(clients.client_type_2,client) !==null){
            let auth_id = findKeyByValue(clients.client_type_2,client);

            let update_query = "UPDATE user SET online_status = ? WHERE user_id = ?";
            let update_val_arr = [0,auth_id];
            con.query(update_query,update_val_arr,(err,res)=>{
                if(err) throw err;
                delete clients.client_type_2[auth_id]; 
            });
              
        }
    });
});


//misc functions
function findKeyByValue(obj, targetValue) {
    for (const key in obj) {
      if (obj[key] === targetValue) {
        return key; // Return the key when a matching value is found
      }
    }
    return null; // Return null if the value is not found
}
  
