<?php
/*
 * Document head shared by the customer and administration layouts.
 * Expects $title (page title) and $siteName ('iCinema' or 'iCinema Admin') from the layout, and $url
 * from the ViewRenderer. Asset addresses start at the site root ('/assets/...') and are passed
 * through $url(), so the CSS loads from /movies/3 as well as from /.
 */
?>
<!doctype html>
<html lang="en-GB">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> - <?= $siteName ?></title>

    <!-- Bootstrap CSS + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Heading font (falls back to system fonts if offline) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- iCinema theme -->
    <link rel="stylesheet" href="<?= $url('/assets/css/icinema.css') ?>">
</head>
