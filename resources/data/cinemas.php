<?php
/*
 * Temporary static data source: the three iCinema branches (client interview Q4).
 * public/index.php returns it to the ViewRenderer as $cinemas for the home page strip, the
 * Cinemas page and the admin showtimes form. Films moved to the database in Session 2 Part 1;
 * cinemas follow in a later part. `features` always lists the wheelchair
 * spaces last so that accessible seating is stated for every screen (client interview Q9).
 */
return [
  [
    'id' => 1,
    'name' => 'iCinema - London Leicester Square',
    'address' => '24-26 Cranbourn St, London WC2H 7AA',
    'phone' => '020 7946 0912',
    'features' => ['IMAX', 'VIP Lounge', 'Dolby Atmos', 'Wheelchair spaces'],
    'image' => 'london.png',
  ],
  [
    'id' => 2,
    'name' => 'iCinema - Manchester Arndale',
    'address' => 'Mell Square, Manchester M4 3AQ',
    'phone' => '0161 496 0183',
    'features' => ['IMAX', 'Recliner Seats', 'Snack Bar', 'Wheelchair spaces'],
    'image' => 'Manchester.png',
  ],
  [
    'id' => 3,
    'name' => 'iCinema - Birmingham Bullring',
    'address' => 'Upper Mall West, Bullring, Birmingham B5 4BG',
    'phone' => '0121 496 0541',
    'features' => ['VIP Lounge', '4DX Experience', 'Wheelchair spaces'],
    'image' => 'Birmingham.png',
  ],
];
