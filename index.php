<!DOCTYPE html>
<html>
<head>
    <title>Event Booker System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: Arial;
            color: white;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                        url('https://images.unsplash.com/photo-1555244162-803834f70033');
            background-size: cover;
            background-position: center;
        }

        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero h1 {
            font-size: 55px;
            font-weight: bold;
        }

        .hero p {
            color: #ddd;
            margin-bottom: 25px;
        }

        .btn-custom {
            margin: 5px;
            padding: 10px 25px;
            border-radius: 30px;
        }

        .features {
            background: #0f172a;
            padding: 80px 0;
        }

        .feature-box {
            background: #1f2937;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            height: 100%;
            transition: 0.3s;
        }

        .feature-box:hover {
            transform: translateY(-5px);
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
            font-weight: bold;
        }

        .footer {
            background: #111827;
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #aaa;
        }
    </style>
</head>

<body>

<!-- HERO -->
<div class="hero">
    <div>
        <h1>🍽️ Event Booker System</h1>
        <p>Simple. Fast. Reliable event booking management system</p>

        <a href="login.php" class="btn btn-primary btn-custom">
    Admin Login
</a>

<a href="customer_login.php" class="btn btn-success btn-custom">
    Customer Login
</a>
    </div>
</div>

<!-- FEATURES ONLY -->
<div class="features">

    <div class="container">

        <h2 class="section-title">✨ System Features</h2>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="feature-box">
                    <h4>📅 Online Booking</h4>
                    <p>Customers can easily book events anytime using the system.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-box">
                    <h4>👤 Customer Accounts</h4>
                    <p>Each customer can register, login, and manage their bookings.</p>
                </div>
            </div>


            <div class="col-md-4">
                <div class="feature-box">
                    <h4>📋 Event Tracking</h4>
                    <p>Track event date, type, and booking details easily.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-box">
                    <h4>🔐 Secure Access</h4>
                    <p>Separate login for admin and customers for better security.</p>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- FOOTER -->
<div class="footer">
    © 2026 Event Booker System | All Rights Reserved
</div>

</body>
</html>