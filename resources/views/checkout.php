<header class="bg-dark text-white py-4 mb-4 shadow-sm border-bottom border-secondary">
    <div class="container">
        <h1 class="h3 fw-bold">Check your order and pay</h1>
        <p class="text-muted small mb-0">Please check everything below before you confirm.</p>
    </div>
</header>

<main id="main" class="container mb-5">
    <?php require $viewsPath . '/partials/booking-steps.php'; ?>
    <p><a href="<?= htmlspecialchars($url('/seats-extras?' . $bookingQuery)) ?>" class="text-decoration-none"><i class="bi bi-arrow-left" aria-hidden="true"></i> Change seats or tickets</a></p>

    <form method="post" action="<?= htmlspecialchars($url('/confirmation?' . $bookingQuery)) ?>">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card shadow-sm border-0 p-4 rounded-3 bg-white mb-4">
                    <h2 class="h4 fw-bold mb-3 text-dark"><i class="bi bi-person-badge me-2" aria-hidden="true"></i>Your details</h2>
                    <p class="text-muted small mb-3">You are booking as a guest. <a href="<?= $url('/login') ?>">Log in</a> or <a href="<?= $url('/register') ?>">register</a> if you'd like to see your booking history later.</p>
                    <div class="mb-3">
                        <label for="fullName" class="form-label fw-bold small text-dark">Full name</label>
                        <input type="text" class="form-control" id="fullName" name="fullName" placeholder="e.g. Jane Doe">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold small text-dark">Email address (we send your confirmation here)</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                    </div>
                    <div class="mb-0">
                        <label for="address" class="form-label fw-bold small text-dark">Billing address and postcode</label>
                        <textarea class="form-control" id="address" name="address" rows="2" placeholder="Street address, City, Postcode"></textarea>
                    </div>
                </div>

                <div class="card shadow-sm border-0 p-4 rounded-3 bg-white">
                    <h2 class="h4 fw-bold mb-3 text-dark"><i class="bi bi-credit-card me-2" aria-hidden="true"></i>Payment</h2>
                    <p class="text-muted small mb-3">Card details are never stored on our server. (Placeholder for the cinema's payment provider.)</p>
                    <div class="mb-3">
                        <label for="card_number" class="form-label fw-bold small text-dark">Card number</label>
                        <input type="text" class="form-control" id="card_number" name="card_number" placeholder="1234 5678 9012 3456">
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="card_expiry" class="form-label fw-bold small text-dark">Expiry (MM/YY)</label>
                            <input type="text" class="form-control" id="card_expiry" name="card_expiry" placeholder="MM/YY">
                        </div>
                        <div class="col-6 mb-3">
                            <label for="card_cvv" class="form-label fw-bold small text-dark">Security code</label>
                            <input type="password" class="form-control" id="card_cvv" name="card_cvv">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow-sm border-0 p-4 rounded-3 bg-white h-100 d-flex flex-column">
                    <h2 class="h4 fw-bold mb-3 text-dark"><i class="bi bi-receipt me-2" aria-hidden="true"></i>Order summary</h2>

                    <div class="mb-3 pb-3 border-bottom">
                        <p class="fw-bold text-dark mb-1 fs-5"><?= htmlspecialchars($movie->title) ?></p>
                        <p class="text-muted small mb-0"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> <?= htmlspecialchars($bookingCinema['name']) ?></p>
                        <p class="text-muted small mb-0"><?= htmlspecialchars($showDateShort) ?> at 7:30 PM</p>
                    </div>

                    <div class="mb-3 pb-3 border-bottom small">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Seats</span><span class="fw-bold text-dark">D4, D5</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Adult (2 &times; &pound;12.00)</span><span>&pound;24.00</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="h5 fw-bold mb-0 text-dark">Total</span>
                        <span class="h4 fw-bold mb-0 text-primary">&pound;24.00</span>
                    </div>

                    <p class="small text-muted">Free cancellation up to 24 hours before the screening, from My Account.</p>

                    <div class="mt-auto pt-3 border-top">
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill">Confirm &amp; pay &pound;24.00</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>
