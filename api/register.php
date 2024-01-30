<?php
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

    if($_POST['password'] == $_POST['confirmpassword']){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
        $sql = $conn->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
        $sql->bind_param("ssss", $firstname, $lastname, $email, $password);
    
        if($sql->execute()){
            header("location: login.php");
        }else{
            $_SESSION['error'] = "Registration failed. Please try again.";
        }
    }else{
        $_SESSION['error'] = "Passwords do not match. Please try again.";
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
    <h2 class="fw-bold mb-4 mt-3">Create a free account</h2> 
        <form method="POST" action="register.php">
            <label class="fw-bold mt-2" for="firstname">First name</label>
            <input id="firstname" type="text" name="firstname" class="form-control" required>
            <label class="fw-bold mt-2" for="lastname">Last name</label>
            <input id="lastname" type="text" name="lastname" class="form-control" required>
            <label class="fw-bold mt-2" for="email">Email</label>
            <input id="email" type="email" name="email" class="form-control" required>
            <label class="fw-bold mt-2" for="password">Password</label>
            <input id="password" type="password" name="password" class="form-control" required>
            <label class="fw-bold mt-2" for="confirmpassword">Confirm password</label>
            <input id="confirmpassword" type="confirmpassword" name="confirmpassword" class="form-control" required>

            <button class="btn btn-primary mt-4">Create account</button>
<?php
if(isset($_SESSION['error'])){
    echo'<div class="alert alert-danger mt-2">'.$_SESSION['error'].'</div>';
    unset($_SESSION['error']);
}



?>


            <p class="mt-3"><a href="login.php">Already have an account? Click here to login.</a></p>
        </form>
    </div>
    
    </div>
</body>
</html>