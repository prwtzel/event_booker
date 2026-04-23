<?php
include'auth.php';
include 'db.php';
include 'header.php';


/* =========================
   STATS
========================= */

$total_bookings = $conn->query("
    SELECT COUNT(*) as total 
    FROM bookings 
    WHERE status != 'Cancelled'
")->fetch_assoc()['total'];

$total_customers = $conn->query("
    SELECT COUNT(*) as total 
    FROM customers
")->fetch_assoc()['total'];

$total_revenue = $conn->query("
    SELECT SUM(guests * 500) as total 
    FROM bookings 
    WHERE status = 'Approved'
")->fetch_assoc()['total'] ?? 0;

/* =========================
   UPCOMING EVENTS (FIXED)
========================= */

$upcoming = $conn->query("
    SELECT *
    FROM bookings
    WHERE event_date >= CURDATE()
    AND status != 'Cancelled'
    ORDER BY event_date ASC
    LIMIT 5
");
?>

<script src="https://unpkg.com/lucide@latest"></script>

<style>

/* 🌄 BACKGROUND */
body {
    margin: 0;
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;

    background:
        linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)),
        url('2.jpg');

    background-size: cover;
    background-position: center;
    background-attachment: fixed;
}

/* GRADIENT TEXT */
.gradient-text {
    font-weight: 800;
    font-size: 32px;

    background: linear-gradient(270deg, #7c3aed, #ec4899, #3b82f6, #22c55e);
    background-size: 800% 800%;

    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;

    animation: gradientMove 8s ease infinite;
}

@keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* HERO */
.hero {
    background: linear-gradient(135deg, #7c3aed, #ec4899);
    border-radius: 20px;
    padding: 30px;
    color: white;
    box-shadow: 0 10px 40px rgba(0,0,0,0.6);
}

/* TEXT */
body, p, small {
    color: #e5e7eb;
}

h1, h2, h3, h4, h5 {
    color: #fff;
}

/* STAT CARDS */
.stat-card {
    background: rgba(255,255,255,0.08);
    border-radius: 18px;
    padding: 20px;
    backdrop-filter: blur(15px);
    transition: .3s;
    border: 1px solid rgba(255,255,255,0.1);
}

.stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.5);
}

/* ICON */
.stat-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
}

.bg-purple { background: rgba(168,85,247,0.3); }
.bg-pink { background: rgba(236,72,153,0.3); }
.bg-blue { background: rgba(59,130,246,0.3); }

/* GLASS */
.glass {
    background: rgba(255,255,255,0.06);
    border-radius: 18px;
    padding: 20px;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.1);
}

/* UPCOMING EVENTS */
.event-item {
    padding: 12px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.event-item strong {
    color: #fff;
}

.event-item small {
    color: rgba(255,255,255,0.75);
}

</style>

<div class="container-fluid">
<div class="row">

<?php include 'sidebar.php'; ?>

<div class="col-md-10 p-4">

    <!-- HERO -->
    <div class="hero mb-4">
        <h2 class="gradient-text">🎉 Event Booker Admin</h2>
        <p>Manage bookings, customers, and events in one place</p>
    </div>

    <!-- STATS -->
    <div class="row g-4">

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon bg-purple">
                    <i data-lucide="calendar"></i>
                </div>
                <small>Total Bookings</small>
                <h3><?= $total_bookings ?></h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon bg-pink">
                    <i data-lucide="users"></i>
                </div>
                <small>Total Customers</small>
                <h3><?= $total_customers ?></h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon bg-blue">
                    <i data-lucide="wallet"></i>
                </div>
                <small>Revenue</small>
                <h3>₱<?= number_format($total_revenue, 2) ?></h3>
            </div>
        </div>

    </div>

    <!-- SECOND ROW -->
    <div class="row mt-4 g-4">

        <!-- UPCOMING EVENTS -->
        <div class="col-md-6">
            <div class="glass">
                <h5><i data-lucide="calendar-days"></i> Upcoming Events</h5>

                <?php if ($upcoming->num_rows > 0): ?>
                    <?php while($row = $upcoming->fetch_assoc()): ?>

                        <div class="event-item">
                            <strong><?= $row['event_type'] ?></strong><br>

                            <small>
                                📍 <?= $row['venue'] ?> • 
                                📅 <?= date('M d, Y', strtotime($row['event_date'])) ?>
                            </small>

                            <br>

                            <small>
                                👥 <?= $row['guests'] ?> guests • 
                                Status: <?= $row['status'] ?>
                            </small>
                        </div>

                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-muted mt-2">No upcoming events</p>
                <?php endif; ?>

            </div>
        </div>

    </div>

</div>
</div>
</div>

<script>
lucide.createIcons();
</script>

<?php include 'footer.php'; ?>