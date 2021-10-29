<?php
/*
This file contains database configuration assuming you are running mysql using user "root" and password "" (blank)
*/

define('DB_SERVER', 'localhost');  
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');// password blank 
define('DB_NAME', 'login'); //database name 

// Try connecting to the Database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME); // mysqli_connect aita connection ar jonno 

//Check the connection
if($conn == false){ // jodi connection nah hoi thn print korbo 
    dir('Error: Cannot connect');
}

?>
