<?php
session_start();
include 'db.php';
include 'header.php';

/* FETCH ONLY APPROVED BOOKINGS */
$bookings = $conn->query("
    SELECT *
    FROM bookings
    WHERE status = 'Approved'
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
.title {
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 20px;

    background: linear-gradient(90deg, #7c3aed, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* CONTAINER */
.box {
    background: rgba(255,255,255,0.06);
    backdrop-filter: blur(12px);
    padding: 20px;
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.1);
}

/* TABLE */
table {
    width: 100%;
    color: white;
    border-collapse: collapse;
}

th {
    background: rgba(124, 58, 237, 0.3);
    padding: 12px;
    text-align: left;
}

td {
    padding: 12px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

tr:hover {
    background: rgba(255,255,255,0.05);
}

/* BADGE */
.badge {
    padding: 5px 10px;
    border-radius: 8px;
    font-size: 12px;
}

.approved {
    background: #16a34a;
}

/* BUTTON */
.btn-soft {
    background: rgba(255,255,255,0.1);
    border: none;
    color: white;
    padding: 6px 10px;
    border-radius: 8px;
    text-decoration: none;
    transition: 0.2s;
}

.btn-soft:hover {
    background: rgba(255,255,255,0.2);
    transform: translateY(-1px);
}
</style>

<div class="container-fluid">
<div class="row">

<?php include 'sidebar.php'; ?>

<div class="col-md-10 p-4">

    <div class="title">📋 Approved Bookings</div>

    <div class="box">

        <div class="table-responsive">

            <table>
                <thead>
                    <tr>
                        <th>Venue</th>
                        <th>Guests</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                <?php if ($bookings->num_rows > 0): ?>
                    <?php while($row = $bookings->fetch_assoc()): ?>

                        <tr>
                            <td><?= $row['venue'] ?></td>
                            <td><?= $row['guests'] ?></td>

                            <td>
                                <?= date('M d, Y', strtotime($row['event_date'])) ?>
                            </td>

                            <td><?= $row['event_type'] ?></td>

                            <td>
                                <span class="badge approved">
                                    Approved
                                </span>
                            </td>

                            <!-- ✅ ONLY DELETE ACTION -->
                            <td>
                                <a href="delete_booking.php?id=<?= $row['booking_id'] ?>"
                                   class="btn-soft"
                                   style="background:#ef4444;"
                                   onclick="return confirm('Are you sure you want to delete this booking?')">
                                    🗑 Delete
                                </a>
                            </td>

                        </tr>

                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No approved bookings found</td>
                    </tr>
                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
</div>
</div>

<?php include 'footer.php'; ?>