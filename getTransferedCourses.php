<?php
session_start();
require 'connect.php';
header('Access-Control-Allow-Origin: https://engineersabroad.uvacreate.virginia.edu'); //comment out when using localhost
//header('Access-Control-Allow-Origin: http://localhost:4200'); //comment out when using hosted server
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');

$getdata = $_GET['str'];

if(isset($getdata) && !empty($getdata)){
    $request = json_decode($getdata);

    $selectedMajor = mysqli_real_escape_string($con, trim($request->selectedMajor));
    $selectedTerm = mysqli_real_escape_string($con, trim($request->selectedTerm));
    $freeSearchEntry = mysqli_real_escape_string($con, trim($request->freeSearchEntry));

    //handle all possible cases of entries and the proper SQL code
    $sql = "";
    if( ($selectedMajor == "" || $selectedMajor == "Any") && ($selectedTerm == "" || $selectedTerm == "Any") && ($freeSearchEntry == "")){
        $sql = "SELECT * FROM transferredCourses";
    }
    else if( ($selectedMajor == "" || $selectedMajor == "Any") && ($selectedTerm == "" || $selectedTerm == "Any") && !($freeSearchEntry == "")){
        $sql = "SELECT * FROM transferredCourses where (program LIKE '%$freeSearchEntry%' OR UVAcourse LIKE '%$freeSearchEntry%' OR HostCourse LIKE '%$freeSearchEntry%' OR country LIKE '%$freeSearchEntry%')";
    }
    else if( ($selectedMajor == "" || $selectedMajor == "Any") && !($selectedTerm == "" || $selectedTerm == "Any") && ($freeSearchEntry == "")){
        $sql = "SELECT * FROM transferredCourses where semester='$selectedTerm'";
    }
    else if( ($selectedMajor == "" || $selectedMajor == "Any") && !($selectedTerm == "" || $selectedTerm == "Any") && !($freeSearchEntry == "")){
        $sql = "SELECT * FROM transferredCourses where semester='$selectedTerm' and (program LIKE '%$freeSearchEntry%' OR UVAcourse LIKE '%$freeSearchEntry%' OR HostCourse LIKE '%$freeSearchEntry%' OR country LIKE '%$freeSearchEntry%')";
    }
    else if( !($selectedMajor == "" || $selectedMajor == "Any") && ($selectedTerm == "" || $selectedTerm == "Any") && ($freeSearchEntry == "")){
        $sql = "SELECT * FROM transferredCourses where major='$selectedMajor'";
    }
    else if( !($selectedMajor == "" || $selectedMajor == "Any") && ($selectedTerm == "" || $selectedTerm == "Any") && !($freeSearchEntry == "")){
        $sql = "SELECT * FROM transferredCourses where major='$selectedMajor' and (program LIKE '%$freeSearchEntry%' OR UVAcourse LIKE '%$freeSearchEntry%' OR HostCourse LIKE '%$freeSearchEntry%' OR country LIKE '%$freeSearchEntry%')";
    }
    else if( !($selectedMajor == "" || $selectedMajor == "Any") && !($selectedTerm == "" || $selectedTerm == "Any") && ($freeSearchEntry == "")){
        $sql = "SELECT * FROM transferredCourses where major='$selectedMajor' and semester='$selectedTerm' ";
    }
    else{
        $sql = "SELECT * FROM transferredCourses where major='$selectedMajor' and semester='$selectedTerm' and (program LIKE '%$freeSearchEntry%' OR UVAcourse LIKE '%$freeSearchEntry%' OR HostCourse LIKE '%$freeSearchEntry%' OR country LIKE '%$freeSearchEntry%')";
    }

    $sql = $sql." ORDER BY program, UVAcourse";

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