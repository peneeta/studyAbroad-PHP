<?php 
require 'connect.php';
header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
header('Access-Control-Max-Age: 1000');  
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');

// get the size of incoming data
//$content_length = (int) $_SERVER['CONTENT_LENGTH'];

// retrieve data from the request
$postdata = file_get_contents("php://input");

// Process data
// (this example simply extracts the data and restructures them back)
if(isset($postdata) && !empty($postdata)){
    // Extract json format to PHP array
    
    $request = json_decode($postdata, TRUE);

    $email = mysqli_real_escape_string($con, trim($request['email']));
    $program = mysqli_real_escape_string($con, trim($request['program']));
    $transferredCourses = mysqli_real_escape_string($con, trim($request['transferredCourses']));
    $country = mysqli_real_escape_string($con, trim($request['country']));
 

    $sql = "INSERT INTO `planner`(
        `email`, 
        `program`, 
        `transferredCourses`,
        `country`
    ) VALUES (
        '{$email}',
        '{$program}',
        '{$transferredCourses}',
        '{$country}'
    )";

    if(mysqli_query($con, $sql)){
        http_response_code(201);
        echo json_encode(true);
    }
    else{
        http_response_code(422);
        echo json_encode("Error Adding Planner Object");
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