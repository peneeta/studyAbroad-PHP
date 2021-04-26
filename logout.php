<?php
session_start();
require 'connect.php';
header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');

$getdata = $_GET['str'];

if(isset($getdata) && !empty($getdata)){
    $request = json_decode($getdata);
    session_destroy();
    echo json_encode(true);
}

?>