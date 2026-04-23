<?php 
session_start();
include 'db.php';

// CHECK LOGIN
if (!isset($_SESSION['customer_id'])) {
    header("Location: customer_login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

// BOOKINGS QUERY
$bookings = $conn->query("
    SELECT * FROM bookings 
    WHERE customer_id='$customer_id'
    ORDER BY event_date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard - Event Booker</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        /* 🌄 BACKGROUND IMAGE + OVERLAY */
        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;

            background: 
                linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)),
                url('1.jpg');

            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        /* HEADER */
        .header {
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(12px);
            color: white;
            padding: 30px;
            border-radius: 0 0 25px 25px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        /* GLASS CARD */
        .card-box {
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            color: white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.4);
        }

        table {
            color: white !important;
        }

        .table thead {
            background: rgba(255,255,255,0.1);
        }

        .table tbody tr:hover {
            background: rgba(255,255,255,0.08);
            transition: 0.3s;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 12px;
        }

        .btn-light {
            border-radius: 20px;
            padding: 8px 18px;
            font-weight: 500;
        }

        .btn-outline-danger {
            border-radius: 20px;
        }

        .modal-content {
            border-radius: 20px;
            border: none;
            background: rgba(255,255,255,0.95);
        }

    </style>
</head>

<body>

<?php if (isset($_GET['success'])): ?>
<div class="alert alert-success text-center m-0">
    🎉 Booking Successfully Saved!
</div>
<?php endif; ?>

<?php if (isset($_GET['cancel'])): ?>
<div class="alert alert-danger text-center m-0">
    ❌ Booking Cancelled Successfully
</div>
<?php endif; ?>

<!-- HEADER -->
<div class="header">
    <h3>👋 Welcome, <?php echo $_SESSION['customer_name'] ?? 'Guest'; ?></h3>
    <p class="text-light">Book your events easily</p>

    <button class="btn btn-light mt-2" data-bs-toggle="modal" data-bs-target="#bookModal">
        ➕ Book Event
    </button>
</div>

<div class="container mt-4">

    <!-- BOOKINGS -->
    <div class="card-box p-4">

        <h5 class="mb-3">📋 My Bookings</h5>

        <table class="table table-borderless align-middle">
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
                <?php if ($bookings && $bookings->num_rows > 0): ?>
                    <?php while ($row = $bookings->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['venue'] ?></td>
                            <td><?= $row['guests'] ?></td>
                            <td><?= date("M d, Y", strtotime($row['event_date'])) ?></td>
                            <td><?= $row['event_type'] ?></td>

                            <td>
                                <?php
                                $status = $row['status'] ?? 'Pending';

                                if ($status == 'Approved') {
                                    echo '<span class="badge bg-success">Approved</span>';
                                } elseif ($status == 'Rejected') {
                                    echo '<span class="badge bg-danger">Rejected</span>';
                                } elseif ($status == 'Cancelled') {
                                    echo '<span class="badge bg-dark">Cancelled</span>';
                                } else {
                                    echo '<span class="badge bg-warning text-dark">Pending</span>';
                                }
                                ?>
                            </td>

                            <td>
                                <?php if ($status == 'Pending'): ?>
                                    <a href="cancel_booking.php?id=<?= $row['booking_id'] ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Cancel this booking?')">
                                        Cancel
                                    </a>
                                <?php else: ?>
                                    <span class="text-light">—</span>
                                <?php endif; ?>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No bookings yet</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

</div>

<!-- BOOK MODAL -->
<div class="modal fade" id="bookModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">📅 Book Event</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <form action="save_booking.php" method="post">

            <input type="hidden" name="customer_id" value="<?= $customer_id ?>">

            <div class="mb-2">
                <label>Venue</label>
                <input name="venue" class="form-control" required>
            </div>

            <!-- ✅ UPDATED GUEST WITH CALCULATOR -->
            <div class="mb-2">
                <label>Guests</label>
                <input id="guests" name="guests" type="number" class="form-control" required>
            </div>

            <div class="mb-2">
                <label>Total Cost</label>
                <input id="totalCost" class="form-control fw-bold text-success" readonly placeholder="₱ 0">
            </div>

            <div class="mb-2">
                <label>Event Date</label>
                <input name="event_date" type="date" class="form-control" required>
            </div>

            <div class="mb-2">
                <label>Event Type</label>
                <select name="event_type" class="form-control">
                    <option>Birthday</option>
                    <option>Wedding</option>
                    <option>Corporate</option>
                    <option>Others</option>
                </select>
            </div>

            <button class="btn btn-primary w-100 mt-2">
                🎉 Submit Booking
            </button>

        </form>

      </div>

    </div>
  </div>
</div>

<!-- ✅ CALCULATOR SCRIPT -->
<script>
    const guestsInput = document.getElementById("guests");
    const totalDisplay = document.getElementById("totalCost");

    const pricePerGuest = 500; // 🔥 change this anytime

    guestsInput.addEventListener("input", function () {
        let guests = parseInt(this.value) || 0;
        let total = guests * pricePerGuest;

        totalDisplay.value = "₱ " + total.toLocaleString();
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>