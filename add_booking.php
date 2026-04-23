<?php
include 'db.php';
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $venue = $_POST['venue'];
    $guests = $_POST['guests'];
    $event_date = $_POST['event_date'];
    $event_type = $_POST['event_type'];

    // Insert into customers
    $sql1 = "INSERT INTO customers (name, contact) VALUES ('$name', '$contact')";
    if (!$conn->query($sql1)) {
        die("Customer Error: " . $conn->error);
    }

    $customer_id = $conn->insert_id;

    // Insert into bookings
    $sql2 = "INSERT INTO bookings (customer_id, venue, guests, event_date, event_type)
             VALUES ('$customer_id', '$venue', '$guests', '$event_date', '$event_type')";
    if (!$conn->query($sql2)) {
        die("Booking Error: " . $conn->error);
    }

    // Redirect after success
    header("Location: bookings.php");
    exit();
}
?>

<div class="container-fluid">
    <div class="row">

        <?php include 'sidebar.php'; ?>

        <div class="col-md-10 p-4">

            <div class="card shadow p-4">
                <h3>Add Booking</h3>

                <form method="post">

                    <div class="mb-3">
                        <label>Name</label>
                        <input name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Contact</label>
                        <input name="contact" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Venue</label>
                        <input name="venue" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Guests</label>
                        <input name="guests" type="number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Event Date</label>
                        <input name="event_date" type="date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Event Type</label>
                        <input name="event_type" class="form-control" required>
                    </div>


                    <button type="submit" class="btn btn-primary">
                        Save Booking
                    </button>

                </form>
            </div>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?> 