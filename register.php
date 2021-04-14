<?php
// Include config file
require_once "config.php";
 
// Defining Variables and initialize with empty value
    $username = $password = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";
    
// Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"]  === "POST"){
        // validate username
        if(empty(trim($_POST["username"]))){
            $username_err = "Please enter a username.";
        } else {
            // Prepare a SELECT statement
            $sql = "SELECT id FROM users WHERE username = ?";

            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                // Set parameters
                $param_username = trim($_POST["username"]);

                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    
                    // Store the result
                    mysqli_stmt_store_result($stmt);

                    // Is username unique?
                    if(mysqli_stmt_num_rows($stmt == 1)){
                        $username_err = "This username is already taken.";
                    } else {
                        $username = trim($_POST["username"]);
                    }
                } else {
                    echo "Something went wrong. Please try again.";
                }
    
                // close statement
                mysqli_stmt_close($stmt);
            }
        }

    // Validate password
    if(empty(trim($_POST["password"]))){

        // flag the password error
        $password_err ="Please enter a password";
    } elseif(strlen(trim($_POST["password"])) < 6){
        // flag password length error
        $password_err = "Password must have at least 6 characters";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confrim password
    if(empty(trim($_POST["confirm_password"]))){
        
        // flag confirm password error
        $confirm_password_err ="Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);

        // flag if passwords do not match
        if(empty($password_err) && ($password != $confirm_password)){

            //flag confirm mismatch
            $confirm_password_err = "Password mismatch.";
        }
    }

    // Check in errors before inserting into database
    if(empty($username_err) && empty($password_err)  && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as paramaters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set parameters
            $param_username = $username;

            // Hash password
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }
            // close statement
            mysqli_stmt_close($stmt);
        }
    }
    // close statement
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
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
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>
