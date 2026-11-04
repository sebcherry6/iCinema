-- =====================================================================================
-- iCinema database: Session 2 Part 1 (XAMPP / MariaDB / MySQL)
--
-- How to run it (XAMPP): start Apache and MySQL, open http://localhost/phpmyadmin/, choose the
-- SERVER-level "Import" tab (do not select a database first), pick this file and click Go.
-- The script creates the database itself. Importing it again RESETS the two catalogue tables
-- (movies and movie_programmes are dropped and rebuilt with the seed data below), so it is the
-- way to pick up any change to the seed data. Later parts add tables for bookings: those must
-- not be dropped here, so this reset is for the catalogue only.
-- =====================================================================================

-- Text in this file is UTF-8 (the French title in the seed data has accents).
SET NAMES utf8mb4;

-- utf8mb4 stores every Unicode character, utf8mb4_unicode_ci compares text case-insensitively.
CREATE DATABASE IF NOT EXISTS icinema
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- Select the database so the statements below belong to it.
USE icinema;

-- Rebuild the catalogue from scratch. movie_programmes first: it points at movies.
DROP TABLE IF EXISTS movie_programmes;
DROP TABLE IF EXISTS movies;

-- ----- Table 1: movies -------------------------------------------------------------------
-- One row per film. Every row has the same columns (the table is the "shape" of a film).
-- The columns follow the client interview (Q2): title, synopsis, age rating, genre, duration,
-- poster and trailer. Whether a film can be booked is NOT stored here: a film is "coming soon" when it
-- has a row for the 'soon' programme in movie_programmes (table 2), and coming soon films cannot be booked.
CREATE TABLE movies (
  id          INT UNSIGNED  NOT NULL AUTO_INCREMENT,   -- unique number, MySQL hands out the next one
  title       VARCHAR(255)  NOT NULL,
  genre       VARCHAR(100)  NOT NULL,
  age_rating  VARCHAR(10)   NOT NULL,                  -- U, PG-13, 12A, 15 or 18
  duration    VARCHAR(20)   NOT NULL,                  -- text such as '2h 42m'
  synopsis    TEXT          NOT NULL,
  poster      VARCHAR(255)  NOT NULL,                  -- file name in public/assets/img/
  trailer_url VARCHAR(255)  NULL,                      -- NULL = no trailer yet
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----- Table 2: movie_programmes -----------------------------------------------------------
-- Links a film to a catalogue section ("programme") and stores its position inside it. A film can
-- be in several programmes without its details being copied. The five names MUST match
-- MovieRepository::PROGRAMMES in PHP.
CREATE TABLE movie_programmes (
  movie_id   INT UNSIGNED NOT NULL,
  programme  ENUM('now', 'special', 'soon', 'family', 'world') NOT NULL,
  sort_order INT NOT NULL,                              -- 1 = first card in that programme
  PRIMARY KEY (movie_id, programme),                    -- a film joins a programme only once
  UNIQUE KEY unique_programme_order (programme, sort_order),
  CONSTRAINT fk_movie_programme_movie FOREIGN KEY (movie_id)
    REFERENCES movies (id) ON DELETE CASCADE            -- deleting a film removes its memberships
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----- Seed data: twelve films ---------------------------------------------------------------
-- Fictional films, each with its own poster in public/assets/img/.
-- Twelve films. Three of them (Iron Tide, Echoes of Tokyo and La Derniere Danse) are in the 'soon'
-- programme below, so they are coming soon: listed, with a film page, but no Book button and the
-- booking pages refuse them. The other nine can be booked.
INSERT INTO movies (id, title, genre, age_rating, duration, synopsis, poster, trailer_url) VALUES
  (1,  'Cosmic Odyssey',            'Sci-Fi / Adventure',   'PG-13', '2h 42m', 'A breathtaking voyage across the edge of the known universe in search of a lost civilization.', 'cosmic_odyssey.png', NULL),
  (2,  'Midnight Heist',            'Action / Crime',       '15',    '1h 50m', 'An elite crew of thieves attempt the impossible bank robbery under cover of a total lunar eclipse.', 'midnight_heist.png', NULL),
  (3,  'Whispers in the Mist',      'Horror / Mystery',     '18',    '1h 35m', 'A secluded mountain town gets enveloped by a strange fog carrying ancient, malevolent spirits.', 'whispers_mist.png', NULL),
  (4,  'Laugh Track',               'Comedy / Romance',     '12A',   '1h 42m', 'Two fierce rival stand-up comedians accidentally sign up for the same couples therapy retreat.', 'laugh_track.png', NULL),
  (5,  'The Last Crown',            'Historical / Drama',   '15',    '2h 10m', 'An epic tale of loyalty, betrayal, and power struggles in medieval Britain.', 'last_crown.png', NULL),
  (6,  'Paws & Claws',              'Animation / Family',   'U',     '1h 28m', 'A mischievous group of household pets team up on a secret mission to save their neighborhood.', 'paws_claws.png', NULL),
  (7,  'Desert Rose',               'Drama / Romance',      '12A',   '2h 05m', 'Two strangers cross a desert on foot and learn that the road changes them both.', 'desertrose.png', NULL),
  (8,  'Iron Tide',                 'Action / Adventure',   '12A',   '1h 58m', 'A salvage crew races a rising storm to recover a sunken research vessel.', 'irontide.png', NULL),
  (9,  'The Clockmaker''s Daughter', 'Fantasy / Family',    'U',     '1h 47m', 'A young inventor repairs her late father''s clocks and finds that each one opens a door to another time.', 'clock.png', NULL),
  (10, 'Echoes of Tokyo',           'Drama / Mystery',      '15',    '2h 12m', 'A translator in Tokyo receives a recording that links three strangers across a single night.', 'echoes.png', NULL),
  (11, 'Little Comet',              'Animation / Family',   'U',     '1h 25m', 'A small comet who is afraid of the dark sets out to find the edge of the night sky.', 'littlecomet.png', NULL),
  (12, 'La Dernière Danse',         'Drama / Romance',      '15',    '1h 56m', 'In Lyon, a retired dancer agrees to coach one final performance for a rival''s granddaughter.', 'danse.png', NULL);

-- ----- Seed data: programme memberships ---------------------------------------------------------
-- A programme is a catalogue section. The 'soon' programme is special: a film that has a 'soon' row is
-- coming soon, and that film cannot be booked, whichever other programmes it is in.
--   now      the nine films on sale, so the Movies page has two pages (8 + 1)
--   soon     the three coming soon films
--   special, family, world   themed lists. They may include a coming soon film (World Cinema does), and that
--            film still has no Book button, because booking depends on the 'soon' row, not on the tab.
INSERT INTO movie_programmes (movie_id, programme, sort_order) VALUES
  (1, 'now', 1), (2, 'now', 2), (3, 'now', 3), (4, 'now', 4), (5, 'now', 5),
  (6, 'now', 6), (7, 'now', 7), (9, 'now', 8), (11, 'now', 9),
  (8, 'soon', 1), (10, 'soon', 2), (12, 'soon', 3),
  (1, 'special', 1), (3, 'special', 2), (5, 'special', 3), (2, 'special', 4),
  (6, 'family', 1), (9, 'family', 2), (11, 'family', 3), (4, 'family', 4),
  (7, 'world', 1), (5, 'world', 2), (10, 'world', 3), (12, 'world', 4);

-- ----- Restricted account for PHP ---------------------------------------------------------------
-- PHP should not connect as root. This account can only READ the two catalogue tables.
-- XAMPP's server may match a connection from 127.0.0.1 as 'localhost' or as '127.0.0.1', so the
-- account is created for both. Later sessions grant more permissions (for example to save bookings).
CREATE USER IF NOT EXISTS 'icinema'@'localhost'  IDENTIFIED BY 'icinema';
CREATE USER IF NOT EXISTS 'icinema'@'127.0.0.1' IDENTIFIED BY 'icinema';
GRANT SELECT ON icinema.movies           TO 'icinema'@'localhost';
GRANT SELECT ON icinema.movie_programmes TO 'icinema'@'localhost';
GRANT SELECT ON icinema.movies           TO 'icinema'@'127.0.0.1';
GRANT SELECT ON icinema.movie_programmes TO 'icinema'@'127.0.0.1';
FLUSH PRIVILEGES;
