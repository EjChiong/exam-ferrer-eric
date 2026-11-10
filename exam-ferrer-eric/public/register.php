<?php 
    session_start();
    include '../config/db.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first = $_POST["f_name"];
        $middle = $_POST["m_name"];
        $last = $_POST["l_name"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $phone = $_POST["phone"];
        $d_register = $_POST["d_register"];
        $password = $_POST["password"];

        if (!$first || !$last || !$email || !$address || !$phone || !$d_register || !$password)
            $error = "All fields are required*";
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
            $error = "Invalid email format";
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
            $error = "Invalid email format";
        elseif(!preg_match('/^\+?[0-9]{10,15}$/',$phone))
            $error = "Invalid phone number";
        elseif(strlen($password) <8)
            $error = "Password must be 8 characters minimum";
        else {
            $check = mysqli_prepare($conn, "SELECT id FROM user WHERE email =?");
            mysqli_stmt_bind_param($check, "s", $email);
            mysqli_stmt_execute($check);

            if (mysqli_stmt_get_result($check)-> num_rows > 0)
                $error = "Email is already registered";
            else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = mysqli_prepare($conn, "INSERT INTO user (f_name, m_name, l_name, email, address,
                phone, d_register, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)" );
                mysqli_stmt_bind_param($stmt, "ssssssss", $first, $middle, $last, $email, $address,
                $phone, $d_register, $hash);

                if (mysqli_execute($stmt)) {
                    header ('location: login.php');
                }
                $error = "Registration failed";
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Book - Register </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .body {
            font-family:
        }
        .container {
            width: 500px;
            margin: 50px auto;
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
        <h4 class="mb-4">Joins the Contact Book family!</h4>
        <form action="" method="post">
        <?php if(isset($error)): ?>
            <div class=" alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="row"></div>
            <div class="form-group">
                <label for="f_name">First name</label>
                <input type="text" class="form-control" name="f_name">
            </div>

            <div class="form-group">
                <label for="m_name">Middle name</label>
                <input type="text" class="form-control" name="m_name">
            </div>
            
            <div class="form-group">
                <label for="l_name">Last name</label>
                <input type="text" class="form-control" name="l_name">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email">
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" name="address">
            </div>

             <div class="form-group">
                <label for="phone">Phone</label>
                <input type="number" class="form-control" name="phone">
            </div>
            
            <div class="form-group">
                <label for="d_register">Date registered</label>
                <input type="date" class="form-control" name="d_register" value="<?= date('Y-m-d')?>" readonly>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="text" class="form-control" name="password">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-secondary w-100 mt-3">Register</button>
            </div>
        </form>
    </div>
    
</body>
</html>