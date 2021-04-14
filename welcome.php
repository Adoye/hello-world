<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him/her to login
// if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
//     header("location:login.php");
//         exit;
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<style type="text/css">
        body{ font: 14px poppins; 
            width: 1000px;
            height: 1000px;
            padding: 20px; 
            top: 300px;
            left: 800px;
            text-align : center;
            position: absolute;
        }
    </style>
    
    <div class="page-header">
         <h1>Hi, <! <strong> <?php echo
        htmlspecialchars($_SESSION["username"]); ?> </strong>.  
        Welcome to <i style= "color: rgba(7,32,255,1);">CentralLearn</i>.</h1>
    </div>
    <p>
        <a href="course.html" class="btn btn-warning">Go to Courses</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
</body>
</html>