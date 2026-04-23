<style>
.sidebar {
    background: rgba(15, 23, 42, 0.85);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);

    min-height: 100vh;
    padding: 20px;
    color: white;

    position: sticky;
    top: 0;

    border-right: 1px solid rgba(255,255,255,0.08);
    box-shadow: 10px 0 30px rgba(0,0,0,0.4);
}

/* TITLE */
.sidebar h4 {
    font-weight: 800;
    font-size: 18px;
    margin-bottom: 15px;
    letter-spacing: 1px;

    background: linear-gradient(90deg, #7c3aed, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* LINKS */
.sidebar a {
    display: flex;
    align-items: center;
    gap: 12px;

    padding: 12px 14px;
    margin-bottom: 10px;

    border-radius: 12px;
    text-decoration: none;

    color: #cbd5e1;
    font-size: 15px;
    font-weight: 500;

    transition: 0.25s ease;
}

/* HOVER */
.sidebar a:hover {
    background: rgba(124, 58, 237, 0.15);
    color: #fff;
    transform: translateX(6px);
}

/* ACTIVE */
.sidebar a.active {
    background: linear-gradient(135deg, #7c3aed, #ec4899);
    color: #fff;
    box-shadow: 0 8px 20px rgba(124, 58, 237, 0.4);
}

/* ICON */
.sidebar a i {
    font-size: 18px;
}

/* DIVIDER */
.sidebar hr {
    border: 0;
    border-top: 1px solid rgba(255,255,255,0.08);
    margin: 18px 0;
}

/* FOOTER */
.sidebar-footer {
    position: absolute;
    bottom: 20px;
    width: calc(100% - 40px);
}
</style>

<div class="col-md-2 sidebar">

    <!-- TITLE -->
    <h4>🍽️ Event Booker</h4>

    <hr>

    <!-- DASHBOARD -->
    <a href="dashboard.php"
       class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">
        <i class="bi bi-speedometer2"></i>
        Dashboard
    </a>

    <!-- BOOKINGS (optional if you have it) -->
    <a href="bookings.php"
       class="<?= basename($_SERVER['PHP_SELF']) == 'bookings.php' ? 'active' : '' ?>">
        <i class="bi bi-calendar-check"></i>
        Bookings
    </a>

    <!-- CUSTOMERS (optional) -->
    <a href="customers.php"
       class="<?= basename($_SERVER['PHP_SELF']) == 'customers.php' ? 'active' : '' ?>">
        <i class="bi bi-people"></i>
        Customers
    </a>

    <!-- REPORTS -->
    <a href="reports.php"
       class="<?= basename($_SERVER['PHP_SELF']) == 'reports.php' ? 'active' : '' ?>">
        <i class="bi bi-bar-chart-line"></i>
        Reports
    </a>

    <hr>

    <!-- LOGOUT -->
    <a href="logout.php">
        <i class="bi bi-box-arrow-right"></i>
        Logout
    </a>

</div>