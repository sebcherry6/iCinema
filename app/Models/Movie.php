<?php
/*
 * Model: ONE film.
 *
 * A Model is a plain PHP class that gives data a fixed, named shape. In Session 1 a film was an
 * array, so one entry could silently miss a field ('titel' instead of 'title' only fails when the
 * page is drawn). A Movie object cannot be built without every field, and each field has a type,
 * so mistakes are caught where the film is created, not where it is displayed.
 *
 * The fields follow the client interview (Q2): title, synopsis, age rating, genre, duration,
 * poster and trailer. `comingSoon` is true when the film has a row for the 'soon' programme in
 * movie_programmes (computed by MovieRepository): a coming soon film can be listed and read about,
 * but every booking page refuses it.
 */

// A namespace groups related classes, like a package in Java. It matches the folder: app/Models.
namespace App\Models;

// final = this teaching class is not extended anywhere.
final class Movie
{
    // Typed properties: PHP refuses a value of the wrong type (a string where an int is expected).
    public int $id;
    public string $title;
    public string $genre;
    public string $ageRating;      // U, PG-13, 12A, 15 or 18 (client interview Q2)
    public string $duration;       // text such as "2h 42m"
    public string $synopsis;
    public string $poster;         // file name inside public/assets/img/
    public ?string $trailerUrl;    // ?string = text OR null (not every film has a trailer yet)
    public bool $comingSoon;       // true = in the 'soon' programme: shown in the catalogue but NOT bookable

    // The constructor runs once, when `new Movie(...)` is used. Every value must be supplied
    // (except the trailer, which defaults to null), so a Movie is always complete.
    public function __construct(
        int $id,
        string $title,
        string $genre,
        string $ageRating,
        string $duration,
        string $synopsis,
        string $poster,
        ?string $trailerUrl = null,
        bool $comingSoon = false
    ) {
        // $this means "the object being built". Copy each constructor value onto the object.
        $this->id = $id;
        $this->title = $title;
        $this->genre = $genre;
        $this->ageRating = $ageRating;
        $this->duration = $duration;
        $this->synopsis = $synopsis;
        $this->poster = $poster;
        $this->trailerUrl = $trailerUrl;
        $this->comingSoon = $comingSoon;
    }
}
