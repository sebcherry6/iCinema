<?php
/*
 * Repository: the ONLY class that knows the SQL used to read films.
 *
 * Why a separate class? The Controller should say "give me page 2 of the family films" without
 * knowing which tables exist, and a View should never open a database connection. If the table
 * layout changes later, only this file changes.
 *
 * Every method returns Movie objects (never raw rows), so the rest of the application does not
 * care whether a film came from MySQL or from somewhere else.
 */
namespace App\Models;

use PDO;

final class MovieRepository
{
    // The five catalogue sections ("programmes"). The keys must match the ENUM in db/schema.sql;
    // the values are the labels shown to visitors. This is the single PHP list: the Controller
    // and the Views read it from here, and unknown names from a URL are rejected against it.
    public const PROGRAMMES = [
        'now'     => 'Now Showing',
        'special' => 'Special Screenings',
        'soon'    => 'Coming Soon',
        'family'  => 'Family Friendly',
        'world'   => 'World Cinema',
    ];

    // A film is COMING SOON when it has a row for the 'soon' programme in movie_programmes. This one
    // condition is the only place that rule is written; every query below reuses it. "sp" is an alias
    // for a second look at the movie_programmes table, so it does not clash with the "mp" alias that
    // paginate() uses. EXISTS (...) is true (1) when at least one matching row is found.
    private const IS_SOON = "EXISTS (SELECT 1 FROM movie_programmes sp WHERE sp.movie_id = m.id AND sp.programme = 'soon')";

    // The columns every query reads, written once. "m" is the alias of the movies table in each
    // query below. The last column is computed: 1 for a coming soon film, 0 for a film on sale.
    // fromRow() turns exactly these columns into a Movie.
    private const COLUMNS = 'm.id, m.title, m.genre, m.age_rating, m.duration, m.synopsis, m.poster, m.trailer_url, '
        . self::IS_SOON . ' AS coming_soon';

    // The live database connection, handed in by public/index.php.
    private PDO $database;

    public function __construct(PDO $database)
    {
        // The repository receives its connection instead of opening one, so it never needs to
        // know passwords or host names.
        $this->database = $database;
    }

    // One film by its ID, or null when no such film exists.
    public function find(int $id): ?Movie
    {
        // prepare() sends the SQL with a ? placeholder. The ID travels separately in execute(),
        // so the database treats it as data and never as SQL text (no SQL injection).
        $statement = $this->database->prepare('SELECT ' . self::COLUMNS . ' FROM movies m WHERE m.id = ?');
        $statement->execute([$id]);

        // fetch() returns one row, or false when nothing matched.
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            return null;   // the Controller turns null into a 404 page
        }
        return $this->fromRow($row);
    }

    // The whole catalogue ordered by ID (used by the admin pages).
    public function all(): array
    {
        // No visitor value is involved, so query() is enough: there is nothing to bind.
        $statement = $this->database->query('SELECT ' . self::COLUMNS . ' FROM movies m ORDER BY m.id');
        return $this->fromRows($statement->fetchAll(PDO::FETCH_ASSOC));
    }

    // Only the films that can be booked: those WITHOUT a 'soon' row. The booking forms list these films.
    public function available(): array
    {
        $statement = $this->database->query('SELECT ' . self::COLUMNS . ' FROM movies m WHERE NOT ' . self::IS_SOON . ' ORDER BY m.id');
        return $this->fromRows($statement->fetchAll(PDO::FETCH_ASSOC));
    }

    // A few other films for the "You might also like" strip on a film page. Only films that are on
    // sale are suggested, so the strip never offers something that cannot be booked.
    public function others(int $excludeId, int $limit = 4): array
    {
        // $limit is clamped to 1-12 and is an int, so it is safe to place in the SQL text.
        $limit = max(1, min($limit, 12));
        $statement = $this->database->prepare(
            'SELECT ' . self::COLUMNS . ' FROM movies m WHERE m.id <> ? AND NOT ' . self::IS_SOON . ' ORDER BY m.id LIMIT ' . $limit
        );
        $statement->execute([$excludeId]);
        return $this->fromRows($statement->fetchAll(PDO::FETCH_ASSOC));
    }

    // One ordered page of one programme.
    // Returns ['items' => Movie[], 'page' => int, 'pages' => int, 'total' => int, 'perPage' => int].
    public function paginate(string $programme, int $page = 1, int $perPage = 8): array
    {
        // The programme name comes from a URL, so accept only the five known names.
        if (!array_key_exists($programme, self::PROGRAMMES)) {
            $programme = 'now';
        }

        // Keep the page size inside a server-controlled range, whatever the caller asks for.
        $perPage = max(1, min($perPage, 24));

        // movie_programmes links a film to a programme and stores its display order, so one film
        // can appear in several programmes without its details being copied.
        $fromAndWhere = 'FROM movies m
                         JOIN movie_programmes mp ON mp.movie_id = m.id
                         WHERE mp.programme = ?';

        // Count first, so the requested page number can be limited to the real number of pages.
        $count = $this->database->prepare('SELECT COUNT(*) ' . $fromAndWhere);
        $count->execute([$programme]);
        $total = (int) $count->fetchColumn();
        $pages = max(1, (int) ceil($total / $perPage));

        // A page below 1 or above the last page still gives a valid page.
        $page = max(1, min($page, $pages));

        // OFFSET = how many rows to skip. Page 1 skips 0, page 2 skips $perPage, and so on.
        // $perPage and $offset are validated ints, so they are safe inside the SQL text.
        $offset = ($page - 1) * $perPage;

        $statement = $this->database->prepare(
            'SELECT ' . self::COLUMNS . ' ' . $fromAndWhere
            . ' ORDER BY mp.sort_order LIMIT ' . $perPage . ' OFFSET ' . $offset
        );
        $statement->execute([$programme]);

        return [
            'items'   => $this->fromRows($statement->fetchAll(PDO::FETCH_ASSOC)),
            'page'    => $page,
            'pages'   => $pages,
            'total'   => $total,
            'perPage' => $perPage,
        ];
    }

    // Turn a list of database rows into a list of Movie objects.
    private function fromRows(array $rows): array
    {
        $movies = [];
        foreach ($rows as $row) {
            $movies[] = $this->fromRow($row);
        }
        return $movies;
    }

    // Turn ONE database row into a Movie. All conversion happens here, in one place.
    private function fromRow(array $row): Movie
    {
        // The (int)/(string) casts matter: some database drivers return every value as a string.
        // trailer_url is NULL in the database for films without a trailer, so it stays null.
        // coming_soon is 1 or 0 (computed by IS_SOON); the cast also copes with a driver that returns "1".
        return new Movie(
            (int) $row['id'],
            (string) $row['title'],
            (string) $row['genre'],
            (string) $row['age_rating'],
            (string) $row['duration'],
            (string) $row['synopsis'],
            (string) $row['poster'],
            $row['trailer_url'] === null ? null : (string) $row['trailer_url'],
            (int) $row['coming_soon'] === 1
        );
    }
}
