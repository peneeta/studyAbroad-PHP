<?php 

define('DB_HOST', 'localhost');
define('DB_USER', 'engineer_ys2nc');
define('DB_PASS', 'NE*t&RK@DB_}');
define('DB_NAME', 'engineer_studyabroad');

// Connect with database
function connect()
{
    $connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if(mysqli_connect_errno($connect)){
        die("Failed to connect:" . mysqli_connect_error());
    }

    mysqli_set_charset($connect, "utf8");
    return $connect;
}

$con = connect();

?>