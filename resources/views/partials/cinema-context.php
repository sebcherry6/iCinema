<?php
/*
 * Cinema context strip: tells the visitor which cinema the page is about, because the choice made
 * in the header picker (or on the Cinemas page) applies to the whole booking process.
 *
 * Expects: $selectedCinema (one entry or null), $url
 * Optional: $contextLabel  the words before the cinema name (default "Showing at")
 *
 * "Show all cinemas" is a link to ?cinema=all, which clears the choice (see public/index.php, 3b).
 */
$contextLabel = $contextLabel ?? 'Showing at';
?>
<div class="cinema-context" role="status">
    <?php if ($selectedCinema !== null): ?>
    <i class="bi bi-geo-alt-fill" aria-hidden="true"></i>
    <span><?= htmlspecialchars($contextLabel) ?> <strong><?= htmlspecialchars(preg_replace('/^iCinema - /', '', $selectedCinema['name'])) ?></strong></span>
    <a href="?cinema=all">Show all cinemas</a>
    <?php else: ?>
    <i class="bi bi-geo-alt" aria-hidden="true"></i>
    <span>No cinema chosen. Pick your cinema in the header to see local showtimes, or browse all three.</span>
    <?php endif; ?>
</div>
