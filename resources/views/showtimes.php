<header class="bg-dark text-white py-4 mb-4 shadow-sm">
    <div class="container d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-3">
            <img src="<?= $url('/assets/img/' . rawurlencode($movie->poster)) ?>" alt="" class="film-head-poster">
            <div>
                <p class="small text-uppercase mb-1 text-muted">Book tickets for</p>
                <h1 class="h3 fw-bold mb-1"><?= htmlspecialchars($movie->title) ?></h1>
                <p class="text-muted small mb-0"><?= htmlspecialchars($movie->genre) ?> &bull; <?= htmlspecialchars($movie->ageRating) ?> &bull; <?= htmlspecialchars($movie->duration) ?></p>
            </div>
        </div>
        <a href="<?= $url('/movies') ?>" class="btn btn-outline-light btn-sm rounded-pill"><i class="bi bi-arrow-left" aria-hidden="true"></i> Choose a different film</a>
    </div>
</header>

<main id="main" class="container mb-5">
    <?php require $viewsPath . '/partials/booking-steps.php'; ?>

    <!-- Day picker -->
    <nav aria-label="Choose a day" class="mb-3">
        <ul class="list-unstyled d-flex gap-2 overflow-auto pb-2 mb-0">
            <?php foreach ($bookingDays as $day): ?>
                <!-- The client takes bookings up to a week ahead (interview Q3): today and the next seven days. -->
                <li><a href="<?= htmlspecialchars($url('/showtimes?' . http_build_query(['film' => $movie->id, 'date' => $day['value']]))) ?>" class="btn btn-sm text-nowrap <?= $day['selected'] ? 'btn-primary' : 'btn-outline-primary' ?>"<?= $day['selected'] ? ' aria-current="date"' : '' ?>><?= htmlspecialchars($day['label']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <!-- Filters -->
    <div class="card shadow-sm border-0 mb-4 p-3 p-md-4 bg-white rounded-3">
        <form method="get" action="<?= $url('/showtimes') ?>" class="row g-3 align-items-end">
            <input type="hidden" name="film" value="<?= (int) $movie->id ?>">
            <div class="col-md-4">
                <label for="cinema_id" class="form-label fw-bold small text-dark">Cinema</label>
                <!-- name="cinema": submitting the form saves the choice, exactly like the header picker. -->
                <select id="cinema_id" name="cinema" class="form-select">
                    <option value="all">All cinemas</option>
                    <?php foreach ($cinemas as $cinema): ?>
                    <!-- The cinema chosen in the header picker is selected here. -->
                    <option value="<?= (int) $cinema['id'] ?>"<?= $selectedCinema !== null && $selectedCinema['id'] === $cinema['id'] ? ' selected' : '' ?>><?= htmlspecialchars($cinema['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="date" class="form-label fw-bold small text-dark">Date</label>
                <input type="date" id="date" name="date" class="form-control" value="<?= htmlspecialchars($showDate) ?>" min="<?= htmlspecialchars($bookingDays[0]['value']) ?>" max="<?= htmlspecialchars($bookingDays[count($bookingDays) - 1]['value']) ?>">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">Show times</button>
                <a href="<?= $url('/showtimes?film=' . (int) $movie->id) ?>" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <p class="text-dark fw-bold mb-0">Showing <?= htmlspecialchars($showDateLong) ?></p>
        <p class="small text-muted mb-0"><span class="badge time-chip-low border">Low</span> few seats left &nbsp; <span class="badge time-chip-sold">Sold out</span> &nbsp; <span class="badge time-chip-off">Started</span></p>
    </div>

    <?php $contextLabel = 'Showtimes at'; require $viewsPath . '/partials/cinema-context.php'; ?>

    <div class="row g-4">
        <?php if ($selectedCinema === null || $selectedCinema['id'] === 1): ?>
        <div class="col-12">
            <div class="card shadow-sm border-0 p-4 rounded-3">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <h2 class="h5 fw-bold mb-1 text-dark">iCinema - London Leicester Square</h2>
                        <p class="text-muted small mb-1"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> 24-26 Cranbourn St, London WC2H 7AA</p>
                        <p class="small mb-0"><span class="badge bg-secondary me-1">IMAX</span> <span class="badge bg-secondary"><i class="bi bi-person-wheelchair" aria-hidden="true"></i> Accessible</span></p>
                    </div>
                    <div class="col-md-8">
                        <p class="small text-dark fw-bold mb-2">Times on <?= htmlspecialchars($showDateShort) ?>:</p>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="btn time-chip-off px-3 py-2 rounded-pill" aria-disabled="true">1:00 PM <small class="d-block">Started</small></span> <a href="<?= htmlspecialchars($url('/seats-extras?cinema=1&' . $bookingQuery)) ?>" class="btn btn-outline-primary px-3 py-2 rounded-pill">4:15 PM <small class="d-block">18 seats left</small></a> <a href="<?= htmlspecialchars($url('/seats-extras?cinema=1&' . $bookingQuery)) ?>" class="btn btn-outline-primary time-chip-low px-3 py-2 rounded-pill">7:30 PM <small class="d-block">Only 6 left</small></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if ($selectedCinema === null || $selectedCinema['id'] === 2): ?>
        <div class="col-12">
            <div class="card shadow-sm border-0 p-4 rounded-3">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <h2 class="h5 fw-bold mb-1 text-dark">iCinema - Manchester Arndale</h2>
                        <p class="text-muted small mb-1"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> Mell Square, Manchester M4 3AQ</p>
                        <p class="small mb-0"><span class="badge bg-secondary me-1">IMAX</span> <span class="badge bg-secondary"><i class="bi bi-person-wheelchair" aria-hidden="true"></i> Accessible</span></p>
                    </div>
                    <div class="col-md-8">
                        <p class="small text-dark fw-bold mb-2">Times on <?= htmlspecialchars($showDateShort) ?>:</p>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="btn time-chip-sold px-3 py-2 rounded-pill" aria-disabled="true">2:00 PM <small class="d-block">Sold out</small></span> <a href="<?= htmlspecialchars($url('/seats-extras?cinema=2&' . $bookingQuery)) ?>" class="btn btn-outline-primary px-3 py-2 rounded-pill">6:45 PM <small class="d-block">24 seats left</small></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if ($selectedCinema === null || $selectedCinema['id'] === 3): ?>
        <div class="col-12">
            <div class="card shadow-sm border-0 p-4 rounded-3">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <h2 class="h5 fw-bold mb-1 text-dark">iCinema - Birmingham Bullring</h2>
                        <p class="text-muted small mb-1"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> Upper Mall West, Bullring, Birmingham B5 4BG</p>
                        <p class="small mb-0"><span class="badge bg-secondary me-1">4DX</span> <span class="badge bg-secondary"><i class="bi bi-person-wheelchair" aria-hidden="true"></i> Accessible</span></p>
                    </div>
                    <div class="col-md-8">
                        <p class="small text-dark fw-bold mb-2">Times on <?= htmlspecialchars($showDateShort) ?>:</p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="<?= htmlspecialchars($url('/seats-extras?cinema=3&' . $bookingQuery)) ?>" class="btn btn-outline-primary px-3 py-2 rounded-pill">12:30 PM <small class="d-block">31 seats left</small></a> <a href="<?= htmlspecialchars($url('/seats-extras?cinema=3&' . $bookingQuery)) ?>" class="btn btn-outline-primary px-3 py-2 rounded-pill">3:15 PM <small class="d-block">40 seats left</small></a> <a href="<?= htmlspecialchars($url('/seats-extras?cinema=3&' . $bookingQuery)) ?>" class="btn btn-outline-primary px-3 py-2 rounded-pill">6:00 PM <small class="d-block">40 seats left</small></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>
