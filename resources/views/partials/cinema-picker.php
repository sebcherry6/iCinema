<?php
/*
 * Cinema picker: a drop-down in the header that lets the visitor choose their cinema once.
 * The choice is saved in a cookie by public/index.php (step 3b) and every page can read it, so
 * later parts of the course can pre-select that cinema on the showtimes page.
 *
 * Expects: $cinemas (the list), $selectedCinema (one entry or null), $url (link builder).
 * The header includes this file twice (desktop position and phone position); only one of the two
 * is visible at a time, so a screen reader meets it once.
 *
 * Each choice is a plain link to "?cinema=ID". A link that starts with ? keeps the current page,
 * so it works on every page without knowing the address.
 */

// The cinema names are stored as "iCinema - London Leicester Square"; the brand prefix is
// dropped here so the button stays short.
$pickerName = 'Choose cinema';
if ($selectedCinema !== null) {
    $pickerName = preg_replace('/^iCinema - /', '', $selectedCinema['name']);
}
?>
<div class="dropdown cinema-picker">
    <button class="header-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
            aria-label="<?= $selectedCinema === null ? 'Choose your cinema' : 'Your cinema: ' . htmlspecialchars($pickerName) . '. Change cinema' ?>">
        <i class="bi bi-geo-alt" aria-hidden="true"></i>
        <span class="header-btn-text"><?= htmlspecialchars($pickerName) ?></span>
    </button>
    <ul class="dropdown-menu">
        <li><h2 class="dropdown-header">Your cinema</h2></li>
        <?php foreach ($cinemas as $cinema): ?>
            <?php $isSelected = $selectedCinema !== null && $selectedCinema['id'] === $cinema['id']; ?>
        <li>
            <a class="dropdown-item<?= $isSelected ? ' active' : '' ?>" href="?cinema=<?= (int) $cinema['id'] ?>"<?= $isSelected ? ' aria-current="true"' : '' ?>>
                <?= htmlspecialchars(preg_replace('/^iCinema - /', '', $cinema['name'])) ?>
                <?php if ($isSelected): ?><i class="bi bi-check2 ms-1" aria-hidden="true"></i><?php endif; ?>
            </a>
        </li>
        <?php endforeach; ?>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="?cinema=all">All cinemas</a></li>
    </ul>
</div>
