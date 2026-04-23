<?php include 'header.php'; ?>

<style>
    .hero {
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                    url('https://images.unsplash.com/photo-1555244162-803834f70033');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 80px 0;
        text-align: center;
    }
</style>

<!-- HERO SECTION -->
<div class="hero">
    <h1>🍽️  EVENT BOOKER</h1>
    <p>Make your events unforgettable</p>
</div>
<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success text-center">
        🎉 Booking Successfully Saved!
    </div>
<?php endif; ?>

<!-- BOOKING FORM -->
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">

        <div class="col-md-8">
            <div class="card shadow-lg p-4">

                <h3 class="text-center mb-4">📅 Book  EVENT</h3>

                <form action="save_booking.php" method="post">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Full Name</label>
                            <input name="name" class="form-control" placeholder="Enter your name" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Contact Number</label>
                            <input name="contact" class="form-control" placeholder="09XXXXXXXXX" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Event Venue</label>
                            <input name="venue" class="form-control" placeholder="Event location" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Number of Guests</label>
                           <input id="guests" name="guests" type="number" class="form-control" placeholder="e.g. 100" required>
                           <p id="totalDisplay" class="mt-2 text-success fw-bold"></p>
                        </div>

                        <!-- NEW FIELD -->
                        <div class="col-md-6 mb-3">
                            <label>Event Date</label>
                            <input name="event_date" type="date" class="form-control" required>
                        </div>

                        <!-- NEW FIELD -->
                        <div class="col-md-6 mb-3">
                            <label>Event Type</label>
                            <select name="event_type" class="form-control">
                                <option>Birthday</option>
                                <option>Wedding</option>
                                <option>Corporate</option>
                                <option>Others</option>
                            </select>
                        </div>

                    </div>

                    <button class="btn btn-primary w-100 mt-3">
                        🎉 Submit Booking
                    </button>

                </form>

            </div>
        </div>

    </div>
</div>
 <script>
document.getElementById('guests').addEventListener('input', function() {
    let guests = this.value;
    let pricePerGuest = 500;

    if (guests > 0) {
        let total = guests * pricePerGuest;
        document.getElementById('totalDisplay').innerHTML =
            "Estimated Price: ₱" + total.toLocaleString();
    } else {
        document.getElementById('totalDisplay').innerHTML = "";
    }
});
</script>
<?php include 'footer.php'; ?>