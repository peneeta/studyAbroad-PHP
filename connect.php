<?php 

define('DB_HOST', 'localhost'); //always keep this line for local and  server
define('DB_USER', 'engineer_ys2nc'); //uncomment this line for when using server
define('DB_PASS', 'NE*t&RK@DB_}'); //uncomment this line for when using server
define('DB_NAME', 'engineer_studyabroad'); //uncomment this line for when using server
// define('DB_USER', 'root'); //uncomment this line for when using local
// define('DB_PASS', ''); //uncomment this line for when using local
// define('DB_NAME', 'studyabroad'); //uncomment this line for when using local

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