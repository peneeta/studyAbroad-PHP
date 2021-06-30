<?php
session_start();
require 'connect.php';
header('Access-Control-Allow-Origin: https://engineersabroad.uvacreate.virginia.edu'); //comment out when using localhost
//header('Access-Control-Allow-Origin: http://localhost:4200'); //comment out when using hosted server
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');

$getdata = $_GET['str'];

if(isset($getdata) && !empty($getdata)){
    $request = json_decode($getdata);

    $selectedMajor = mysqli_real_escape_string($con, trim($request->major));
    $selectedTerm = mysqli_real_escape_string($con, trim($request->term));
    //$selectedCountry = mysqli_real_escape_string($con, trim($request->country));
    

    //handle all possible cases of entries and the proper SQL code
    $sql = "";
    if( ($selectedMajor == "" || $selectedMajor == "Any") && ($selectedTerm == "" || $selectedTerm == "Any") ){
        $sql = "SELECT * FROM transferredCourses";
    }
    else if( ($selectedMajor == "" || $selectedMajor == "Any") && !($selectedTerm == "" || $selectedTerm == "Any")){
        $sql = "SELECT * FROM transferredCourses where semester='$selectedTerm'";
    }
    else if( !($selectedMajor == "" || $selectedMajor == "Any") && ($selectedTerm == "" || $selectedTerm == "Any")){
        $sql = "SELECT * FROM transferredCourses where major='$selectedMajor'";
    }
    else if( !($selectedMajor == "" || $selectedMajor == "Any") && !($selectedTerm == "" || $selectedTerm == "Any")){
        $sql = "SELECT * FROM transferredCourses where major='$selectedMajor' and semester='$selectedTerm' ";
    }
    else{

    }

    $sql = $sql." ORDER BY program, HostCourse";

    //echo json_encode($sql);
    if($result = mysqli_query($con, $sql)){
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row; //add each row found into array
        }
        echo json_encode($rows);;     
    }
    else{
        echo json_encode(false);
        http_response_code(404);
        
    }

}
?>