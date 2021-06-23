<?php
session_start();
require 'connect.php';
header('Access-Control-Allow-Origin: https://engineersabroad.uvacreate.virginia.edu'); //comment out when using localhost
//header('Access-Control-Allow-Origin: http://localhost:4200'); //comment out when using hosted server
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata)){
   
    $request = json_decode($postdata);

    $email = mysqli_real_escape_string($con, trim($request->email));
    $password = mysqli_real_escape_string($con, trim($request->password));

    $sql = "SELECT * FROM users where email='$email' and password='$password'";

    if($result = mysqli_query($con, $sql)){
        $rows = array();
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        $_SESSION['user'] = $email;
        if(count($rows)==0){ //if no user found then return false to frontend
            echo json_encode(false);
        }
        else{ //if user found send user data
            echo json_encode($rows);
        }
        
    }
    else{
        echo json_encode(false);
        http_response_code(404);
    }
}
?>