<?php
session_start();
include 'db.php';
include 'header.php';

/* FETCH BOOKINGS */
$bookings = $conn->query("
    SELECT *
    FROM bookings
    ORDER BY event_date DESC
");
?>

<style>
body {
    background: linear-gradient(120deg, #0f172a, #111827);
    color: white;
    font-family: 'Segoe UI', sans-serif;
}

/* TITLE */
.page-title {
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 20px;
    background: linear-gradient(90deg, #7c3aed, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* TABLE */
.table-container {
    background: rgba(255,255,255,0.06);
    backdrop-filter: blur(12px);
    padding: 20px;
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.1);
}

table {
    width: 100%;
    color: white;
    border-collapse: collapse;
}

thead {
    background: rgba(124, 58, 237, 0.3);
}

th, td {
    padding: 12px;
    font-size: 14px;
    text-align: left;
}

tr {
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

tr:hover {
    background: rgba(255,255,255,0.05);
}

/* STATUS */
.status {
    padding: 5px 10px;
    border-radius: 10px;
    font-size: 12px;
    display: inline-block;
}

.pending { background: #f59e0b; }
.approved { background: #16a34a; }
.cancelled { background: #ef4444; }

/* BUTTON */
.btn-soft {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: rgba(255,255,255,0.1);
    border: none;
    color: white;
    padding: 6px 10px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 12px;
    margin-right: 5px;
    transition: 0.2s;
}

.btn-soft:hover {
    background: rgba(255,255,255,0.2);
    transform: translateY(-2px);
}

/* BACK BUTTON */
.btn-back {
    display: inline-block;
    margin-bottom: 15px;
    color: white;
    text-decoration: none;
    background: rgba(255,255,255,0.1);
    padding: 8px 14px;
    border-radius: 10px;
}

.btn-back:hover {
    background: rgba(255,255,255,0.2);
}
</style>

<div class="container-fluid">
<div class="row">

<?php include 'sidebar.php'; ?>

<div class="col-md-10 p-4">

    <a href="dashboard.php" class="btn-back">← Back</a>

    <div class="page-title">📋 All Bookings</div>

    <div class="table-container">

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Event Type</th>
                    <th>Date</th>
                    <th>Venue</th>
                    <th>Guests</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

            <?php if ($bookings->num_rows > 0): ?>
                <?php while($row = $bookings->fetch_assoc()): ?>

                    <tr>
                        <td>#<?= $row['booking_id'] ?></td>
                        <td><?= $row['customer_name'] ?? 'N/A' ?></td>
                        <td><?= $row['event_type'] ?></td>

                        <td>
                            <?= date('M d, Y', strtotime($row['event_date'])) ?>
                        </td>

                        <td><?= $row['venue'] ?></td>
                        <td><?= $row['guests'] ?></td>

                        <td>
                            <span class="status <?= strtolower($row['status']) ?>">
                                <?= $row['status'] ?>
                            </span>
                        </td>

                        <!-- ACTIONS UPGRADED -->
                        <td style="white-space:nowrap;">

                            <?php if ($row['status'] == 'Pending'): ?>

                                <a href="approve.php?id=<?= $row['booking_id'] ?>"
                                   class="btn-soft"
                                   style="background:#16a34a;">
                                    ✔ Approve
                                </a>

                                <a href="cancel.php?id=<?= $row['booking_id'] ?>"
                                   class="btn-soft"
                                   style="background:#f59e0b;">
                                    ❌ Cancel
                                </a>

                            <?php elseif ($row['status'] == 'Approved'): ?>

                                <a href="cancel.php?id=<?= $row['booking_id'] ?>"
                                   class="btn-soft"
                                   style="background:#f59e0b;">
                                    ❌ Cancel
                                </a>

                                <span class="btn-soft" style="background:#2563eb;">
                                    ✔ Approved
                                </span>

                            <?php elseif ($row['status'] == 'Cancelled'): ?>

                                <a href="approve.php?id=<?= $row['booking_id'] ?>"
                                   class="btn-soft"
                                   style="background:#16a34a;">
                                    ✔ Re-Approve
                                </a>

                                <span class="btn-soft" style="background:#ef4444;">
                                    ✖ Cancelled
                                </span>

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No bookings found</td>
                </tr>
            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>
</div>
</div>

<?php include 'footer.php'; ?>