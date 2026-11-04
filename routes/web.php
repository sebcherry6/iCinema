<?php
/*
 * Route whitelist: the ONLY paths public/index.php is allowed to answer.
 *
 * The visitor supplies a path in the address bar (/movies); this table supplies the View. A
 * visitor never supplies a file name. Anything not listed here is a 404.
 *
 * Fields:
 *   view        file under resources/views/
 *   title       page title (a film page replaces it with the film's own title)
 *   active      navigation item to highlight
 *   layout      'site' (customer) or 'admin'
 *   bookingStep optional 1-4: the booking progress bar number
 *   action      optional Controller method that prepares data for the page
 *               (home, index, show, booking, catalogue); pages without one are static
 *               'booking' covers the four booking pages: it validates ?film= and ?date= and
 *               refuses a coming soon film
 *
 * '/movies/{id}' is a pattern: public/index.php matches digits only (/movies/1) and passes the
 * number to the "show" action. The curly braces are never matched literally.
 *
 * Nineteen routes: 12 customer + 7 administration. Membership and promotion pages are
 * deliberately absent: the client excluded memberships, gift cards and discount codes
 * (interview Q7, Q15). Admin pages are not protected until the authentication session.
 */
return [
  // ---- customer
  '/'               => ['action' => 'home',      'view' => 'home.php',         'title' => 'Home',               'active' => 'home',    'layout' => 'site'],
  '/movies'         => ['action' => 'index',     'view' => 'movies.php',       'title' => 'Movies',             'active' => 'movies',  'layout' => 'site'],
  '/movies/{id}'    => ['action' => 'show',      'view' => 'movie-detail.php', 'title' => 'Movie Details',      'active' => 'movies',  'layout' => 'site'],
  '/showtimes'      => ['action' => 'booking', 'view' => 'showtimes.php',    'title' => 'Showtimes & Tickets', 'active' => 'movies',  'layout' => 'site', 'bookingStep' => 1],
  '/seats-extras'   => ['action' => 'booking', 'view' => 'seats-extras.php', 'title' => 'Seats & Tickets',     'active' => 'movies',  'layout' => 'site', 'bookingStep' => 2],
  '/checkout'       => ['action' => 'booking', 'view' => 'checkout.php',     'title' => 'Checkout',            'active' => 'movies',  'layout' => 'site', 'bookingStep' => 3],
  '/confirmation'   => ['action' => 'booking', 'view' => 'confirmation.php', 'title' => 'Booking Confirmed',   'active' => 'movies',  'layout' => 'site', 'bookingStep' => 4],
  '/cinemas'        => ['view' => 'cinemas.php',      'title' => 'Cinemas',             'active' => 'cinemas', 'layout' => 'site'],
  '/support'        => ['view' => 'support.php',      'title' => 'Support',             'active' => 'support', 'layout' => 'site'],
  '/login'          => ['view' => 'login.php',        'title' => 'Login',               'active' => 'account', 'layout' => 'site'],
  '/register'       => ['view' => 'register.php',     'title' => 'Register',            'active' => 'account', 'layout' => 'site'],
  '/my-bookings'    => ['view' => 'my-bookings.php',  'title' => 'My Bookings',         'active' => 'account', 'layout' => 'site'],
  // ---- administration
  '/admin/login'     => ['view' => 'admin/login.php',     'title' => 'Admin Login', 'active' => '',          'layout' => 'site'],
  '/admin/dashboard' => ['action' => 'catalogue', 'view' => 'admin/dashboard.php', 'title' => 'Dashboard', 'active' => 'dashboard', 'layout' => 'admin'],
  '/admin/movies'    => ['action' => 'catalogue', 'view' => 'admin/movies.php',    'title' => 'Movies',    'active' => 'movies',    'layout' => 'admin'],
  '/admin/showtimes' => ['action' => 'catalogue', 'view' => 'admin/showtimes.php', 'title' => 'Showtimes', 'active' => 'showtimes', 'layout' => 'admin'],
  '/admin/bookings'  => ['view' => 'admin/bookings.php',  'title' => 'Bookings', 'active' => 'bookings', 'layout' => 'admin'],
  '/admin/pricing'   => ['view' => 'admin/pricing.php',   'title' => 'Pricing',  'active' => 'pricing',  'layout' => 'admin'],
  '/admin/users'     => ['view' => 'admin/users.php',     'title' => 'Users',    'active' => 'users',    'layout' => 'admin'],
];
