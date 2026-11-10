<?php 
    session_start();
    include '../config/db.php';

     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE email=?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            header('location: contact.php');
            exit;
        }
        
        else {
            $error = "Invalid username or password";
        }
     }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Book - Login </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .body {
            font-family:
        }
        .container {
            width: 500px;
            margin: 200px auto;
            padding: 20px;
            border-radius: 15px;
            background-color: #b3c3f7;
        }
        .form-group {
            margin-top: 10px;
        }
        .form-control, .btn {
            padding: 10px;
        }
        label {
            font-weight: 600;
        }
        h4 {
            font-weight: 800;
        }
    </style>
</head>
<body>
    <div class="container">
        <h4 class="mb-4">Welcome back to Contact Book!</h4>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error </div>"; ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email">
                <small>Please enter your email</small>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password">
                <small>Do not share your password</small>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-secondary w-100 mt-3">Log in</button>
            </div>
        </form>
    </div>
    
</body>
</html>