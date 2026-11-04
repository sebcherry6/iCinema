<?php
/*
 * Support class: opens the one database connection the application uses.
 *
 * PDO (PHP Data Objects) is PHP's built-in database interface. It is NOT the database: MySQL
 * (MariaDB in XAMPP) stores the data, PDO carries requests between PHP and the database server.
 * The pdo_mysql driver (enabled by default in XAMPP) lets PDO speak the MySQL protocol.
 */
namespace App\Support;

// Import PHP's own PDO class so the name below means the built-in PDO, not App\Support\PDO.
use PDO;

final class Database
{
    // static = call it as Database::connect() without creating a Database object first.
    public static function connect(): PDO
    {
        // getenv() reads an environment setting if one exists; otherwise the XAMPP defaults after
        // ?: are used. 127.0.0.1 (not "localhost") forces a normal network connection to MySQL,
        // which avoids socket and named-pipe surprises on Windows.
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        // 3306 is MySQL's standard port. Change this fallback only if XAMPP's MySQL runs on another one.
        $port = getenv('DB_PORT') ?: '3306';
        $name = getenv('DB_NAME') ?: 'icinema';
        $user = getenv('DB_USER') ?: 'icinema';
        $password = getenv('DB_PASS') ?: 'icinema';

        // The DSN (Data Source Name) is one string telling PDO which driver, server and database
        // to use. The username and password are separate arguments, never part of the DSN.
        // utf8mb4 is the character set that stores every Unicode character (accents, emoji).
        $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";

        // new PDO(...) opens the connection. The options array changes PDO's behaviour:
        return new PDO($dsn, $user, $password, [
            // Throw an exception when MySQL reports an error instead of failing silently.
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // Return each row as ['title' => '...'] (named columns), not as numbered values.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // Use real prepared statements: values travel separately from the SQL text, which
            // is what stops SQL injection.
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
}
