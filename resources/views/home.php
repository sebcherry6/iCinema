<?php
/*
 * Home page. Data prepared by MovieController::home() and the ViewRenderer:
 *   $nowShowing      up to eight films that can be booked
 *   $comingSoon      up to four films that cannot be booked yet
 *   $bookableMovies  every film that can be booked (the quick-booking drop-down)
 *   $bookingDays     today and the next seven days (the quick-booking day list)
 *   $cinemas, $selectedCinema   the cinema list and the visitor's chosen cinema (shared by every page)
 *
 * Order of the page: quick booking, a strip of facts, what is showing, what is coming, choose a cinema.
 */
?>
<!-- Hero: the quick-booking bar. Choosing a cinema, a film and a day opens the showtimes page.
     The form sends ?cinema=..&film=..&date=..; public/index.php saves the cinema as the visitor's
     choice, then the showtimes page reads the film and the date. -->
<section class="hero">
    <div class="container">
        <p class="hero-kicker"><?= $selectedCinema !== null
            ? 'Your cinema: ' . htmlspecialchars(preg_replace('/^iCinema - /', '', $selectedCinema['name']))
            : 'Independent cinema &middot; London &middot; Manchester &middot; Birmingham' ?></p>
        <h1 class="hero-title">Your seat is waiting.</h1>
        <p class="hero-lead">Choose a cinema, a film and a day, and see the times.</p>

        <form class="quick-book" method="get" action="<?= $url('/showtimes') ?>">
            <h2 class="visually-hidden">Quick booking</h2>
            <div class="quick-field">
                <label for="qbCinema">Cinema</label>
                <select id="qbCinema" name="cinema" class="form-select">
                    <option value="all">All cinemas</option>
                    <?php foreach ($cinemas as $cinema): ?>
                    <option value="<?= (int) $cinema['id'] ?>"<?= $selectedCinema !== null && $selectedCinema['id'] === $cinema['id'] ? ' selected' : '' ?>><?= htmlspecialchars(preg_replace('/^iCinema - /', '', $cinema['name'])) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="quick-field">
                <label for="qbFilm">Film</label>
                <!-- Only films that can be booked are listed: coming soon films are not here. -->
                <select id="qbFilm" name="film" class="form-select">
                    <?php foreach ($bookableMovies as $bookable): ?>
                    <option value="<?= (int) $bookable->id ?>"><?= htmlspecialchars($bookable->title) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="quick-field">
                <label for="qbDate">Day</label>
                <select id="qbDate" name="date" class="form-select">
                    <?php foreach ($bookingDays as $day): ?>
                    <option value="<?= htmlspecialchars($day['value']) ?>"<?= $day['selected'] ? ' selected' : '' ?>><?= htmlspecialchars($day['label']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-accent quick-submit">Find showtimes</button>
        </form>
    </div>
</section>

<main id="main">

<!-- Information strip: four facts in one plain row -->
<section class="info-strip" aria-label="At a glance">
    <div class="container">
        <ul>
            <li><i class="bi bi-geo-alt" aria-hidden="true"></i><span><strong><?= count($cinemas) ?> cinemas</strong><small>London, Manchester, Birmingham</small></span></li>
            <li><i class="bi bi-film" aria-hidden="true"></i><span><strong><?= (int) $filmCount ?> films showing</strong><small>Sci-fi to family favourites</small></span></li>
            <li><i class="bi bi-arrow-repeat" aria-hidden="true"></i><span><strong>Free cancellation</strong><small>Up to 24 hours before</small></span></li>
            <li><i class="bi bi-person-wheelchair" aria-hidden="true"></i><span><strong>Accessible seating</strong><small>Wheelchair spaces in Row A</small></span></li>
        </ul>
    </div>
</section>

<!-- Now Showing: films that can be booked. Compact cards: poster, title, one line of facts. -->
<section class="py-4">
    <div class="container">
        <div class="section-head">
            <h2 class="section-title">Now Showing</h2>
            <a href="<?= $url('/movies') ?>" class="section-link">View all films <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
        </div>
        <div class="row g-3 g-lg-4">
            <?php foreach ($nowShowing as $movie): ?>
                <?php
                // Two cards per row on a phone, four on a large screen.
                $cardColumns = 'col-6 col-md-4 col-lg-3';
                $compact = true;
                require $viewsPath . '/partials/movie-card.php';
                ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Coming Soon: listed but not on sale, so the cards have no Book button. -->
<?php if ($comingSoon !== []): ?>
<section class="py-4">
    <div class="container">
        <div class="section-head">
            <h2 class="section-title">Coming Soon</h2>
            <a href="<?= $url('/movies?tab=soon') ?>" class="section-link">View all <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
        </div>
        <p class="text-muted small mb-3">These films are not on sale yet, so they cannot be booked.</p>
        <div class="row g-3 g-lg-4">
            <?php foreach ($comingSoon as $movie): ?>
                <?php
                $cardColumns = 'col-6 col-md-4 col-lg-3';
                $compact = true;
                require $viewsPath . '/partials/movie-card.php';
                ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Choose your cinema. The button links to ?cinema=ID, which saves the choice (see public/index.php,
     step 3b): the header picker, the showtimes and the booking pages then follow it. -->
<section class="py-5">
    <div class="container">
        <div class="section-head">
            <h2 class="section-title">Choose your cinema</h2>
            <a href="<?= $url('/cinemas') ?>" class="section-link">All cinemas <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
        </div>
        <div class="row g-3 g-lg-4">
            <?php foreach ($cinemas as $cinema): ?>
                <?php $isChosen = $selectedCinema !== null && $selectedCinema['id'] === $cinema['id']; ?>
            <div class="col-md-4">
                <div class="card cinema-choice h-100<?= $isChosen ? ' is-chosen' : '' ?>">
                    <img src="<?= $url('/assets/img/' . htmlspecialchars($cinema['image'])) ?>" class="card-img-top" loading="lazy" alt="">
                    <div class="card-body d-flex flex-column">
                        <h3 class="h6 mb-1"><?= htmlspecialchars(preg_replace('/^iCinema - /', '', $cinema['name'])) ?></h3>
                        <p class="text-muted small mb-2"><?= htmlspecialchars($cinema['address']) ?></p>
                        <div class="d-flex flex-wrap gap-1 mb-3">
                            <?php foreach (array_slice($cinema['features'], 0, 3) as $feature): ?>
                            <span class="badge bg-secondary"><?= htmlspecialchars($feature) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <div class="mt-auto d-flex gap-2 align-items-center">
                            <?php if ($isChosen): ?>
                            <span class="btn btn-chosen btn-sm" aria-disabled="true"><i class="bi bi-check2" aria-hidden="true"></i> Your cinema</span>
                            <?php else: ?>
                            <a href="?cinema=<?= (int) $cinema['id'] ?>" class="btn btn-primary btn-sm">Choose this cinema<span class="visually-hidden">: <?= htmlspecialchars($cinema['name']) ?></span></a>
                            <?php endif; ?>
                            <a href="<?= $url('/cinemas') ?>" class="small fw-bold text-decoration-none">Details<span class="visually-hidden"> for <?= htmlspecialchars($cinema['name']) ?></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

</main>
