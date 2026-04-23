<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM customers WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();

        $_SESSION['customer_id'] = $customer['customer_id'];
        $_SESSION['customer_name'] = $customer['name'];

        header("Location: customer_dashboard.php");
        exit();
    } else {
        $error = "Invalid login!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Login - Event Booker</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                        url('https://images.unsplash.com/photo-1555244162-803834f70033');
            background-size: cover;
            background-position: center;
            font-family: Arial;
        }

        .login-box {
            backdrop-filter: blur(12px);
            background: rgba(255,255,255,0.12);
            border-radius: 15px;
            color: white;
            padding: 30px;
            width: 360px;
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

        .btn-login {
            background: #667eea;
            border: none;
        }

        .btn-login:hover {
            background: #5a67d8;
        }

        .btn-register {
            background: #28a745;
            border: none;
        }

        .btn-register:hover {
            background: #218838;
        }
    </style>
</head>

<body>

<div class="d-flex justify-content-center align-items-center vh-100">

    <div class="login-box">

        <h3 class="text-center mb-2">🍽️ Event Booker</h3>
        <p class="text-center mb-3">Customer Login</p>

        <?php if ($error): ?>
            <div class="alert alert-danger text-dark"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">

            <div class="mb-3">
                <label>Username</label>
                <input name="username" class="form-control" placeholder="Enter username" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>

            <button class="btn btn-login w-100 text-white mb-2">
                Login
            </button>

        </form>

        <!-- ✅ REGISTER BUTTON ADDED -->
        <a href="customer_register.php" class="btn btn-register w-100 text-white">
            Create Account
        </a>

        <div class="text-center mt-3">
            <small>Book your events easily 🎉</small>
        </div>

    </div>

</div>

</body>
</html>