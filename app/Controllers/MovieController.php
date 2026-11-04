<?php
/*
 * Controller: prepares the DATA a page needs.
 *
 * A Controller sits between the request and the View. It asks the repository for Movie objects,
 * validates any visitor input (a tab name, a page number, a film ID, a date) and returns a plain
 * array. It contains no SQL (that is the repository's job) and no HTML (that is the View's job).
 *
 * Each public method is an "action": routes/web.php names the action for a route, and
 * public/index.php calls it.
 */
namespace App\Controllers;

use App\Models\MovieRepository;
use DateTimeImmutable;
use DateTimeZone;

final class MovieController
{
    private MovieRepository $movies;

    // The repository is handed in (not created here), so the Controller never touches a database.
    public function __construct(MovieRepository $movies)
    {
        $this->movies = $movies;
    }

    // Action "home": the films on sale, the coming soon films, and the data for the quick-booking bar.
    public function home(): array
    {
        // Page 1 of Now Showing with 8 films, and the first 4 coming soon films.
        $now = $this->movies->paginate('now', 1, 8);
        $soon = $this->movies->paginate('soon', 1, 4);

        return [
            'nowShowing'     => $now['items'],
            'comingSoon'     => $soon['items'],
            // The quick-booking drop-down lists only films that can be booked.
            'bookableMovies' => $this->movies->available(),
            'bookingDays'    => $this->bookingDays($this->today(), $this->today()),
            // The "films showing" fact on the home page is the size of Now Showing.
            'filmCount'      => $now['total'],
        ];
    }

    // Action "index": the Movies page. $query is $_GET: the visitor's ?tab=, ?page= and ?search= values.
    public function index(array $query = []): array
    {
        // Tab: only a plain string that is one of the five known programme keys is accepted.
        // Anything else (missing, an array such as ?tab[]=x, an unknown name) falls back to "now".
        $tab = 'now';
        if (isset($query['tab']) && is_string($query['tab'])
            && array_key_exists($query['tab'], MovieRepository::PROGRAMMES)) {
            $tab = $query['tab'];
        }

        // Page: must be a whole number. filter_var() returns false for text such as "abc".
        // The repository then limits a too-large number to the last real page.
        $page = 1;
        if (isset($query['page']) && is_string($query['page'])) {
            $checked = filter_var($query['page'], FILTER_VALIDATE_INT);
            if ($checked !== false && $checked > 1) {
                $page = $checked;
            }
        }

        // The header search box sends ?search=... Title search is not built yet, so the term is only
        // validated (plain text, trimmed, at most 60 characters) and handed to the page, which tells
        // the visitor that searching arrives in the next part.
        $searchTerm = '';
        if (isset($query['search']) && is_string($query['search'])) {
            $searchTerm = mb_substr(trim($query['search']), 0, 60);
        }

        return [
            'searchTerm'      => $searchTerm,
            'programmes'      => MovieRepository::PROGRAMMES,
            'activeProgramme' => $tab,
            // Eight cards per page; only the selected programme is read from the database.
            'pagination'      => $this->movies->paginate($tab, $page, 8),
        ];
    }

    // Action "show": one film page. Returns null when the ID does not exist.
    public function show(int $id): ?array
    {
        $movie = $this->movies->find($id);
        if ($movie === null) {
            return null;   // public/index.php answers with a 404 page
        }

        return [
            'movie'      => $movie,
            'moreMovies' => $this->movies->others($id, 4),
            'pageTitle'  => $movie->title,    // shown in the browser tab
        ];
    }

    // Action "booking": the four booking pages (showtimes, seats, checkout, confirmation).
    // The booking carries two values in the address: ?film=ID and ?date=YYYY-MM-DD.
    //   * a coming soon film (or one that does not exist) cannot be booked: the answer is null, a 404;
    //   * a missing or non-numeric film falls back to the first film on sale;
    //   * a date that is missing, malformed, in the past or more than a week ahead becomes today
    //     (the client takes bookings up to a week ahead, interview Q3).
    public function booking(array $query): ?array
    {
        // ---- the film
        $movie = null;
        if (isset($query['film']) && is_string($query['film']) && ctype_digit($query['film']) && strlen($query['film']) <= 9) {
            $movie = $this->movies->find((int) $query['film']);
            if ($movie === null || $movie->comingSoon) {
                return null;
            }
        } else {
            $available = $this->movies->available();
            if ($available === []) {
                return null;
            }
            $movie = $available[0];
        }

        // ---- the date
        $today = $this->today();
        $showDate = $today;
        if (isset($query['date']) && is_string($query['date'])) {
            // The "!" makes PHP use midnight, not the current time, for the parsed date.
            $parsed = DateTimeImmutable::createFromFormat('!Y-m-d', $query['date'], $today->getTimezone());
            // getLastErrors() reports a date such as 2026-02-31 that PHP would otherwise roll forward.
            $problems = DateTimeImmutable::getLastErrors();
            $clean = $problems === false || ($problems['warning_count'] === 0 && $problems['error_count'] === 0);
            if ($parsed !== false && $clean && $parsed >= $today && $parsed <= $today->modify('+7 days')) {
                $showDate = $parsed;
            }
        }

        return [
            'movie'          => $movie,
            'pageTitle'      => null,
            'showDate'       => $showDate->format('Y-m-d'),
            'showDateLong'   => $showDate->format('l j F Y'),   // Monday 19 October 2026
            'showDateShort'  => $showDate->format('D j M Y'),   // Mon 19 Oct 2026
            // Appended to every link in the booking process so the film and the day travel with it.
            'bookingQuery'   => http_build_query(['film' => $movie->id, 'date' => $showDate->format('Y-m-d')]),
            'bookingDays'    => $this->bookingDays($today, $showDate),
        ];
    }

    // Action "catalogue": the whole film list for the admin pages (dashboard count, movie
    // table, the film drop-down on the showtimes form).
    public function catalogue(): array
    {
        $all = $this->movies->all();
        return ['allMovies' => $all, 'filmCount' => count($all)];
    }

    // Today's date in the cinema's time zone (the server's own zone could be another country's).
    private function today(): DateTimeImmutable
    {
        return new DateTimeImmutable('today', new DateTimeZone('Europe/London'));
    }

    // The eight days a customer can book: today and the next seven (interview Q3).
    // Each entry: value for the address, a short label, and whether it is the selected day.
    private function bookingDays(DateTimeImmutable $today, DateTimeImmutable $selected): array
    {
        $days = [];
        for ($i = 0; $i <= 7; $i++) {
            $day = $today->modify('+' . $i . ' days');
            $label = $day->format('D j M');
            if ($i === 0) {
                $label = 'Today';
            } elseif ($i === 1) {
                $label = 'Tomorrow';
            }
            $days[] = [
                'value'    => $day->format('Y-m-d'),
                'label'    => $label,
                'selected' => $day->format('Y-m-d') === $selected->format('Y-m-d'),
            ];
        }
        return $days;
    }
}
