<header class="bg-dark text-white py-4 mb-4 shadow-sm border-bottom border-secondary">
    <div class="container">
        <div class="text-success fs-1 mb-1"><i class="bi bi-check-circle-fill" aria-hidden="true"></i></div>
        <h1 class="h3 fw-bold mb-1">Booking confirmed, Sarah!</h1>
        <p class="text-muted small mb-0">Your seats are booked. Show the ticket below at the cinema.</p>
    </div>
</header>

<main id="main" class="container mb-5" style="max-width: 860px;">
    <?php require $viewsPath . '/partials/booking-steps.php'; ?>

    <div class="alert alert-success small shadow-sm" role="status">A confirmation email has been sent to sarah.jones@example.com.</div>

    <!-- Ticket -->
    <div class="ticket mb-4">
        <div class="ticket-band"><i class="bi bi-film" aria-hidden="true"></i> iCinema &nbsp;&bull;&nbsp; Admit 2</div>
        <div class="ticket-main">
            <h2 class="h3 fw-bold text-dark mb-1"><?= htmlspecialchars($movie->title) ?></h2>
            <p class="text-muted mb-4"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> <?= htmlspecialchars($bookingCinema['name']) ?> &nbsp;&bull;&nbsp; <?= htmlspecialchars($bookingCinema['features'][0]) ?></p>
            <div class="row g-3">
                    <div class="col-6">
                        <div class="ticket-label">Date</div>
                        <div class="fw-bold text-dark"><?= htmlspecialchars($showDateShort) ?></div>
                    </div>
                    <div class="col-6">
                        <div class="ticket-label">Time</div>
                        <div class="fw-bold text-dark">7:30 PM</div>
                    </div>
                    <div class="col-6">
                        <div class="ticket-label">Seats</div>
                        <div class="fw-bold text-dark">D4, D5</div>
                    </div>
                    <div class="col-6">
                        <div class="ticket-label">Tickets</div>
                        <div class="fw-bold text-dark">2 &times; Adult</div>
                    </div>
                    <div class="col-6">
                        <div class="ticket-label">Total paid</div>
                        <div class="fw-bold text-dark">&pound;24.00</div>
                    </div>
                    <div class="col-6">
                        <div class="ticket-label">Reference</div>
                        <div class="fw-bold text-dark font-monospace text-primary">ICINEMA-A1B2C3D4</div>
                    </div>
            </div>
        </div>
        <div class="ticket-stub">
            <!-- Placeholder: the real page draws a QR code of the reference here -->
            <div class="bg-white p-2 border rounded mb-2"><i class="bi bi-qr-code display-2 text-dark" aria-hidden="true"></i></div>
            <p class="small text-muted mb-0">Scan at the entrance</p>
        </div>
    </div>

    <p class="small text-muted text-center"><i class="bi bi-info-circle" aria-hidden="true"></i> Free cancellation up to 24 hours before the screening, from My Bookings.</p>

    <div class="d-flex flex-wrap justify-content-center gap-3">
        <a href="#" class="btn btn-outline-secondary rounded-pill px-4"><i class="bi bi-printer" aria-hidden="true"></i> Print ticket</a>
        <a href="<?= $url('/my-bookings') ?>" class="btn btn-outline-primary rounded-pill px-4">My bookings</a>
        <a href="<?= $url('/movies') ?>" class="btn btn-primary rounded-pill px-4">Book another film</a>
    </div>
</main>
