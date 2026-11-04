<?php
/*
 * Administration layout, top half: document head, admin top bar and section menu.
 * Admin pages do not use the customer navigation. The ViewRenderer creates $title, $active and $url.
 */
$siteName = 'iCinema Admin';

// Section menu as data (same pattern as the customer navigation).
$adminLinks = [
  ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'bi-speedometer2',    'path' => '/admin/dashboard'],
  ['key' => 'movies',    'label' => 'Movies',    'icon' => 'bi-film',            'path' => '/admin/movies'],
  ['key' => 'showtimes', 'label' => 'Showtimes', 'icon' => 'bi-clock-history',   'path' => '/admin/showtimes'],
  ['key' => 'bookings',  'label' => 'Bookings',  'icon' => 'bi-ticket-detailed', 'path' => '/admin/bookings'],
  ['key' => 'pricing',   'label' => 'Pricing',   'icon' => 'bi-currency-pound',  'path' => '/admin/pricing'],
  ['key' => 'users',     'label' => 'Users',     'icon' => 'bi-people',          'path' => '/admin/users'],
];

require $viewsPath . '/partials/head.php';
?>
<body class="d-flex flex-column min-vh-100 bg-light text-dark">

<a class="skip-link" href="#main">Skip to main content</a>

<!-- Admin top bar -->
<nav class="navbar navbar-dark bg-dark shadow-sm" aria-label="Administration">
    <div class="container d-flex flex-wrap align-items-center justify-content-between gap-2">
        <a class="navbar-brand fw-bold" href="<?= $url('/admin/dashboard') ?>"><i class="bi bi-film brand-icon" aria-hidden="true"></i> iCinema <span class="badge bg-secondary ms-1 align-middle">Admin</span></a>
        <div class="d-flex gap-2">
            <a href="<?= $url('/') ?>" class="btn btn-outline-light btn-sm rounded-pill px-3">View Live Website</a>
            <a href="<?= $url('/admin/login') ?>" class="btn btn-danger btn-sm rounded-pill px-3">Log Out</a>
        </div>
    </div>
</nav>

<!-- Admin section menu (shared by every admin page) -->
<nav class="admin-subnav bg-white border-bottom" aria-label="Admin sections">
    <div class="container">
        <ul class="nav flex-nowrap overflow-auto">
            <?php foreach ($adminLinks as $link): ?>
            <li class="nav-item"><a class="nav-link<?= $active === $link['key'] ? ' active' : '' ?>" href="<?= $url($link['path']) ?>"<?= $active === $link['key'] ? ' aria-current="page"' : '' ?>><i class="bi <?= $link['icon'] ?>" aria-hidden="true"></i> <?= $link['label'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>
