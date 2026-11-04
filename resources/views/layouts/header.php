<?php
/*
 * Shared customer layout, top half: document head, skip link and the site header.
 * The ViewRenderer creates $title, $active, $url, $cinemas, $selectedCinema and $searchTerm
 * before requiring this file.
 *
 * Layout of the header (desktop):
 *
 *     [ cinema picker ]           iCinema           [ Account menu ]
 *     Home  Movies  Cinemas  Support  [Book Tickets]        [ search films ]
 *
 * On a phone the top row becomes  [ menu button ]  iCinema  [ account icon ]  and the second row
 * holds the cinema picker and the search box. The links sit inside the menu button.
 */
$siteName = 'iCinema';

// Navigation as data: one array, one loop. `key` is compared with $active (set by the route
// table) to mark the current section. Paths are clean paths; $url() adds the site folder prefix.
// (Account and Book Tickets are drawn separately, not as ordinary links.)
$navLinks = [
  ['key' => 'home',    'label' => 'Home',    'path' => '/'],
  ['key' => 'movies',  'label' => 'Movies',  'path' => '/movies'],
  ['key' => 'cinemas', 'label' => 'Cinemas', 'path' => '/cinemas'],
  ['key' => 'support', 'label' => 'Support', 'path' => '/support'],
];

// The Account drop-down. Both guests and staff open it: customers log in or register here and
// staff open the Admin Panel. (Which items appear will depend on who is logged in once login
// exists, in the authentication session.)
$accountLinks = [
  ['label' => 'Login',       'path' => '/login',           'icon' => 'bi-box-arrow-in-right'],
  ['label' => 'Register',    'path' => '/register',        'icon' => 'bi-person-plus'],
  ['divider' => true],
  ['label' => 'My Bookings', 'path' => '/my-bookings',     'icon' => 'bi-ticket-perforated'],
  ['label' => 'Admin Panel', 'path' => '/admin/dashboard', 'icon' => 'bi-speedometer2'],
  ['divider' => true],
  ['label' => 'Log Out',     'path' => '/login',           'icon' => 'bi-box-arrow-right', 'class' => 'text-danger'],
];

require $viewsPath . '/partials/head.php';
?>
<body class="d-flex flex-column min-vh-100 bg-light text-dark">

<a class="skip-link" href="#main">Skip to main content</a>

<header class="site-header">
    <div class="container">

        <!-- Top row: [left] cinema picker (desktop) or menu button (phone) | logo | [right] account -->
        <div class="header-top">
            <div class="header-left">
                <button class="header-btn header-menu-btn d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#siteNav"
                        aria-controls="siteNav" aria-expanded="false" aria-label="Open menu">
                    <i class="bi bi-list" aria-hidden="true"></i>
                </button>
                <div class="d-none d-lg-block">
                    <?php require $viewsPath . '/partials/cinema-picker.php'; ?>
                </div>
            </div>

            <a class="site-logo" href="<?= $url('/') ?>" aria-label="iCinema, home"><span class="logo-i">i</span>Cinema</a>

            <div class="header-right">
                <div class="dropdown">
                    <button class="header-btn dropdown-toggle<?= $active === 'account' ? ' is-current' : '' ?>" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle" aria-hidden="true"></i>
                        <span class="header-btn-text d-none d-sm-inline">Account</span>
                        <span class="visually-hidden d-sm-none">Account</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <?php foreach ($accountLinks as $item): ?>
                            <?php if (isset($item['divider'])): ?>
                        <li><hr class="dropdown-divider"></li>
                            <?php else: ?>
                        <li><a class="dropdown-item<?= isset($item['class']) ? ' ' . $item['class'] : '' ?>" href="<?= $url($item['path']) ?>"><i class="bi <?= $item['icon'] ?> me-2" aria-hidden="true"></i><?= $item['label'] ?></a></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Second row. navbar-expand-lg is the Bootstrap rule that shows the links at once on large
             screens and hides them behind the menu button on small ones. -->
        <div class="header-bottom navbar navbar-expand-lg navbar-dark">
            <div class="header-picker-phone d-lg-none">
                <?php require $viewsPath . '/partials/cinema-picker.php'; ?>
            </div>

            <form class="header-search" role="search" method="get" action="<?= $url('/movies') ?>">
                <label for="headerSearch" class="visually-hidden">Search films by title</label>
                <input id="headerSearch" class="header-search-input" type="search" name="search" placeholder="Search films"
                       value="<?= htmlspecialchars($searchTerm) ?>" maxlength="60" autocomplete="off">
                <button class="header-search-btn" type="submit" aria-label="Search"><i class="bi bi-search" aria-hidden="true"></i></button>
            </form>

            <nav id="siteNav" class="collapse navbar-collapse header-nav" aria-label="Main">
                <ul class="navbar-nav">
                    <?php foreach ($navLinks as $link): ?>
                    <li class="nav-item"><a class="nav-link<?= $active === $link['key'] ? ' active' : '' ?>" href="<?= $url($link['path']) ?>"<?= $active === $link['key'] ? ' aria-current="page"' : '' ?>><?= $link['label'] ?></a></li>
                    <?php endforeach; ?>
                    <li class="nav-item header-book"><a class="btn-book" href="<?= $url('/movies') ?>">Book Tickets</a></li>
                </ul>
            </nav>
        </div>

    </div>
</header>
