<?php

session_start();

// Establish Database Configuration

// $host = 'locahost';
$host = 'localhost';
$username = 'root';
$password = 'root';
$database = 'twitter';

// Create database connection

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if($conn->connect_error){
    echo "Database connection failed.";
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $email = $_POST['email'];
        $password = $_POST['password'];
    
        $sql = $conn->prepare("SELECT * FROM users WHERE email=?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $sql->bind_result($id, $email, $firstname, $lastname , $hashed_password);
       
        if($sql->fetch() && password_verify($password, $hashed_password)){
            $_SESSION['user_id']=$id;
            $_SESSION['email']=$email;
            $_SESSION['firstname']=$firstname;
            $_SESSION['lastname']=$lastname;
            
            header("location: index.php");
        } else {
            $_SESSION['error'] = "Invalid email or password. Please try again.";
        }
        }
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container m-5 p-5 border shadow">
        <h1 class="fw-bold">🐦 TWITTER</h1>
        <p>Connect with friends.</p>
    
    <div class="container rounded border">
    <h2 class="fw-bold mb-4 mt-2">Login</h2> 
        <form method="POST" action="login.php">
            <label class="fw-bold" for="email">Email</label>
            <input id="email" type="email" name="email" class="form-control" required>
            <label class="fw-bold" for="password">Password</label>
            <input id="password" type="password" name="password" class="form-control" required>
            <button class="btn btn-primary mt-4">Login</button>
            <?php
if(isset($_SESSION['error'])){
    echo'<div class="alert alert-danger mt-2">'.$_SESSION['error'].'</div>';
    unset($_SESSION['error']);
}
            ?>
            <p class="mt-3"><a href="register.php">Don't have an account? Click here to register.</a></p>
        </form>
    </div>
    
    </div>
</body>
</html>