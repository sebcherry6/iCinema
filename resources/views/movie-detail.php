<?php
/*
 * Film page (/movies/{id}). Data prepared by MovieController::show():
 *   $movie        the Movie object for this ID
 *   $moreMovies   up to four other Movie objects for "You might also like"
 * The showtimes box on the right is still static sample data in this part of the course.
 */
?>
<header class="bg-dark text-white py-5 mb-5 shadow-sm border-bottom border-secondary">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-md-3 text-center">
                <img src="<?= $url('/assets/img/' . htmlspecialchars($movie->poster)) ?>" alt="<?= htmlspecialchars($movie->title) ?> poster" class="img-fluid rounded shadow" style="max-height: 340px; width: 100%; object-fit: cover;">
            </div>
            <div class="col-md-9">
                <nav aria-label="Breadcrumb" class="small mb-2"><a href="<?= $url('/movies') ?>" class="footer-link text-decoration-none"><i class="bi bi-arrow-left" aria-hidden="true"></i> All movies</a></nav>
                <h1 class="display-5 fw-bold mb-3 text-white"><?= htmlspecialchars($movie->title) ?></h1>
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <span class="fact-chip"><i class="bi bi-tag" aria-hidden="true"></i> <?= htmlspecialchars($movie->genre) ?></span>
                    <span class="fact-chip"><i class="bi bi-shield-check" aria-hidden="true"></i> <span class="visually-hidden">Age rating </span><?= htmlspecialchars($movie->ageRating) ?></span>
                    <span class="fact-chip"><i class="bi bi-clock" aria-hidden="true"></i> <span class="visually-hidden">Duration </span><?= htmlspecialchars($movie->duration) ?></span>
                    <span class="fact-chip"><i class="bi bi-person-wheelchair" aria-hidden="true"></i> Wheelchair spaces</span>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    <?php if (!$movie->comingSoon): ?>
                    <a href="<?= $url('/showtimes?film=' . (int) $movie->id) ?>" class="btn btn-primary btn-lg px-4 fw-bold">Book tickets</a>
                    <?php else: ?>
                    <span class="btn btn-outline-light btn-lg px-4 disabled" aria-disabled="true">Coming soon: not on sale yet</span>
                    <?php endif; ?>
                    <a href="#trailer" class="btn btn-outline-light btn-lg px-4 rounded-pill"><i class="bi bi-play-circle" aria-hidden="true"></i> Watch trailer</a>
                </div>
            </div>
        </div>
    </div>
</header>

<main id="main" class="container mb-5">
    <?php if (!$movie->comingSoon): ?>
    <?php $contextLabel = 'Showtimes at'; require $viewsPath . '/partials/cinema-context.php'; ?>
    <?php endif; ?>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 p-4 p-md-5 mb-4 rounded-3 bg-white">
                <h2 class="h4 fw-bold mb-3 text-dark section-title">Synopsis</h2>
                <p class="text-dark mt-4 mb-4"><?= htmlspecialchars($movie->synopsis) ?></p>

                <div class="row g-3 text-center mb-4">
                    <div class="col-4"><div class="p-3 bg-light rounded-3"><div class="ticket-label">Genre</div><div class="fw-bold text-dark small"><?= htmlspecialchars($movie->genre) ?></div></div></div>
                    <div class="col-4"><div class="p-3 bg-light rounded-3"><div class="ticket-label">Age rating</div><div class="fw-bold text-dark small"><?= htmlspecialchars($movie->ageRating) ?></div></div></div>
                    <div class="col-4"><div class="p-3 bg-light rounded-3"><div class="ticket-label">Duration</div><div class="fw-bold text-dark small"><?= htmlspecialchars($movie->duration) ?></div></div></div>
                </div>

                <h2 class="h5 fw-bold mb-3 text-dark" id="trailer">Trailer</h2>
                <!-- Placeholder: the real page embeds a YouTube trailer here -->
                <div class="ratio ratio-16x9 mb-2">
                    <div class="trailer-placeholder d-flex flex-column align-items-center justify-content-center">
                        <i class="bi bi-play-circle-fill display-3" aria-hidden="true"></i>
                        <span class="mt-2">YouTube trailer (captions on)</span>
                    </div>
                </div>
                <p class="small text-muted mb-0">Captions are switched on where the trailer provides them.</p>
            </div>
        </div>

        <div class="col-lg-4">
            <?php if (!$movie->comingSoon): ?>
            <div class="card shadow-sm border-0 p-4 sticky-top rounded-3 bg-white" style="top: 90px;">
                <h2 class="h5 fw-bold mb-1 text-dark">Showing today</h2>
                <p class="text-muted small mb-0">Mon 19 October &mdash; tap a time to choose seats.<?= $selectedCinema !== null ? ' Times for your cinema.' : '' ?></p>
                <?php if ($selectedCinema === null || $selectedCinema['id'] === 1): ?>
                <div class="py-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="fw-bold text-dark small">London Leicester Square</span>
                        <span class="badge bg-secondary">IMAX</span>
                    </div>
                    <div class="d-flex flex-wrap gap-1"><a href="<?= htmlspecialchars($url('/seats-extras?cinema=1&film=' . (int) $movie->id)) ?>" class="btn btn-sm btn-outline-primary rounded-pill">4:15 PM</a> <a href="<?= htmlspecialchars($url('/seats-extras?cinema=1&film=' . (int) $movie->id)) ?>" class="btn btn-sm btn-outline-primary rounded-pill">7:30 PM</a></div>
                </div>
                <?php endif; ?>
                <?php if ($selectedCinema === null || $selectedCinema['id'] === 2): ?>
                <div class="py-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="fw-bold text-dark small">Manchester Arndale</span>
                        <span class="badge bg-secondary">IMAX</span>
                    </div>
                    <div class="d-flex flex-wrap gap-1"><a href="<?= htmlspecialchars($url('/seats-extras?cinema=2&film=' . (int) $movie->id)) ?>" class="btn btn-sm btn-outline-primary rounded-pill">6:45 PM</a></div>
                </div>
                <?php endif; ?>
                <?php if ($selectedCinema === null || $selectedCinema['id'] === 3): ?>
                <div class="py-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="fw-bold text-dark small">Birmingham Bullring</span>
                        <span class="badge bg-secondary">4DX</span>
                    </div>
                    <div class="d-flex flex-wrap gap-1"><a href="<?= htmlspecialchars($url('/seats-extras?cinema=3&film=' . (int) $movie->id)) ?>" class="btn btn-sm btn-outline-primary rounded-pill">3:15 PM</a> <a href="<?= htmlspecialchars($url('/seats-extras?cinema=3&film=' . (int) $movie->id)) ?>" class="btn btn-sm btn-outline-primary rounded-pill">6:00 PM</a></div>
                </div>
                <?php endif; ?>
                <a href="<?= $url('/showtimes?film=' . (int) $movie->id) ?>" class="btn btn-primary w-100 mt-3">See all days &amp; cinemas</a>
            </div>
            <?php else: ?>
            <!-- A coming soon film has no showtimes and cannot be booked. -->
            <div class="card p-4">
                <h2 class="h5 mb-2">Not on sale yet</h2>
                <p class="text-muted small mb-3">Tickets for <?= htmlspecialchars($movie->title) ?> are not on sale yet, so there are no showtimes to book.</p>
                <a href="<?= $url('/movies') ?>" class="btn btn-outline-primary">Browse films you can book</a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <h2 class="h4 fw-bold mt-5 mb-4 text-dark section-title">You might also like</h2>
    <div class="row g-3">
            <?php foreach ($moreMovies as $other): ?>
            <div class="col-6 col-md-3">
                <a href="<?= $url('/movies/' . (int) $other->id) ?>" class="text-decoration-none d-block">
                    <div class="mini-poster shadow-sm mb-2"><img src="<?= $url('/assets/img/' . rawurlencode($other->poster)) ?>" alt="<?= htmlspecialchars($other->title) ?> poster" loading="lazy"></div>
                    <div class="small fw-bold text-dark"><?= htmlspecialchars($other->title) ?></div>
                    <!-- Genres are stored as "Sci-Fi / Adventure"; show only the first one. -->
                    <div class="small text-muted"><?= htmlspecialchars(explode(' / ', $other->genre)[0]) ?></div>
                </a>
            </div>
            <?php endforeach; ?>
    </div>
</main>
