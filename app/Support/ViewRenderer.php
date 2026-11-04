<?php
/*
 * Support class: puts a View inside its shared layout.
 *
 * Session 1 did this with `require` lines inside public/index.php. Moving it into a class gives
 * that job one home: the front controller decides WHICH page, the Controller prepares the DATA,
 * and the ViewRenderer draws it. The View files themselves stay in resources/views.
 *
 * The included templates are ordinary PHP files that run INSIDE render(), so the local variables
 * created here ($title, $active, $url, $movie ...) are visible to the layouts, the View and any
 * partial that the View requires.
 */
namespace App\Support;

final class ViewRenderer
{
    // Absolute filesystem path to resources/views (private, outside the web root's reach).
    private string $viewsPath;

    // URL prefix of the site: '' when public/ is the web root, '/icinema/public' under XAMPP's
    // htdocs folder. Every link and asset URL is built from it (see $url below).
    private string $baseUrl;

    // Values every page's layout needs, even the 404 page (the header draws the cinema picker).
    // public/index.php stores them once with share().
    private array $shared = [];

    public function __construct(string $viewsPath, string $baseUrl = '')
    {
        $this->viewsPath = $viewsPath;
        $this->baseUrl = $baseUrl;
    }

    // Store values that every page (including error pages) receives, such as the cinema list.
    public function share(array $values): void
    {
        // The + operator keeps existing keys, so a value shared earlier is not overwritten.
        $this->shared = $values + $this->shared;
    }

    // Draw one route. $route is trusted metadata from routes/web.php; $data is what the
    // Controller prepared for this page (it may be empty for static pages).
    public function render(array $route, array $data = []): void
    {
        // Page data wins over shared data when both define the same key.
        $data += $this->shared;

        // A film page replaces the generic route title with the film's own title.
        $title = (string) ($data['pageTitle'] ?? $route['title']);
        $active = $route['active'];
        $bookingStep = $route['bookingStep'] ?? null;

        // $url('/movies') becomes '/icinema/public/movies' (or '/movies'). Views never write
        // a hard-coded address, so the site works from any folder.
        $url = fn(string $path): string => $this->baseUrl . $path;

        // Templates build their nested includes from this private directory path.
        $viewsPath = $this->viewsPath;

        // Data prepared by the Controller. `?? default` supplies a safe value when a page
        // does not use that piece of data, so the Views never meet an undefined variable.
        $cinemas = $data['cinemas'] ?? [];              // shared: temporary static data (a later part moves it to MySQL)
        $selectedCinema = $data['selectedCinema'] ?? null;  // shared: the cinema the visitor chose, or null
        $searchTerm = (string) ($data['searchTerm'] ?? '');  // the header search box keeps its text

        // The cinema a booking page shows. It is the cinema the visitor chose in the header; until
        // showtimes come from the database (a later part), a booking with no choice falls back to the
        // first cinema, which is the sample booking used by the static pages.
        $bookingCinema = $selectedCinema ?? ($cinemas[0] ?? ['id' => 0, 'name' => 'iCinema', 'features' => ['Standard']]);
        $nowShowing = $data['nowShowing'] ?? [];        // home: the films on sale
        $comingSoon = $data['comingSoon'] ?? [];        // home: films that cannot be booked yet
        $bookableMovies = $data['bookableMovies'] ?? [];  // home: films in the quick-booking list
        $filmCount = $data['filmCount'] ?? 0;           // home and admin dashboard
        // Booking pages: the chosen film and day, and the query string that carries them.
        $bookingDays = $data['bookingDays'] ?? [];      // today and the next seven days
        $showDate = $data['showDate'] ?? '';            // 2026-10-19
        $showDateLong = $data['showDateLong'] ?? '';    // Monday 19 October 2026
        $showDateShort = $data['showDateShort'] ?? '';  // Mon 19 Oct 2026
        $bookingQuery = $data['bookingQuery'] ?? '';    // film=3&date=2026-10-19
        $programmes = $data['programmes'] ?? [];        // movies page: tab key => label
        $activeProgramme = $data['activeProgramme'] ?? 'now';
        $pagination = $data['pagination'] ?? ['items' => [], 'page' => 1, 'pages' => 1, 'total' => 0, 'perPage' => 8];
        $movie = $data['movie'] ?? null;                // film page: one Movie object
        $moreMovies = $data['moreMovies'] ?? [];        // film page: "You might also like"
        $allMovies = $data['allMovies'] ?? [];          // admin pages: the whole catalogue

        // The route metadata chooses the frame: admin pages and customer pages differ.
        if ($route['layout'] === 'admin') {
            require $this->viewsPath . '/layouts/admin-header.php';
            require $this->viewsPath . '/' . $route['view'];
            require $this->viewsPath . '/layouts/admin-footer.php';
            return;
        }

        require $this->viewsPath . '/layouts/header.php';
        require $this->viewsPath . '/' . $route['view'];
        require $this->viewsPath . '/layouts/footer.php';
    }

    // Safe 404 page for an unknown path or a film that does not exist.
    public function notFound(string $requestedPath): void
    {
        // Tell browsers and search engines that this address does not exist.
        http_response_code(404);

        // The shared header expects these variables before it is included.
        $title = 'Page not found';
        $active = '';
        $bookingStep = null;
        $url = fn(string $path): string => $this->baseUrl . $path;
        $viewsPath = $this->viewsPath;
        // The shared header needs the cinema list and the chosen cinema on every page.
        $cinemas = $this->shared['cinemas'] ?? [];
        $selectedCinema = $this->shared['selectedCinema'] ?? null;
        $searchTerm = '';

        require $this->viewsPath . '/layouts/header.php';
        // Leave PHP mode to write the message as ordinary HTML.
        ?>
        <main id="main" class="container py-5">
          <h1 class="mb-3">Page not found</h1>
          <!-- The requested path is visitor input: escape it before it goes into HTML. -->
          <p>There is no page called &quot;<?= htmlspecialchars($requestedPath, ENT_QUOTES, 'UTF-8') ?>&quot;. <a href="<?= $url('/') ?>">Back to Home</a>.</p>
        </main>
        <?php
        require $this->viewsPath . '/layouts/footer.php';
    }

    // Shown when MySQL cannot be reached (for example XAMPP's MySQL is stopped).
    public function databaseUnavailable(): void
    {
        // 503 = the service is temporarily unavailable.
        http_response_code(503);

        $title = 'Catalogue unavailable';
        $active = '';
        $bookingStep = null;
        $url = fn(string $path): string => $this->baseUrl . $path;
        $viewsPath = $this->viewsPath;
        $cinemas = $this->shared['cinemas'] ?? [];
        $selectedCinema = $this->shared['selectedCinema'] ?? null;
        $searchTerm = '';

        require $this->viewsPath . '/layouts/header.php';
        ?>
        <main id="main" class="container py-5">
          <h1 class="mb-3">The film catalogue is unavailable</h1>
          <p>The database could not be reached. On XAMPP, check that <strong>MySQL</strong> is started in the
             Control Panel and that <code>db/schema.sql</code> has been imported in phpMyAdmin, then reload this page.</p>
        </main>
        <?php
        require $this->viewsPath . '/layouts/footer.php';
    }
}
