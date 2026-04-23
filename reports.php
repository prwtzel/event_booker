<?php
include 'db.php';
include 'header.php';

/* =========================
   DATA
========================= */

// TOTAL BOOKINGS (exclude cancelled)
$totalBookings = $conn->query("
    SELECT COUNT(*) as total 
    FROM bookings 
    WHERE status != 'Cancelled'
")->fetch_assoc()['total'];

// TOTAL CUSTOMERS
$totalCustomers = $conn->query("
    SELECT COUNT(*) as total 
    FROM customers
")->fetch_assoc()['total'];

// TOTAL REVENUE (approved only)
$totalRevenue = $conn->query("
    SELECT SUM(guests * 500) as total 
    FROM bookings 
    WHERE status = 'Approved'
")->fetch_assoc()['total'] ?? 0;

// MONTHLY REPORT
$monthly = $conn->query("
    SELECT 
        DATE_FORMAT(event_date, '%Y-%m') as month,
        COUNT(*) as bookings,
        SUM(guests * 500) as revenue
    FROM bookings
    WHERE status != 'Cancelled'
    GROUP BY DATE_FORMAT(event_date, '%Y-%m')
    ORDER BY month ASC
");

// PREPARE CHART DATA
$months = [];
$bookingsData = [];
$revenueData = [];

while ($row = $monthly->fetch_assoc()) {
    $months[] = $row['month'];
    $bookingsData[] = $row['bookings'];
    $revenueData[] = $row['revenue'];
}
?>

<!-- ICONS + CHART -->
<script src="https://unpkg.com/lucide@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

/* BACKGROUND */
body {
    background: linear-gradient(135deg, #0f172a, #1e293b);
    color: #e5e7eb;
    font-family: 'Segoe UI', sans-serif;
}

/* TITLE */
.title {
    font-size: 26px;
    font-weight: 700;
    background: linear-gradient(90deg, #22c55e, #6366f1);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* CARDS */
.stat-card {
    background: rgba(255,255,255,0.05);
    border-radius: 18px;
    padding: 20px;
    backdrop-filter: blur(10px);
    transition: .3s;
}

.stat-card:hover {
    transform: translateY(-5px);
}

/* ICON */
.icon-box {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
}

/* COLORS */
.blue { background: rgba(59,130,246,0.2); }
.green { background: rgba(34,197,94,0.2); }
.yellow { background: rgba(234,179,8,0.2); }

/* GLASS */
.glass {
    background: rgba(255,255,255,0.04);
    border-radius: 18px;
    padding: 20px;
    backdrop-filter: blur(10px);
}

/* TABLE */
.table {
    color: #e5e7eb;
}

.table thead {
    background: #1e293b;
}

</style>

<div class="container-fluid">
<div class="row">

<?php include 'sidebar.php'; ?>

<div class="col-md-10 p-4">

    <div class="title mb-4">Reports Dashboard</div>

    <!-- SUMMARY -->
    <div class="row g-4">

        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon-box blue">
                    <i data-lucide="calendar"></i>
                </div>
                <small>Total Bookings</small>
                <h3><?= $totalBookings ?></h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon-box green">
                    <i data-lucide="users"></i>
                </div>
                <small>Total Customers</small>
                <h3><?= $totalCustomers ?></h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon-box yellow">
                    <i data-lucide="wallet"></i>
                </div>
                <small>Total Revenue</small>
                <h3>₱<?= number_format($totalRevenue, 2) ?></h3>
            </div>
        </div>

    </div>

    <!-- CHART -->
    <div class="glass mt-5">
        <h5><i data-lucide="bar-chart-3"></i> Monthly Performance</h5>
        <canvas id="reportChart" height="100"></canvas>
    </div>

    <!-- TABLE -->
    <div class="glass mt-5">
        <h5><i data-lucide="table"></i> Monthly Report</h5>

        <table class="table table-hover mt-3">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Bookings</th>
                    <th>Revenue</th>
                </tr>
            </thead>
            <tbody>

            <?php
            // RE-RUN QUERY for table
            $monthly2 = $conn->query("
                SELECT 
                    DATE_FORMAT(event_date, '%Y-%m') as month,
                    COUNT(*) as bookings,
                    SUM(guests * 500) as revenue
                FROM bookings
                WHERE status != 'Cancelled'
                GROUP BY DATE_FORMAT(event_date, '%Y-%m')
                ORDER BY month DESC
            ");

            while ($row = $monthly2->fetch_assoc()):
            ?>
                <tr>
                    <td><?= $row['month'] ?></td>
                    <td><?= $row['bookings'] ?></td>
                    <td>₱<?= number_format($row['revenue'], 2) ?></td>
                </tr>
            <?php endwhile; ?>

            </tbody>
        </table>
    </div>

</div>
</div>
</div>

<script>
lucide.createIcons();

// CHART
const ctx = document.getElementById('reportChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($months) ?>,
        datasets: [
            {
                label: 'Bookings',
                data: <?= json_encode($bookingsData) ?>,
                borderWidth: 2,
                tension: 0.4
            },
            {
                label: 'Revenue',
                data: <?= json_encode($revenueData) ?>,
                borderWidth: 2,
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: { color: '#fff' }
            }
        },
        scales: {
            x: {
                ticks: { color: '#fff' }
            },
            y: {
                ticks: { color: '#fff' }
            }
        }
    }
});
</script>

<?php include 'footer.php'; ?>