<?php
/*
 * Public front controller: the ONLY PHP file the browser reaches.
 *
 * Every address that is not a real file (/movies, /movies/3, /admin/dashboard ...) is handed to
 * this file by public/.htaccess. It then:
 *   1. works out where the site lives (a folder under XAMPP's htdocs, or the web root),
 *   2. reads the requested path and finds it in the route whitelist,
 *   3. asks a Controller to prepare the page's data (for routes that have an action),
 *   4. asks the ViewRenderer to draw the View inside its layout.
 */

use App\Controllers\MovieController;
use App\Models\MovieRepository;
use App\Support\Database;
use App\Support\ViewRenderer;

// This file is inside public/. Its parent folder is the private project root, so every include
// below is built from a real filesystem path, independent of the URL the visitor typed.
$basePath = dirname(__DIR__);

// There is no autoloader yet: each class file is required by hand, so the path from a class
// name to its file stays visible. (An autoloader is a later improvement.)
require $basePath . '/app/Models/Movie.php';
require $basePath . '/app/Models/MovieRepository.php';
require $basePath . '/app/Support/Database.php';
require $basePath . '/app/Support/ViewRenderer.php';
require $basePath . '/app/Controllers/MovieController.php';

// The trusted route whitelist.
$routes = require $basePath . '/routes/web.php';

// ---- 1. Where does the site live? ------------------------------------------------------------
// SCRIPT_NAME is the URL of this file: '/icinema/public/index.php' under XAMPP htdocs, or
// '/index.php' when public/ is the web root. Its folder part is the base URL of the site.
// dirname('/index.php') is '/', and rtrim() turns that into '' (no prefix).
$baseUrl = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/index.php')), '/');

// The ViewRenderer needs the base URL to build links, and the views path to find templates.
$viewRenderer = new ViewRenderer($basePath . '/resources/views', $baseUrl);

// ---- 2. Which path was requested? ------------------------------------------------------------
// REQUEST_URI is the path plus any ?query string. parse_url() keeps only the path; it can return
// null/false for a malformed address, which is treated as the home path.
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if (!is_string($requestPath)) {
    $requestPath = '/';
}

// Remove the folder prefix so '/icinema/public/movies' becomes '/movies'.
// The comparison ignores upper/lower case (strncasecmp) because Windows treats the folders
// 'iCinema' and 'icinema' as the same folder, so a visitor may type either spelling while
// SCRIPT_NAME reports the other. The check also looks at the next character, so
// '/icinema/publicity' is not mistaken for the site folder.
$baseLength = strlen($baseUrl);
if ($baseUrl !== ''
    && strncasecmp($requestPath, $baseUrl, $baseLength) === 0
    && (strlen($requestPath) === $baseLength || $requestPath[$baseLength] === '/')) {
    $requestPath = substr($requestPath, $baseLength);
}

// Remove a final slash ('/movies/' and '/movies' are the same page). The home path '/' becomes an
// empty string after trimming, so ?: '/' puts it back.
$path = rtrim($requestPath, '/') ?: '/';

// ---- 2b. Shared data: the cinema list and the cinema the visitor chose -----------------------------
// Every page header shows a cinema picker, so this is prepared before routing (the 404 page needs
// it too). The cinemas are still a static PHP file in this part of the course.
$cinemas = require $basePath . '/resources/data/cinemas.php';

// The choice is remembered in a cookie called icinema_cinema that holds a cinema ID. A cookie is
// visitor input, so it is validated: digits only, and the ID must exist in the cinema list.
$selectedCinema = null;
if (isset($_COOKIE['icinema_cinema']) && is_string($_COOKIE['icinema_cinema']) && ctype_digit($_COOKIE['icinema_cinema'])) {
    foreach ($cinemas as $cinema) {
        if ($cinema['id'] === (int) $_COOKIE['icinema_cinema']) {
            $selectedCinema = $cinema;
        }
    }
}
$viewRenderer->share(['cinemas' => $cinemas, 'selectedCinema' => $selectedCinema]);

// ---- 3. Find the route in the whitelist ------------------------------------------------------
$params = [];
if (preg_match('#^/movies/([1-9][0-9]{0,8})$#', $path, $matches)) {
    // A film page: digits only (no leading zero, at most nine digits). The number is data for the
    // "show" action; the route entry itself is the pattern '/movies/{id}'.
    $route = $routes['/movies/{id}'];
    $params['id'] = (int) $matches[1];
} elseif (str_contains($path, '{')) {
    // Never let a visitor match the pattern key literally by typing '/movies/{id}'.
    $route = null;
} else {
    // Exact lookup; an unknown path gives null instead of a file name.
    $route = $routes[$path] ?? null;
}

if ($route === null) {
    $viewRenderer->notFound($path);
    exit;
}

// ---- 3b. Choosing a cinema: any page address followed by ?cinema=2 (or ?cinema=all) -------------
// The header's cinema picker links to ?cinema=ID. We save the choice in a cookie and redirect to the
// same page without that parameter (so refreshing does not repeat it). This runs only for a valid
// route, which means the redirect address is built from a whitelisted path and can never point to
// another website.
if (isset($_GET['cinema']) && is_string($_GET['cinema'])) {
    $choice = $_GET['cinema'];
    $chosenId = null;
    foreach ($cinemas as $cinema) {
        if (ctype_digit($choice) && $cinema['id'] === (int) $choice) {
            $chosenId = $cinema['id'];
        }
    }

    // Anything other than a real cinema ID or the word "all" is ignored and the page renders normally.
    if ($chosenId !== null || $choice === 'all') {
        setcookie('icinema_cinema', $chosenId !== null ? (string) $chosenId : '', [
            // One year to remember a cinema; a time in the past deletes the cookie ("all cinemas").
            'expires'  => $chosenId !== null ? time() + 60 * 60 * 24 * 365 : time() - 3600,
            // '/' because the visitor may type the folder name in a different letter case.
            'path'     => '/',
            // JavaScript does not need to read it, and it is only sent with same-site navigation.
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        // Rebuild the address without the cinema parameter and keep any other query values.
        $remaining = $_GET;
        unset($remaining['cinema']);
        $target = $baseUrl . $path;
        if ($remaining !== []) {
            $target .= '?' . http_build_query($remaining);
        }
        // 303 See Other: "now fetch this address with GET".
        header('Location: ' . $target, true, 303);
        exit;
    }
}

// ---- 4. Prepare the data, then draw the page -------------------------------------------------
// Data prepared for this page. (The cinema list and the chosen cinema were shared with the
// ViewRenderer in step 2b, so every page and error page can draw the header.)
$data = [];

// Only routes with an "action" need the database and a Controller; static pages skip this block.
if (isset($route['action'])) {
    try {
        $controller = new MovieController(new MovieRepository(Database::connect()));

        if ($route['action'] === 'home') {
            $data += $controller->home();
        } elseif ($route['action'] === 'index') {
            // $_GET carries ?tab= and ?page=; the Controller validates both.
            $data += $controller->index($_GET);
        } elseif ($route['action'] === 'show') {
            $movieData = $controller->show($params['id']);
            if ($movieData === null) {
                // Well-formed ID, but no such film: a 404 page, not a PHP error.
                $viewRenderer->notFound($path);
                exit;
            }
            $data += $movieData;
        } elseif ($route['action'] === 'booking') {
            // The booking pages need a film that can be booked. A coming soon film, or a film that
            // does not exist, gives null and therefore a 404 page.
            $bookingData = $controller->booking($_GET);
            if ($bookingData === null) {
                $viewRenderer->notFound($path);
                exit;
            }
            $data += $bookingData;
        } elseif ($route['action'] === 'catalogue') {
            $data += $controller->catalogue();
        }
    } catch (PDOException $e) {
        // MySQL stopped, wrong password or the schema was not imported. Log the technical detail
        // (Apache's error log) and show a friendly page instead of a PHP stack trace.
        error_log('iCinema database error: ' . $e->getMessage());
        $viewRenderer->databaseUnavailable();
        exit;
    }
}

$viewRenderer->render($route, $data);
