<?php
    session_start();
    include '../config/db.php';

    
    if (isset($_POST['save'])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $company = $_POST["company"];
        $notes = $_POST["notes"];
        $uid = $_SESSION['user_id'];

        $stmt = mysqli_prepare($conn, "INSERT INTO contact (name, email, phone, company, notes, user_id)
        VALUES (?, ?, ?, ?, ?, ?)");

        mysqli_stmt_bind_param($stmt, "sssssi", $name, $email, $phone, $company, $notes, $uid);
        mysqli_stmt_execute($stmt);
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Contact Book</title>
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
        <h4 class="mb-4">Add a contact</h4>
        <form action="" method="post">
            <div class="row"></div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email">
            </div>
            
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" name="phone">
            </div>

            <div class="form-group">
                <label for="company">Company</label>
                <input type="text" class="form-control" name="company">
            </div>

            <div class="form-group">
                <label for="notes">Notes</label>
                <input type="text" class="form-control" name="notes">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-secondary w-100 mt-3" name="save">Add Contact</button>
            </div>
        </form>

        <?php 
            $uid = $_SESSION['user_id'];

            $stmt = mysqli_prepare($conn, "SELECT * FROM contact WHERE user_id=? ORDER BY name ASC");
            mysqli_stmt_bind_param($stmt, "i", $uid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($row  = mysqli_fetch_assoc($result)) {
            echo "<p>" . htmlspecialchars($row['name']) . " - " . 
            htmlspecialchars($row['email']) . "</p>";
            }
        ?>
    </div>

    
</body>
</html>