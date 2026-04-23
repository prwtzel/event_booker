<?php
include 'db.php';

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // CHECK IF USERNAME EXISTS
    $check = $conn->query("SELECT * FROM customers WHERE username='$username'");

    if ($check->num_rows > 0) {
        $error = "Username already exists!";
    } else {

        $sql = "INSERT INTO customers (name, contact, username, password)
                VALUES ('$name', '$contact', '$username', '$password')";

        if ($conn->query($sql)) {
            $success = "Registration successful! You can now login.";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Register - Event Booker</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            margin: 0;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                        url('https://images.unsplash.com/photo-1555244162-803834f70033');
            background-size: cover;
            background-position: center;
        }

        .register-box {
            width: 400px;
            padding: 30px;
            border-radius: 15px;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(12px);
            color: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        input {
            background: rgba(255,255,255,0.2) !important;
            border: none !important;
            color: white !important;
        }

        input::placeholder {
            color: #ddd;
        }

        .btn-custom {
            background: #667eea;
            border: none;
        }

        .btn-custom:hover {
            background: #5a67d8;
        }
    </style>
</head>

<body>

<div class="d-flex justify-content-center align-items-center vh-100">

    <div class="register-box">

        <h3 class="text-center mb-3">📝 Customer Register</h3>

        <?php if ($success): ?>
            <div class="alert alert-success text-dark"><?= $success ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger text-dark"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">

            <div class="mb-2">
                <input name="name" class="form-control" placeholder="Full Name" required>
            </div>

            <div class="mb-2">
                <input name="contact" class="form-control" placeholder="Contact Number" required>
            </div>

            <div class="mb-2">
                <input name="username" class="form-control" placeholder="Username" required>
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <button class="btn btn-custom w-100 text-white">
                Register
            </button>

        </form>

        <div class="text-center mt-3">
            <a href="customer_login.php" class="text-white">Already have an account? Login</a>
        </div>

    </div>

</div>

</body>
</html>