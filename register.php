<?php
require_once "config.php"; // include cofig.php 

$username = $password = $confirm_password = ""; // 3 variable 
$username_err = $password_err = $confirm_password_err = ""; // 3 error variable 

if ($_SERVER['REQUEST_METHOD'] == "POST"){ // post request paile aitai dukhbe 

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Opss Username can not be blank"; // jodi user name empty thake then aita print korbe 
        echo "Opss!! Username can not be blank";
    }
    else{
        $sql = "SELECT id FROM users WHERE username = ?"; // pre -prepare korlam sql query ke 
        $stmt = mysqli_prepare($conn, $sql); // stmt = statement , prepare hoye gele 
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username); //   perameter ke bind kore dibe  stmt ar songe, paream_username diye 

            // Set the value of param username
            $param_username = trim($_POST['username']); // trim= whitespace , newline kete dibe 

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt); // if not error then store result 
                if(mysqli_stmt_num_rows($stmt) == 1) // statement a number of row  kto gula , jodi age regrister tahke thn 
                {
                    $username_err = "This username is already taken"; 
                    echo " Opss !! This username is already taken"; 
                }
                else{
                    $username = trim($_POST['username']);// jodi username age theke nah thake thn store korbe username ke 
                }
            }
            else{
                echo "Sorry !! Something went wrong";
            }
        }
      
    }

    mysqli_stmt_close($stmt); // statement close kore dilam 

// Check for password
if(empty(trim($_POST['password']))){ // password empty naki check kortyci
    $password_err = "Opss !! Password can not be blank"; 
    echo "Opss !! Password can not be blank";
}
elseif(strlen(trim($_POST['password'])) < 5){ // password empty nah hole and pass length digit 4 ar kom hole 
    $password_err = "Password can not be less than 5 characters";
    echo "Password can not be less than 5 characters";
}
else{
    $password = trim($_POST['password']);// password nibo tahole 
}

// Check for confirm password field ( match or not )
if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){ // confirm pass jodi pass ar songe match nah hoi thn 
    $password_err = "Opss !! Passwords should be matched ";
    echo "Opss !! Passwords should be matched ";
}


// If there were no errors, go ahead and insert into the database
if(empty($username_err) && empty($password_err) && empty($confirm_password_err))// jodi ai perameter gular value 0 tahe tahole (mane error nah pele )
{
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)"; // ? ? karon prepare kortyci 
    $stmt = mysqli_prepare($conn, $sql);// read abelity 
    if ($stmt)// jodi prepare hoye jai thn 
    {
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);//   perameter ke bind kore dibe  stmt ar songe, param diye 

        // Set these parameters
        $param_username = $username; 
        $param_password = password_hash($password, PASSWORD_DEFAULT);// password ke plane text a store korbo nah hash a sotre korbo , jate database hack hoye gelau password kau dekty parbe nah 
         
        // Try to execute the query
        if (mysqli_stmt_execute($stmt))//$stmt = mysqli_prepare($conn, $sql) aita pass korbo 
        {
            header("location: login.php");// sob succesful hole redirect kore dibo login.php te 
        }
        else{
            echo "Opss !! Something went wrong can not redirect , please regrister again !";
        }
    }
    mysqli_stmt_close($stmt);// statement close 
}
mysqli_close($conn);// database connection close 
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

    <title>Joy Ecommerce  Login</title>
  </head>
  <body>  <!--bootstrap dark navbar getbootstrap theke pike korsi -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Joy Ecommerce </a>
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
<!--navbar close --> 

<!-- start bootstrap , it is pike from getbootstrap-->
<div class="container mt-4"> <!--top margin 4 --> 
<h3>Please Register Here </h3> 
<hr>  <!--hr for line , lower line for h3  --> 
<form action="" method="post"> <!--action blank and method post kore dice  -->
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Username</label>
      <input type="text" class="form-control" name="username" id="inputEmail4" placeholder="Email"><!--type text -->
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Password</label>
      <input type="password" class="form-control" name ="password" id="inputPassword4" placeholder="Password"><!--type text -->
    </div>
  </div>
  <div class="form-group">
      <label for="inputPassword4">Confirm Password</label>
      <input type="password" class="form-control" name ="confirm_password" id="inputPassword" placeholder="Confirm Password"><!--type text -->
    </div>
  <div class="form-group">
    <label for="inputAddress2">Permanent Address </label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, Road ,or which floor">
  </div>
  <div class="form-group">
    <label for="inputAddress2">Present Address </label>
    <input type="text" class="form-control" id="inputAddress3" placeholder="Apartment, Road ,or which floor">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">City</label>
      <input type="text" class="form-control" id="inputCity">
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">State</label>
      <input type="text" class="form-control" id="inputState">
    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Zip</label>
      <input type="text" class="form-control" id="inputZip">
    </div>
  </div>
 
  <button type="submit" class="btn btn-primary">Sign in</button>
</form>
</div>

<!-- close bootstrap , it is pike from getbootstrap-->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
