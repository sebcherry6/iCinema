<header class="bg-dark text-white py-4 mb-4 shadow-sm border-bottom border-secondary">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Admin Control Panel</h1>
            <p class="text-muted small mb-0">Welcome back, Admin.</p>
        </div>
    </div>
</header>


<main id="main" class="container mb-5">

    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card shadow-sm p-4 bg-white border-start border-primary border-4 rounded-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Total Movies</span>
                        <p class="display-6 fw-bold text-dark mt-2 mb-0"><?= (int) $filmCount ?></p>
                    </div>
                    <span class="stat-icon bg-light text-primary"><i class="bi bi-film" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card shadow-sm p-4 bg-white border-start border-success border-4 rounded-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Active Bookings</span>
                        <p class="display-6 fw-bold text-dark mt-2 mb-0">6</p>
                    </div>
                    <span class="stat-icon bg-light text-success"><i class="bi bi-ticket-detailed" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card shadow-sm p-4 bg-white border-start border-info border-4 rounded-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Registered Users</span>
                        <p class="display-6 fw-bold text-dark mt-2 mb-0">5</p>
                    </div>
                    <span class="stat-icon bg-light text-info"><i class="bi bi-people" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card shadow-sm p-4 bg-white border-start border-warning border-4 rounded-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase">Total Revenue</span>
                        <p class="display-6 fw-bold text-dark mt-2 mb-0">&pound;132.50</p>
                    </div>
                    <span class="stat-icon bg-light text-warning"><i class="bi bi-currency-pound" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-sm-6 col-lg">
            <div class="card shadow-sm border-0 p-4 h-100 text-center d-flex flex-column rounded-3 bg-white">
                <div class="mb-3"><i class="bi bi-film fs-2 text-primary" aria-hidden="true"></i></div>
                <h2 class="h5 fw-bold mb-2 text-dark">Manage Movies</h2>
                <p class="text-muted small flex-grow-1">Add new film listings, posters, synopses and trailers, or remove old releases.</p>
                <div class="mt-auto pt-2"><a href="<?= $url('/admin/movies') ?>" class="btn btn-primary w-100 rounded-pill">Movies</a></div>
            </div>
        </div>
        <div class="col-sm-6 col-lg">
            <div class="card shadow-sm border-0 p-4 h-100 text-center d-flex flex-column rounded-3 bg-white">
                <div class="mb-3"><i class="bi bi-ticket-detailed fs-2 text-success" aria-hidden="true"></i></div>
                <h2 class="h5 fw-bold mb-2 text-dark">Manage Bookings</h2>
                <p class="text-muted small flex-grow-1">View customer ticket purchases, seat allocations, and process cancellations.</p>
                <div class="mt-auto pt-2"><a href="<?= $url('/admin/bookings') ?>" class="btn btn-primary w-100 rounded-pill">Bookings</a></div>
            </div>
        </div>
        <div class="col-sm-6 col-lg">
            <div class="card shadow-sm border-0 p-4 h-100 text-center d-flex flex-column rounded-3 bg-white">
                <div class="mb-3"><i class="bi bi-clock-history fs-2 text-warning" aria-hidden="true"></i></div>
                <h2 class="h5 fw-bold mb-2 text-dark">Manage Showtimes</h2>
                <p class="text-muted small flex-grow-1">Schedule movies, screen formats, and daily times across branches.</p>
                <div class="mt-auto pt-2"><a href="<?= $url('/admin/showtimes') ?>" class="btn btn-primary w-100 rounded-pill">Showtimes</a></div>
            </div>
        </div>
        <div class="col-sm-6 col-lg">
            <div class="card shadow-sm border-0 p-4 h-100 text-center d-flex flex-column rounded-3 bg-white">
                <div class="mb-3"><i class="bi bi-currency-pound fs-2 text-danger" aria-hidden="true"></i></div>
                <h2 class="h5 fw-bold mb-2 text-dark">Ticket Pricing</h2>
                <p class="text-muted small flex-grow-1">Change Adult, Family, Student and Senior prices.</p>
                <div class="mt-auto pt-2"><a href="<?= $url('/admin/pricing') ?>" class="btn btn-primary w-100 rounded-pill">Pricing</a></div>
            </div>
        </div>
        <div class="col-sm-6 col-lg">
            <div class="card shadow-sm border-0 p-4 h-100 text-center d-flex flex-column rounded-3 bg-white">
                <div class="mb-3"><i class="bi bi-people fs-2 text-info" aria-hidden="true"></i></div>
                <h2 class="h5 fw-bold mb-2 text-dark">Manage Users</h2>
                <p class="text-muted small flex-grow-1">View registered customer accounts and system privileges.</p>
                <div class="mt-auto pt-2"><a href="<?= $url('/admin/users') ?>" class="btn btn-primary w-100 rounded-pill">Users</a></div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 p-4 rounded-3 bg-white">
        <h2 class="h4 fw-bold mb-3 text-dark">Recent System Bookings</h2>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead>
                    <tr><th>Reference</th><th>Customer</th><th>Film / Cinema</th><th>When</th><th>Seats</th><th>Total</th><th>Status</th></tr>
                </thead>
                <tbody>
                            <tr>
                                <td class="font-monospace">ICINEMA-0718293A</td>
                                <td>Guest Customer<br><span class="text-muted small">guest@example.com</span></td>
                                <td>Cosmic Odyssey<br><span class="text-muted small">iCinema - London Leicester Square</span></td>
                                <td class="small">Wed 21 Oct, 7:30 PM</td>
                                <td>D6</td>
                                <td class="fw-bold">&pound;9.00</td>
                                <td><span class="badge bg-success">Confirmed</span></td>
                            </tr>
                            <tr>
                                <td class="font-monospace">ICINEMA-F6071829</td>
                                <td>Priya Patel<br><span class="text-muted small">priya.patel@example.com</span></td>
                                <td>Whispers in the Mist<br><span class="text-muted small">iCinema - Manchester Arndale</span></td>
                                <td class="small">Fri 23 Oct, 10:15 PM</td>
                                <td>E4, E5</td>
                                <td class="fw-bold">&pound;19.00</td>
                                <td><span class="badge bg-success">Confirmed</span></td>
                            </tr>
                            <tr>
                                <td class="font-monospace">ICINEMA-E5F60718</td>
                                <td>Priya Patel<br><span class="text-muted small">priya.patel@example.com</span></td>
                                <td>The Last Crown<br><span class="text-muted small">iCinema - London Leicester Square</span></td>
                                <td class="small">Sat 24 Oct, 6:15 PM</td>
                                <td>C4</td>
                                <td class="fw-bold">&pound;9.00</td>
                                <td><span class="badge bg-danger">Cancelled</span></td>
                            </tr>
                            <tr>
                                <td class="font-monospace">ICINEMA-D4E5F607</td>
                                <td>Tom Baker<br><span class="text-muted small">tom.baker@example.com</span></td>
                                <td>Laugh Track<br><span class="text-muted small">iCinema - Birmingham Bullring</span></td>
                                <td class="small">Wed 14 Oct, 7:00 PM</td>
                                <td>E1, E2</td>
                                <td class="fw-bold">&pound;24.00</td>
                                <td><span class="badge bg-success">Confirmed</span></td>
                            </tr>
                            <tr>
                                <td class="font-monospace">ICINEMA-C3D4E5F6</td>
                                <td>Tom Baker<br><span class="text-muted small">tom.baker@example.com</span></td>
                                <td>Midnight Heist<br><span class="text-muted small">iCinema - London Leicester Square</span></td>
                                <td class="small">Tue 20 Oct, 9:00 PM</td>
                                <td>B7, B8</td>
                                <td class="fw-bold">&pound;21.50</td>
                                <td><span class="badge bg-success">Confirmed</span></td>
                            </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>
