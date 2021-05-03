<?php 
require 'connect.php';

header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');


// get the size of incoming data
//$content_length = (int) $_SERVER['CONTENT_LENGTH'];

// retrieve data from the request
$postdata = file_get_contents("php://input");



// Process data
// (this example simply extracts the data and restructures them back)
if(isset($postdata)&&!empty($postdata)){
    // Extract json format to PHP array
    $request = json_decode($postdata);
    $name = mysqli_real_escape_string($con, trim($request->name));
    $email = mysqli_real_escape_string($con, trim($request->email));
    $password = mysqli_real_escape_string($con, trim($request->password));
    $requestedAdminAccess = $request->requestedAdminAccess;

    // default role entry is Student, admin must manually change status currently in database
    $roleDatabaseEntry = "Student";

 
    
    // add user to users table
    $sql = "INSERT INTO `users`(
        `name`, 
        `password`, 
        `email`
    ) VALUES (
        '{$name}',
        '{$password}',
        '{$email}'
    );";

    // add role for user to role table
    $sql2 = "INSERT INTO `roles`(
        `email`,
        `AuthorizationLevel`
    ) VALUES (
        '{$email}',
        '{$roleDatabaseEntry}'    
    );";

    // if user sent a admin request add to admin request table
    $requestDate = date("Y-m-d h:i:sa");

    $sql3 = "INSERT INTO `adminRequest`(
        `email`,
        `requestDate`
    ) VALUES (
        '{$email}',
        '{$requestDate}'    
    );";

    $combinedMultiQuery = "";
    if($requestedAdminAccess){
        $combinedMultiQuery = $sql.$sql2.$sql3;
    }
    else{
        $combinedMultiQuery = $sql.$sql2;
    }

    if(mysqli_multi_query ($con, $combinedMultiQuery) ){      
        http_response_code(201);
        echo json_encode(true);;     
    }
    else{
        http_response_code(422);
        echo json_encode("Error Creating Account");
    }
}


// $data = [];
// $data[0]['length'] = $content_length;
// foreach ($request as $k => $v)
// {
//   $data[0]['post_'.$k] = $v;
// }

// // // // Send response (in json format) back the front end
// echo json_encode(['content'=>$data]);
?>