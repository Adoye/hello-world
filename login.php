<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: welcome.php");
  exit;
}
 
//
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Start credentials validation here
    if(empty($username_err) && empty($password_err)){
    
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        //
        if($stmt = mysqli_prepare($link, $sql)){
        
            // 
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // 
            if(mysqli_stmt_execute($stmt)){
            
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // 
                if(mysqli_stmt_num_rows($stmt) == 1){ 
                
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    
                    // Fetches the columns of the result into the specified variables.
                    if(mysqli_stmt_fetch($stmt)){
                        
                        // 
                        if(password_verify($password, $hashed_password)){
                        
                            // 
                            session_start();
                            
                            // 
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // 
                            header("location: welcome.php");
                        } else{
                        
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <style type="text/css">
        body{ font: 14px poppins; }
        .wrapper{ 
            width: 350px;
            padding: 20px; 
            top: 300px;
            left: 1000px;
            position: absolute;
        }
    </style>
</head>
<body>
<div class="v10__3"><a href="#"><img src="android/icon/24/chevron-down.svg" alt=""></a></div>
    <div class="name"></div>
    <span class="v6_2">
        CentralLearn
    </span>
    <div class="v6_5"> 
        <span class="v6_3">
           <a href="Homepage.html"> Home </a>
        </span>
        <div class="v10__7"><img src="android/icon/24/arrow-down.svg" alt=""></div>
        <div class="v10_7">
           
            <span class="v6_28">
                <a href="course.html"> Courses </a>
            </span>
            <div class="name"></div>
        </div>
        <span class="v6_29">
            <a href="login.php"> Login</a>
        </span>
        <span class="v10_35">
            <a href="register.php">Sign-up</a>
        </span>
    </div>
    
    <div class="v10_26">
        <span class="v10_25">
            <a href="#"> Search </a>
        </span>
        <div class="v10_11"><img src="Vector.svg" alt=""></div>
    </div>
    <div class="v10_27">
        <span class="v10_28">
            Donate
        </span>
</div>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>    
</body>
</html>