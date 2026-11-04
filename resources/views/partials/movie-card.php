<?php
/*
 * One film card. Used by the home page and the Movies page, so the card is written once.
 *
 * Expects:  $movie        a Movie object (see app/Models/Movie.php)
 * Optional: $cardColumns  Bootstrap column classes (default: three cards per row on large screens)
 *           $compact      true = poster, title and one line of facts only (used on the home page)
 * $url is the link-building function created by the ViewRenderer.
 *
 * A coming soon film ($movie->comingSoon) is listed but cannot be booked: it gets a "Coming soon"
 * label on the poster and a disabled button instead of Book. This follows the film's membership of the
 * 'soon' programme, not the tab it is shown in, so it holds on every page.
 *
 * Every database value is escaped with htmlspecialchars() before it is written into HTML.
 */
$cardColumns = $cardColumns ?? 'col-12 col-sm-6 col-lg-4';
$compact = $compact ?? false;
?>
<div class="<?= htmlspecialchars($cardColumns) ?>">
    <div class="card movie-card<?= $compact ? ' movie-card-compact' : '' ?> h-100">
        <a class="poster-wrap d-block" href="<?= $url('/movies/' . (int) $movie->id) ?>" tabindex="-1" aria-hidden="true">
            <img src="<?= $url('/assets/img/' . rawurlencode($movie->poster)) ?>" class="card-img-top" loading="lazy" alt="">
            <span class="badge bg-secondary poster-badge" title="Age rating"><?= htmlspecialchars($movie->ageRating) ?></span>
            <?php if ($movie->comingSoon): ?><span class="poster-status">Coming soon</span><?php endif; ?>
        </a>
        <div class="card-body d-flex flex-column">
            <h3 class="h5 card-title mb-1"><a class="card-title-link" href="<?= $url('/movies/' . (int) $movie->id) ?>"><?= htmlspecialchars($movie->title) ?></a></h3>
            <p class="text-muted small mb-2"><?= htmlspecialchars($movie->genre) ?> &bull; <?= htmlspecialchars($movie->duration) ?></p>
            <?php if (!$compact): ?>
            <p class="card-text text-muted small flex-grow-1"><?= htmlspecialchars($movie->synopsis) ?></p>
            <?php endif; ?>
            <div class="d-flex gap-2 mt-auto pt-2 card-actions">
                <!-- The film page address contains the film's database ID: /movies/3 -->
                <a href="<?= $url('/movies/' . (int) $movie->id) ?>" class="btn btn-outline-primary flex-fill btn-sm" aria-label="Details for <?= htmlspecialchars($movie->title) ?>">Details</a>
                <?php if (!$movie->comingSoon): ?>
                <a href="<?= $url('/showtimes?film=' . (int) $movie->id) ?>" class="btn btn-primary flex-fill btn-sm" aria-label="Book tickets for <?= htmlspecialchars($movie->title) ?>">Book</a>
                <?php else: ?>
                <span class="btn btn-soon flex-fill btn-sm" aria-disabled="true">Coming soon</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
