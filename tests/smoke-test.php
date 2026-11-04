<?php
/*
 * Session 2 Part 1 smoke test (including the Session 2 header). Run it while XAMPP's Apache and MySQL are running:
 *
 *   php tests/smoke-test.php                               (default: http://localhost/icinema/public)
 *   php tests/smoke-test.php http://localhost/icinema/public
 *   php tests/smoke-test.php http://icinema.test           (if you set up a virtual host)
 *
 * XAMPP ships a command-line PHP: from the project folder run  C:\xampp\php\php.exe tests\smoke-test.php
 *
 * It requests every route in routes/web.php through its CLEAN address and checks the Part 1
 * acceptance table: status codes, a layout on every page, no PHP warnings, the database-backed
 * catalogue (twenty cards on Home, 8 + 4 on the Movies tabs), a film page, safe 404s and that
 * private files are not served. Exit code 0 = every check passed.
 */
// Base address of the site under test; a trailing slash is removed so '$base . "/movies"' is clean.
$base = rtrim($argv[1] ?? 'http://localhost/icinema/public', '/');
// The project root URL (one level above public/) is where the private folders sit under XAMPP.
$root = preg_replace('#/public$#', '', $base);
// Reuse the application's own route table as the list of pages to test.
$routes = require __DIR__ . '/../routes/web.php';

// Fetch a URL and return [status code, body]. ignore_errors lets us read 404/503 pages too.
function fetch(string $url): array
{
    $context = stream_context_create(['http' => ['ignore_errors' => true, 'timeout' => 10]]);
    $body = @file_get_contents($url, false, $context);
    $status = 0;
    if (isset($http_response_header[0]) && preg_match('#HTTP/\S+\s+(\d{3})#', $http_response_header[0], $m)) {
        $status = (int) $m[1];
    }
    return [$status, $body === false ? '' : $body];
}

// Counts failed checks; check() below prints one PASS/FAIL line and updates it.
// Like fetch(), but it does not follow redirects, can send a Cookie header, and also returns the
// response headers. It is needed to see the 303 redirect and the Set-Cookie header of the cinema picker.
function fetchRaw(string $url, string $cookie = ''): array
{
    $http = ['ignore_errors' => true, 'timeout' => 10, 'follow_location' => 0];
    if ($cookie !== '') {
        $http['header'] = 'Cookie: ' . $cookie;
    }
    $body = @file_get_contents($url, false, stream_context_create(['http' => $http]));
    $headers = $http_response_header ?? [];
    $status = 0;
    if (isset($headers[0]) && preg_match('#HTTP/\S+\s+(\d{3})#', $headers[0], $m)) {
        $status = (int) $m[1];
    }
    return [$status, implode("\n", $headers), $body === false ? '' : $body];
}

$failures = 0;
function check(string $label, bool $ok, string $detail = ''): void
{
    global $failures;
    echo ($ok ? '  PASS  ' : '  FAIL  ') . $label . ($ok || $detail === '' ? '' : '  -> ' . $detail) . PHP_EOL;
    if (!$ok) {
        $failures++;
    }
}

// True when PHP printed a warning or error into the page.
function hasPhpMessage(string $body): bool
{
    return (bool) preg_match('/(Warning|Notice|Deprecated|Fatal error|Parse error|Uncaught):/', $body);
}

echo "Testing $base" . PHP_EOL . PHP_EOL . 'Routes (expect 200, a layout, no PHP warnings)' . PHP_EOL;
// Walk the real route table, so a route added later is tested without editing this file.
foreach ($routes as $path => $route) {
    // The pattern route needs a real film ID.
    $address = $path === '/movies/{id}' ? '/movies/1' : $path;
    [$status, $body] = fetch($base . $address);
    check($address, $status === 200 && str_contains($body, '</footer>') && str_contains($body, '<title>') && !hasPhpMessage($body),
        "status $status" . (hasPhpMessage($body) ? ', PHP message in page' : ''));
}

// Session 1 used addresses like index.php?page=movies. Part 1 replaced them with clean paths, so the
// old pattern must not appear in any link on the page.
echo PHP_EOL . 'Clean addresses (the old query-string style is gone from every link)' . PHP_EOL;
[$status, $body] = fetch($base . '/');
check('home page has no old-style links', !str_contains($body, 'index.php?page='));
check('home page links to /movies', str_contains($body, 'href="' . parse_url($base, PHP_URL_PATH) . '/movies"') || str_contains($body, 'href="/movies"'));

// These checks only pass when MySQL is running and db/schema.sql was imported: the card counts
// come from the twelve seeded films and sixty programme memberships.
// substr_count() counts how many times the CSS class of a film card appears in the HTML.
echo PHP_EOL . 'Database-backed catalogue' . PHP_EOL;
[$status, $body] = fetch($base . '/');
check('home: quick-booking bar, Now Showing, Coming Soon and cinema choice',
    str_contains($body, 'quick-book') && str_contains($body, 'Now Showing') && str_contains($body, 'Coming Soon') && str_contains($body, 'Choose your cinema'));
// 8 films on sale + 3 coming soon films = 11 cards on the home page.
check('home: 11 film cards (8 on sale + 3 coming soon)', substr_count($body, 'card movie-card') === 11, 'found ' . substr_count($body, 'card movie-card'));
[$status, $body] = fetch($base . '/movies');
check('/movies: Now Showing page 1 has 8 cards', $status === 200 && substr_count($body, 'card movie-card') === 8, 'found ' . substr_count($body, 'card movie-card'));
check('/movies: pagination is shown', str_contains($body, 'pagination'));
[$status, $body] = fetch($base . '/movies?tab=now&page=2');
check('/movies?tab=now&page=2 has the last film (9 films: 8 + 1)', $status === 200 && substr_count($body, 'card movie-card') === 1, 'found ' . substr_count($body, 'card movie-card'));
[$status, $body] = fetch($base . '/movies?tab=world');
check('/movies?tab=world selects World Cinema', $status === 200 && str_contains($body, 'aria-current="page">World Cinema'));
[$status, $body] = fetch($base . '/movies/1');
check('/movies/1 shows Cosmic Odyssey from MySQL', $status === 200 && str_contains($body, 'Cosmic Odyssey'));
[$status, $body] = fetch($base . '/movies/12');
check('/movies/12 shows the accented title', $status === 200 && str_contains($body, 'La Dernière Danse'));
[$status, $body] = fetch($base . '/showtimes');
check('/showtimes is the booking-step-1 prototype', $status === 200 && str_contains($body, 'booking-step is-current'));
[$status, $body] = fetch($base . '/admin/movies');
check('/admin/movies lists all 12 films', $status === 200 && substr_count($body, 'Delete<span') === 12, 'found ' . substr_count($body, 'Delete<span'));

// The header has three zones (cinema picker, logo, account) plus search and navigation, and the
// visitor's cinema is remembered in a cookie. The picker links use ?cinema=ID; index.php saves the
// cookie and redirects (303) to the same page without that parameter.
echo PHP_EOL . 'Header and cinema picker' . PHP_EOL;
[$status, $body] = fetch($base . '/');
check('header has the logo, cinema picker, search and account menu',
    str_contains($body, 'site-logo') && str_contains($body, 'cinema-picker') && str_contains($body, 'header-search') && str_contains($body, 'Account'));
[$status, $body] = fetch($base . '/made-up');
check('the 404 page also draws the full header', $status === 404 && str_contains($body, 'cinema-picker'));
[$status, $headers] = fetchRaw($base . '/movies?cinema=2&tab=world');
check('?cinema=2 answers 303 and sets the cookie', $status === 303 && str_contains($headers, 'icinema_cinema=2'), "status $status");
// The Location header must end in /movies?tab=world: no cinema= (so a refresh does not repeat the
// choice) and no other website (the address is built from a whitelisted path).
check('the redirect drops cinema= but keeps tab=world', (bool) preg_match('#Location: \S*/movies\?tab=world\s*$#mi', $headers), $headers);
[$status, $headers] = fetchRaw($base . '/?cinema=all');
check('?cinema=all answers 303 and deletes the cookie', $status === 303 && str_contains($headers, 'icinema_cinema=deleted'), "status $status");
// Values that are not a real cinema ID (or the word 'all') must be ignored: the page renders normally
// and no cookie is written.
foreach (['/?cinema=abc', '/?cinema=99', '/?cinema[]=1', '/?cinema='] as $address) {
    [$status, $headers] = fetchRaw($base . $address);
    check($address . ' is ignored (page renders, no cookie)', $status === 200 && !str_contains($headers, 'Set-Cookie'), "status $status");
}
[$status, $headers] = fetchRaw($base . '/made-up?cinema=2');
check('/made-up?cinema=2 is a 404 and sets no cookie', $status === 404 && !str_contains($headers, 'Set-Cookie'), "status $status");
// Now send the cookie back, as a browser would, and check that pages react to it.
// Cinema ID 2 is Manchester Arndale in resources/data/cinemas.php.
[$status, , $body] = fetchRaw($base . '/', 'icinema_cinema=2');
check('with the cookie, the home page shows the chosen cinema', $status === 200 && str_contains($body, 'Your cinema: Manchester Arndale'));
[$status, , $body] = fetchRaw($base . '/cinemas', 'icinema_cinema=2');
check('with the cookie, the Cinemas page marks it "Your cinema"', str_contains($body, 'Your cinema</span>'));
// A cookie is visitor input: an ID that is not in the cinema list, or text with SQL in it, is ignored.
[$status, , $body] = fetchRaw($base . '/', 'icinema_cinema=99');
check('a cookie with an unknown cinema ID is ignored', $status === 200 && !str_contains($body, 'Your cinema:') && str_contains($body, 'Choose cinema'));
[$status, , $body] = fetchRaw($base . '/', "icinema_cinema=2' OR 1=1");
check('a hostile cookie value is ignored', $status === 200 && !str_contains($body, 'Your cinema:'));
[$status, $body] = fetch($base . '/movies?search=dune');
check('/movies?search=dune explains that search arrives in the next part', $status === 200 && str_contains($body, 'title search arrives'));

// Whether a film can be booked is decided by its 'soon' programme row in movie_programmes, on every page. Films 8 (Iron Tide), 10 (Echoes of
// Tokyo) and 12 (La Derniere Danse) are coming soon: they are listed, but there is no Book button, no
// showtimes and no booking page for them. The other nine films can be booked.
echo PHP_EOL . 'Coming soon films cannot be booked' . PHP_EOL;
// Tab by tab: the tab only chooses which films are listed; the Book button follows each film's status.
[$status, $body] = fetch($base . '/movies?tab=soon');
check('Coming Soon tab: 3 films, none with a Book button',
    $status === 200 && substr_count($body, 'card movie-card') === 3 && substr_count($body, 'aria-disabled="true">Coming soon') === 3 && !str_contains($body, 'Book tickets for'));
[$status, $body] = fetch($base . '/movies?tab=world');
check('World Cinema tab: two coming soon films have no Book button, two others do',
    substr_count($body, 'aria-disabled="true">Coming soon') === 2 && substr_count($body, 'Book tickets for') === 2);
[$status, $body] = fetch($base . '/movies?tab=now');
check('Now Showing tab: every film can be booked', substr_count($body, 'Book tickets for') === 8 && !str_contains($body, 'aria-disabled="true">Coming soon'));
// The film page of a coming soon film exists (people can read about it) but offers no booking.
[$status, $body] = fetch($base . '/movies/8');
check('film page of a coming soon film says "Not on sale yet" and links nowhere to booking',
    $status === 200 && str_contains($body, 'Not on sale yet') && !str_contains($body, 'showtimes?film=8') && !str_contains($body, '>Book tickets<'));
[$status, $body] = fetch($base . '/movies/1');
check('film page of a film on sale has a Book tickets link', str_contains($body, '>Book tickets<') && str_contains($body, 'showtimes?film=1'));
// Every booking page must refuse a coming soon film or an unknown film, even if the address is typed by hand.
foreach (['/showtimes?film=8', '/seats-extras?film=10', '/checkout?film=12', '/confirmation?film=8', '/showtimes?film=999'] as $address) {
    [$status, $body] = fetch($base . $address);
    check($address . ' is refused (404)', $status === 404 && !hasPhpMessage($body), "status $status");
}
// The quick-booking drop-down on the home page is built from the films on sale only.
[$status, $body] = fetch($base . '/');
check('quick booking lists films on sale only', str_contains($body, '<option value="1">') && str_contains($body, '<option value="11">')
    && !str_contains($body, '<option value="8">') && !str_contains($body, '<option value="10">') && !str_contains($body, '<option value="12">'));

// The chosen film and day travel through the booking pages in the address (?film=ID&date=YYYY-MM-DD).
echo PHP_EOL . 'The film and the day carry through the booking pages' . PHP_EOL;
[$status, $body] = fetch($base . '/showtimes?film=6');
check('showtimes for film 6 shows Paws & Claws', $status === 200 && str_contains($body, 'Paws &amp; Claws') && !str_contains($body, 'Cosmic Odyssey'));
[$status, $body] = fetch($base . '/showtimes?film=abc');
check('a non-numeric film falls back to the first film on sale', $status === 200 && str_contains($body, 'Cosmic Odyssey'));
// The application works in London time, so the test builds its expected dates in the same zone.
$london = new DateTimeZone('Europe/London');
$in3 = (new DateTimeImmutable('today', $london))->modify('+3 days');
[$status, $body] = fetch($base . '/showtimes?film=1&date=' . $in3->format('Y-m-d'));
check('a date three days ahead is shown', $status === 200 && str_contains($body, 'Showing ' . $in3->format('l j F Y')));
check('the day picker has 8 days and marks one', substr_count($body, 'text-nowrap') === 8 && substr_count($body, 'aria-current="date"') === 1);
$today = (new DateTimeImmutable('today', $london))->format('l j F Y');
// A date that is in the past, impossible (31 February), not a date at all or more than a week ahead
// must not break the page: it becomes today.
foreach (['2020-01-01', '2026-02-31', 'abc', '2099-01-01', '2026-13-45'] as $badDate) {
    [$status, $body] = fetch($base . '/showtimes?film=1&date=' . $badDate);
    check('bad date ' . $badDate . ' becomes today', $status === 200 && str_contains($body, 'Showing ' . $today), "status $status");
}
// The seat page must show the same film and day, and pass them on to checkout in its links.
[$status, $body] = fetch($base . '/seats-extras?film=6&date=' . $in3->format('Y-m-d'));
check('seat page shows the chosen film and day', str_contains($body, 'Paws &amp; Claws') && str_contains($body, $in3->format('D j M Y')));
check('seat page links on with the film and day', str_contains($body, 'checkout?film=6&amp;date=' . $in3->format('Y-m-d')));
[$status, $body] = fetch($base . '/confirmation?film=6');
check('confirmation shows the chosen film', str_contains($body, 'Paws &amp; Claws'));

// The chosen cinema (the icinema_cinema cookie) applies to the whole booking process: the Movies page
// says where the visitor is browsing, the film page and the showtimes list only that cinema's times,
// and the seat, checkout and confirmation pages name it. Cinema IDs: 1 London, 2 Manchester, 3 Birmingham.
// The full cinema names ("iCinema - Birmingham Bullring") appear only in the showtime blocks, not in
// the header picker (which drops the "iCinema - " prefix), so they show which blocks were drawn.
echo PHP_EOL . 'The cinema choice applies to the booking process' . PHP_EOL;
[$status, , $body] = fetchRaw($base . '/showtimes');
check('showtimes with no cinema chosen lists all three cinemas',
    str_contains($body, 'iCinema - London Leicester Square') && str_contains($body, 'iCinema - Manchester Arndale') && str_contains($body, 'iCinema - Birmingham Bullring'));
[$status, , $body] = fetchRaw($base . '/showtimes', 'icinema_cinema=1');
check('showtimes with London chosen lists only London',
    str_contains($body, 'iCinema - London Leicester Square') && !str_contains($body, 'iCinema - Manchester Arndale') && !str_contains($body, 'iCinema - Birmingham Bullring'));
check('the showtime links carry the cinema (/seats-extras?cinema=1)', str_contains($body, 'seats-extras?cinema=1'));
[$status, , $body] = fetchRaw($base . '/movies', 'icinema_cinema=1');
check('/movies with London chosen says "Browsing films at London Leicester Square"', str_contains($body, 'Browsing films at') && str_contains($body, 'London Leicester Square</strong>'));
[$status, , $body] = fetchRaw($base . '/movies');
check('/movies with no cinema chosen asks the visitor to pick one', str_contains($body, 'No cinema chosen'));
[$status, , $body] = fetchRaw($base . '/movies/1', 'icinema_cinema=2');
check('film page with Manchester chosen shows only Manchester times',
    str_contains($body, 'seats-extras?cinema=2') && !str_contains($body, 'seats-extras?cinema=1') && !str_contains($body, 'seats-extras?cinema=3'));
[$status, , $body] = fetchRaw($base . '/seats-extras', 'icinema_cinema=3');
check('seat page names the chosen cinema', str_contains($body, 'iCinema - Birmingham Bullring ('));
[$status, , $body] = fetchRaw($base . '/checkout', 'icinema_cinema=2');
check('checkout summary names the chosen cinema', str_contains($body, 'iCinema - Manchester Arndale'));
[$status, , $body] = fetchRaw($base . '/confirmation', 'icinema_cinema=2');
check('confirmation names the chosen cinema', str_contains($body, 'iCinema - Manchester Arndale'));
// On the Cinemas page every "Browse films" button chooses that cinema, so the header picker follows.
[$status, , $body] = fetchRaw($base . '/cinemas');
check('Cinemas page: each button links to /movies?cinema=ID', str_contains($body, '/movies?cinema=1') && str_contains($body, '/movies?cinema=2') && str_contains($body, '/movies?cinema=3'));
[$status, $headers] = fetchRaw($base . '/movies?cinema=3');
check('/movies?cinema=3 saves Birmingham and redirects to plain /movies',
    $status === 303 && str_contains($headers, 'icinema_cinema=3') && (bool) preg_match('#Location: \S*/movies\s*$#mi', $headers), "status $status");
[$status, , $body] = fetchRaw($base . '/movies', 'icinema_cinema=3');
check('the header picker shows the chosen cinema', str_contains($body, 'Birmingham Bullring</span>') && str_contains($body, 'aria-current="true"'));
// Poster artwork for films 7-12 comes from the database seed.
[$status, $body] = fetch($base . '/movies/7');
check('film 7 uses its own poster (desertrose.png)', str_contains($body, 'desertrose.png'));
[$status, $body] = fetch($base . '/movies/12');
check('film 12 uses its own poster (danse.png)', str_contains($body, 'danse.png'));

// Hostile or broken input must give a normal page or a clean 404, never a PHP warning, a stack
// trace or a database error. The first loop sends bad ?tab= and ?page= values (they must fall
// back safely); the second loop sends addresses that are not routes (they must be 404).
echo PHP_EOL . 'Safe input (bad values never reach SQL or the filesystem)' . PHP_EOL;
foreach (['/movies?tab=nope', '/movies?tab[]=x', '/movies?page=abc', '/movies?page=-5', '/movies?page=99999', '/movies?page[]=2', "/movies?tab=now'%20OR%201=1"] as $address) {
    [$status, $body] = fetch($base . $address);
    check($address . ' still renders a valid page', $status === 200 && str_contains($body, 'card movie-card') && !hasPhpMessage($body), "status $status");
}
foreach (['/made-up', '/movies/999', '/movies/0', '/movies/abc', '/movies/1.5', '/movies/%7Bid%7D', '/movies/1/extra',
          '/index.php', '/..%2f..%2fetc', '/%00', '/admin', '/%3Cscript%3Ealert(1)%3C/script%3E'] as $address) {
    [$status, $body] = fetch($base . $address);
    check($address . ' gives a 404', $status === 404 && !hasPhpMessage($body) && !str_contains($body, '<script>alert'), "status $status");
}
// A literal '{id}' must never match the pattern route (some servers refuse the raw braces with 400).
[$status, $body] = fetch($base . '/movies/{id}');
check('/movies/{id} (literal braces) is refused', ($status === 404 || $status === 400) && !hasPhpMessage($body), "status $status");
[$status, $body] = fetch($base . '/movies/1/');
check('/movies/1/ (final slash) is the same page as /movies/1', $status === 200 && str_contains($body, 'Cosmic Odyssey'));
[$status, $body] = fetch($base . '/made-up%22%3E%3Cb%3Ex');
check('the 404 page never echoes raw HTML from the address', $status === 404 && !str_contains($body, '<b>x'));

// Apache serves real files itself (the rewrite rule skips them) but the private folders must be
// refused by their .htaccess files. They sit one level above public/, hence $root.
echo PHP_EOL . 'Files and private folders' . PHP_EOL;
[$status] = fetch($base . '/assets/css/icinema.css');
check('a real file (CSS) is served directly', $status === 200);
foreach (['/resources/views/home.php', '/app/Models/Movie.php', '/routes/web.php', '/db/schema.sql', '/tests/smoke-test.php'] as $private) {
    [$status] = fetch($root . $private);
    check($private . ' is not downloadable', $status === 403 || $status === 404, "status $status");
}

// Exit code 0 means success, so the script can also be used by other tools.
echo PHP_EOL . ($failures === 0 ? 'All checks passed.' : "$failures check(s) FAILED.") . PHP_EOL;
exit($failures === 0 ? 0 : 1);
