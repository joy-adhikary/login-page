<?php
//This script will handle login
session_start(); // start session for log in 

// check if the user is already logged in
if(isset($_SESSION['username'])) // jodi user age thkeek e log in thake 
{
    header("location: welcome.php"); // redirect korbo welcome.php te 
    exit; // ar por ar code a jabe nah 
}
require_once "config.php";// config for connect db 

$username = $password = ""; //variable 
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){  // jodi post request pai 
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password']))) // jodi username or password empty  thake 
    {
        $err = " Opss !! Please enter username + password";
        echo " Opss !! Please enter the username and  password to log in ";
    }
    else{
        $username = trim($_POST['username']);// set username 
        $password = trim($_POST['password']);// set password 
    }


if(empty($err))// kono error nah thakle  
{
    $sql = "SELECT id, username, password FROM users WHERE username = ?"; // user table thke nibe 
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);//   perameter ke bind kore dibe  stmt ar songe, paream_username diye 
    $param_username = $username;
    
    
    // Try to execute this statement
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);// store result 
        if(mysqli_stmt_num_rows($stmt) == 1) // user already exist korle thn age jabo , regrister thkakle 
                {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);// again bind kortyce thn store 
                    if(mysqli_stmt_fetch($stmt))// jodi password thake database a 
                    {
                        if(password_verify($password, $hashed_password))// akn password jodi hash pass ar songe match kore 
                        {
                            // this means the password is corrct. Allow user to login
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;

                            //Redirect user to welcome page
                            header("location: welcome.php");// redirect kortyce welcome a 
                            
                        }
                    }

                }

             }
        }    


    }


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Joy Ecommerce login system!</title>
  </head>
  <body> <!--bootstrap dark navbar getbootstrap theke pike korsi -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Joy Ecommerce</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
  <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="register.php">Register</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container mt-4">
<h3>Please Login Here</h3>
<hr>

<form action="" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Username</label>
    <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Please Enter Username">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Please Enter Password">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>



</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
