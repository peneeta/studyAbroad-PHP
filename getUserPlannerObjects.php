<?php
session_start();
require 'connect.php';
header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');

$getdata = $_GET['str'];


if(isset($getdata) && !empty($getdata)){
    $request = json_decode($getdata);

    $userEmail = mysqli_real_escape_string($con, trim($request->email));


    //handle all possible cases of entries and the proper SQL code
    $sql = "SELECT * FROM planner WHERE email='$userEmail'";

    if($result = mysqli_query($con, $sql)){
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            // echo json_encode($row);
            $rows[] = $row; //add each row found into array
        }
        echo json_encode($rows);;     
    }
    else{
        echo mysqli_error($con);
        echo json_encode(false);
        http_response_code(404);
        
    }

}
?>