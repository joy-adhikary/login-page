<?php

session_start();// start session 
$_SESSION = array();
session_destroy();// destroy kore dicche session
header("location: login.php");// redirect 

?>