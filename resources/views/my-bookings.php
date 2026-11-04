<header class="bg-dark text-white py-4 mb-4 shadow-sm border-bottom border-secondary">
    <div class="container">
        <h1 class="h3 fw-bold mb-1">My Account</h1>
        <p class="text-muted small mb-0">Manage your profile and your cinema bookings.</p>
    </div>
</header>

<main id="main" class="container mb-5">
    <div class="row g-4">

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 p-4 rounded-3 bg-white sticky-top" style="top: 90px;">
                <div class="text-center mb-3">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center fw-bold fs-3" style="width: 76px; height: 76px;">S</div>
                    <h2 class="h5 fw-bold mt-3 mb-0 text-dark">Sarah Jones</h2>
                    <p class="text-muted small mb-0">sarah.jones@example.com</p>
                </div>
                <hr>
                <div class="d-flex justify-content-around text-center mb-3">
                    <div><div class="h4 fw-bold text-primary mb-0">2</div><div class="small text-muted">Upcoming</div></div>
                    <div><div class="h4 fw-bold text-primary mb-0">0</div><div class="small text-muted">Past</div></div>
                    <div><div class="h4 fw-bold text-primary mb-0">0</div><div class="small text-muted">Cancelled</div></div>
                </div>
                <a href="<?= $url('/movies') ?>" class="btn btn-primary btn-sm w-100 rounded-pill mb-2">Book a film</a>
                <a href="<?= $url('/login') ?>" class="btn btn-outline-danger btn-sm w-100 rounded-pill">Log out</a>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <h2 class="h4 fw-bold mb-0 text-dark">Your bookings</h2>
                <div class="pill-tabs d-flex gap-2">
                    <a href="#" class="btn btn-sm btn-primary">All</a>
                    <a href="#" class="btn btn-sm btn-outline-primary">Upcoming</a>
                    <a href="#" class="btn btn-sm btn-outline-primary">Past</a>
                    <a href="#" class="btn btn-sm btn-outline-primary">Cancelled</a>
                </div>
            </div>

                <div class="card border mb-3 p-3 shadow-sm rounded-3">
                    <div class="d-flex gap-3">
                        <img src="<?= $url('/assets/img/cosmic_odyssey.png') ?>" alt="" class="booking-thumb flex-shrink-0">
                        <div class="flex-grow-1">
                            <div class="d-flex flex-wrap justify-content-between gap-2">
                                <div>
                                    <span class="badge bg-success mb-1">Confirmed</span>
                                    <span class="badge bg-secondary mb-1 font-monospace">ICINEMA-A1B2C3D4</span>
                                    <h3 class="h5 fw-bold mb-1 text-dark">Cosmic Odyssey</h3>
                                    <p class="text-muted small mb-1"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> iCinema - London Leicester Square</p>
                                    <p class="small text-dark mb-0"><i class="bi bi-calendar-event" aria-hidden="true"></i> Wed 21 Oct 2026, 7:30 PM &nbsp;&bull;&nbsp; <strong>Seats:</strong> D4, D5</p>
                                </div>
                                <div class="text-sm-end d-flex flex-column align-items-sm-end gap-2">
                                    <span class="fw-bold text-primary fs-5">&pound;24.00</span>
                                    <a href="#" class="btn btn-outline-danger btn-sm rounded-pill px-3">Cancel booking</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border mb-3 p-3 shadow-sm rounded-3">
                    <div class="d-flex gap-3">
                        <img src="<?= $url('/assets/img/paws_claws.png') ?>" alt="" class="booking-thumb flex-shrink-0">
                        <div class="flex-grow-1">
                            <div class="d-flex flex-wrap justify-content-between gap-2">
                                <div>
                                    <span class="badge bg-success mb-1">Confirmed</span>
                                    <span class="badge bg-secondary mb-1 font-monospace">ICINEMA-B2C3D4E5</span>
                                    <h3 class="h5 fw-bold mb-1 text-dark">Paws &amp; Claws</h3>
                                    <p class="text-muted small mb-1"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> iCinema - Manchester Arndale</p>
                                    <p class="small text-dark mb-0"><i class="bi bi-calendar-event" aria-hidden="true"></i> Tue 20 Oct 2026, 1:30 PM &nbsp;&bull;&nbsp; <strong>Seats:</strong> C3, C4, C5, C6</p>
                                </div>
                                <div class="text-sm-end d-flex flex-column align-items-sm-end gap-2">
                                    <span class="fw-bold text-primary fs-5">&pound;35.00</span>
                                    <small class="text-muted">Cancellation closed (&lt; 24 hrs)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border mb-3 p-3 shadow-sm rounded-3">
                    <div class="d-flex gap-3">
                        <img src="<?= $url('/assets/img/last_crown.png') ?>" alt="" class="booking-thumb flex-shrink-0">
                        <div class="flex-grow-1">
                            <div class="d-flex flex-wrap justify-content-between gap-2">
                                <div>
                                    <span class="badge bg-danger mb-1">Cancelled</span>
                                    <span class="badge bg-secondary mb-1 font-monospace">ICINEMA-E5F60718</span>
                                    <h3 class="h5 fw-bold mb-1 text-dark">The Last Crown</h3>
                                    <p class="text-muted small mb-1"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> iCinema - London Leicester Square</p>
                                    <p class="small text-dark mb-0"><i class="bi bi-calendar-event" aria-hidden="true"></i> Sat 24 Oct 2026, 6:15 PM &nbsp;&bull;&nbsp; <strong>Seats:</strong> C4</p>
                                </div>
                                <div class="text-sm-end d-flex flex-column align-items-sm-end gap-2">
                                    <span class="fw-bold text-primary fs-5">&pound;9.00</span>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

    </div>
</main>
