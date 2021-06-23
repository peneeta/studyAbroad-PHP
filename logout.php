<?php
session_start();
require 'connect.php';
header('Access-Control-Allow-Origin: https://engineersabroad.uvacreate.virginia.edu'); //comment out when using localhost
//header('Access-Control-Allow-Origin: http://localhost:4200'); //comment out when using hosted server
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');

$getdata = $_GET['str'];

if(isset($getdata) && !empty($getdata)){
    $request = json_decode($getdata);
    session_destroy();
    echo json_encode(true);
}

?>