<?php
/*
 * Movies page: five programme tabs and eight cards per page, read from MySQL.
 *
 * Data prepared by MovieController::index() and exposed by the ViewRenderer:
 *   $programmes       tab key => label (the five programmes)
 *   $activeProgramme  the selected tab key
 *   $pagination       ['items' => Movie[], 'page', 'pages', 'total', 'perPage']
 */

// Build a page address for the selected tab. http_build_query() turns ['tab' => 'now', 'page' => 2]
// into tab=now&page=2. htmlspecialchars() makes the & safe inside an HTML attribute.
$pageLink = fn(string $tab, int $number): string => htmlspecialchars(
    $url('/movies?' . http_build_query(['tab' => $tab, 'page' => $number])),
    ENT_QUOTES,
    'UTF-8'
);
?>
<header class="bg-dark text-white py-5 mb-5 shadow-sm border-bottom border-secondary">
    <div class="container">
        <h1 class="display-5 fw-bold mb-1">Explore Our Movies</h1>
        <p class="text-muted lead mb-0">Discover what's currently playing, check ratings, and book your tickets.</p>
    </div>
</header>

<main id="main" class="container mb-5">

    <!-- The chosen cinema carries through the whole booking process. -->
    <?php $contextLabel = 'Browsing films at'; require $viewsPath . '/partials/cinema-context.php'; ?>

    <?php if ($searchTerm !== ''): ?>
        <!-- The header search sends ?search=...; title search is built in the next part, so say so. -->
        <div class="alert alert-info" role="status">
            Searching for &ldquo;<?= htmlspecialchars($searchTerm) ?>&rdquo; is not available yet: title search arrives in the next part.
            All films are shown below.
        </div>
    <?php endif; ?>

    <!-- Filters: the form is drawn, but filtering arrives in a later part. Title search is in the header. -->
    <form method="get" action="<?= $url('/movies') ?>" class="card shadow-sm border-0 p-3 p-md-4 mb-4 bg-white rounded-3" role="search">
        <div class="row g-3 align-items-end">
            <div class="col-6 col-md-4">
                <label for="genre" class="form-label fw-bold small text-dark">Genre</label>
                <select id="genre" name="genre" class="form-select">
                    <option value="">All genres</option>
                    <option>Action</option><option>Adventure</option><option>Animation</option><option>Comedy</option>
                    <option>Crime</option><option>Drama</option><option>Family</option><option>Historical</option>
                    <option>Horror</option><option>Mystery</option><option>Romance</option><option>Sci-Fi</option>
                </select>
            </div>
            <div class="col-6 col-md-4">
                <label for="rating" class="form-label fw-bold small text-dark">Age rating</label>
                <select id="rating" name="rating" class="form-select">
                    <option value="">Any</option><option>U</option><option>PG-13</option><option>12A</option><option>15</option><option>18</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button class="btn btn-primary flex-grow-1" type="submit">Search</button>
                <a href="<?= $url('/movies') ?>" class="btn btn-outline-secondary">Reset</a>
            </div>
        </div>
    </form>

    <!-- Programme tabs. Each tab is an ordinary link that reloads the page with ?tab=..., so the
         selected section is part of the address and works without JavaScript. -->
    <nav aria-label="Film programmes">
        <ul class="nav nav-pills gap-2 mb-4">
            <?php foreach ($programmes as $key => $label): ?>
            <li class="nav-item">
                <a class="nav-link<?= $key === $activeProgramme ? ' active' : '' ?>"
                   href="<?= $pageLink($key, 1) ?>"<?= $key === $activeProgramme ? ' aria-current="page"' : '' ?>><?= htmlspecialchars($label) ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <p class="text-dark small mb-3">
        <strong><?= (int) $pagination['total'] ?></strong> films in <?= htmlspecialchars($programmes[$activeProgramme] ?? '') ?>
        (page <?= (int) $pagination['page'] ?> of <?= (int) $pagination['pages'] ?>)
    </p>

    <div class="row g-4">
        <?php foreach ($pagination['items'] as $movie): ?>
            <?php
            // The card decides by itself: a coming soon film (in any tab) gets no Book button.
            require $viewsPath . '/partials/movie-card.php';
            ?>
        <?php endforeach; ?>
    </div>

    <?php if ($pagination['items'] === []): ?>
        <div class="alert alert-light border mt-3" role="status">No films are available in this section.</div>
    <?php endif; ?>

    <!-- Pagination: only shown when there is more than one page. -->
    <?php if ($pagination['pages'] > 1): ?>
    <nav class="mt-5" aria-label="<?= htmlspecialchars($programmes[$activeProgramme] ?? 'Films') ?> pages">
        <ul class="pagination justify-content-center mb-0">
            <?php if ($pagination['page'] > 1): ?>
            <li class="page-item"><a class="page-link" href="<?= $pageLink($activeProgramme, $pagination['page'] - 1) ?>">Previous</a></li>
            <?php endif; ?>

            <?php for ($number = 1; $number <= $pagination['pages']; $number++): ?>
                <?php if ($number === $pagination['page']): ?>
            <li class="page-item active" aria-current="page"><span class="page-link"><?= $number ?></span></li>
                <?php else: ?>
            <li class="page-item"><a class="page-link" href="<?= $pageLink($activeProgramme, $number) ?>"><?= $number ?></a></li>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($pagination['page'] < $pagination['pages']): ?>
            <li class="page-item"><a class="page-link" href="<?= $pageLink($activeProgramme, $pagination['page'] + 1) ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>
</main>
