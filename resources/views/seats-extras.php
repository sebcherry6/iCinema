<header class="bg-dark text-white py-4 mb-4 shadow-sm border-bottom border-secondary">
    <div class="container d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-3">
            <img src="<?= $url('/assets/img/' . rawurlencode($movie->poster)) ?>" alt="" class="film-head-poster">
            <div>
                <h1 class="h4 fw-bold mb-1"><?= htmlspecialchars($movie->title) ?></h1>
                <p class="text-muted small mb-0"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> <?= htmlspecialchars($bookingCinema['name']) ?> (<?= htmlspecialchars($bookingCinema['features'][0]) ?>)</p>
                <p class="text-muted small mb-0"><i class="bi bi-calendar-event" aria-hidden="true"></i> <?= htmlspecialchars($showDateShort) ?> &nbsp;&bull;&nbsp; <i class="bi bi-clock" aria-hidden="true"></i> 7:30 PM</p>
            </div>
        </div>
        <a href="<?= htmlspecialchars($url('/showtimes?' . $bookingQuery)) ?>" class="btn btn-outline-light btn-sm"><i class="bi bi-arrow-left" aria-hidden="true"></i> Change cinema, day or time</a>
    </div>
</header>

<main id="main" class="container mb-0">
    <?php require $viewsPath . '/partials/booking-steps.php'; ?>
    <form method="post" action="<?= htmlspecialchars($url('/checkout?' . $bookingQuery)) ?>">
    <div class="row g-4 align-items-start mb-4">

        <!-- 1. Tickets -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 p-4 rounded-3 bg-white">
                <h2 class="h5 fw-bold mb-1 text-dark"><span class="badge bg-primary rounded-circle me-2">1</span>Tickets</h2>
                <p class="text-muted small mb-3">A Family Bundle covers 4 seats. Up to 10 seats per booking.</p>
                <div class="d-flex flex-column gap-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded border">
                        <div>
                            <label for="tickets_adult" class="fw-bold mb-0 text-dark d-block">Adult</label>
                            <small class="text-muted">&pound;12.00 (1 seat)</small>
                        </div>
                        <div style="width: 90px;">
                            <input type="number" id="tickets_adult" name="tickets_adult" class="form-control text-center" value="2" min="0" max="10">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded border">
                        <div>
                            <label for="tickets_family" class="fw-bold mb-0 text-dark d-block">Family Bundle</label>
                            <small class="text-muted">&pound;35.00 (4 seats)<br>2 adults + 2 children</small>
                        </div>
                        <div style="width: 90px;">
                            <input type="number" id="tickets_family" name="tickets_family" class="form-control text-center" value="0" min="0" max="10">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded border">
                        <div>
                            <label for="tickets_student" class="fw-bold mb-0 text-dark d-block">Student</label>
                            <small class="text-muted">&pound;9.50 (1 seat)<br>Valid student ID checked on arrival</small>
                        </div>
                        <div style="width: 90px;">
                            <input type="number" id="tickets_student" name="tickets_student" class="form-control text-center" value="0" min="0" max="10">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded border">
                        <div>
                            <label for="tickets_senior" class="fw-bold mb-0 text-dark d-block">Senior (60+)</label>
                            <small class="text-muted">&pound;9.00 (1 seat)<br>Proof of age checked on arrival</small>
                        </div>
                        <div style="width: 90px;">
                            <input type="number" id="tickets_senior" name="tickets_senior" class="form-control text-center" value="0" min="0" max="10">
                        </div>
                    </div>
                </div>
                <p class="small text-muted mb-0"><i class="bi bi-info-circle" aria-hidden="true"></i> Bring valid ID for Student and Senior tickets &mdash; it is checked on arrival.</p>
            </div>
        </div>

        <!-- 2. Seat map -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 p-4 rounded-3 bg-white">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
                    <div>
                        <h2 class="h5 fw-bold mb-1 text-dark"><span class="badge bg-primary rounded-circle me-2">2</span>Choose your seats</h2>
                        <p class="text-muted small mb-0">Wheelchair spaces are A1 and A2. Taken seats are greyed out.</p>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill"><i class="bi bi-magic" aria-hidden="true"></i> Pick best seats together</button>
                </div>

                <div class="screen-curve">Screen</div>

                <div class="d-flex flex-column gap-2 mb-4 overflow-auto pb-2" role="group" aria-label="Seat map">
                        <div class="d-flex gap-2 align-items-center justify-content-center seat-row">
                            <span class="fw-bold text-dark small" style="width: 1.2rem;" aria-hidden="true">A</span>
                            <input type="checkbox" class="btn-check" id="seat_A1" name="selected_seats[]" value="A1" aria-label="Seat A1, wheelchair space, available">
                            <label class="btn seat-btn btn-outline-info" for="seat_A1" title="Seat A1, wheelchair space, available"><i class="bi bi-person-wheelchair fs-6" aria-hidden="true"></i></label>
                            <input type="checkbox" class="btn-check" id="seat_A2" name="selected_seats[]" value="A2" aria-label="Seat A2, wheelchair space, available">
                            <label class="btn seat-btn btn-outline-info" for="seat_A2" title="Seat A2, wheelchair space, available"><i class="bi bi-person-wheelchair fs-6" aria-hidden="true"></i></label>
                            <input type="checkbox" class="btn-check" id="seat_A3" name="selected_seats[]" value="A3" aria-label="Seat A3, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_A3" title="Seat A3, available">3</label>
                            <input type="checkbox" class="btn-check" id="seat_A4" name="selected_seats[]" value="A4" aria-label="Seat A4, already booked" disabled>
                            <label class="btn seat-btn btn-secondary opacity-50" for="seat_A4" title="Seat A4, already booked">4</label>
                            <span class="seat-aisle" aria-hidden="true"></span>
                            <input type="checkbox" class="btn-check" id="seat_A5" name="selected_seats[]" value="A5" aria-label="Seat A5, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_A5" title="Seat A5, available">5</label>
                            <input type="checkbox" class="btn-check" id="seat_A6" name="selected_seats[]" value="A6" aria-label="Seat A6, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_A6" title="Seat A6, available">6</label>
                            <input type="checkbox" class="btn-check" id="seat_A7" name="selected_seats[]" value="A7" aria-label="Seat A7, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_A7" title="Seat A7, available">7</label>
                            <input type="checkbox" class="btn-check" id="seat_A8" name="selected_seats[]" value="A8" aria-label="Seat A8, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_A8" title="Seat A8, available">8</label>
                            <span class="fw-bold text-dark small text-end" style="width: 1.2rem;" aria-hidden="true">A</span>
                        </div>
                        <div class="d-flex gap-2 align-items-center justify-content-center seat-row">
                            <span class="fw-bold text-dark small" style="width: 1.2rem;" aria-hidden="true">B</span>
                            <input type="checkbox" class="btn-check" id="seat_B1" name="selected_seats[]" value="B1" aria-label="Seat B1, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_B1" title="Seat B1, available">1</label>
                            <input type="checkbox" class="btn-check" id="seat_B2" name="selected_seats[]" value="B2" aria-label="Seat B2, already booked" disabled>
                            <label class="btn seat-btn btn-secondary opacity-50" for="seat_B2" title="Seat B2, already booked">2</label>
                            <input type="checkbox" class="btn-check" id="seat_B3" name="selected_seats[]" value="B3" aria-label="Seat B3, already booked" disabled>
                            <label class="btn seat-btn btn-secondary opacity-50" for="seat_B3" title="Seat B3, already booked">3</label>
                            <input type="checkbox" class="btn-check" id="seat_B4" name="selected_seats[]" value="B4" aria-label="Seat B4, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_B4" title="Seat B4, available">4</label>
                            <span class="seat-aisle" aria-hidden="true"></span>
                            <input type="checkbox" class="btn-check" id="seat_B5" name="selected_seats[]" value="B5" aria-label="Seat B5, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_B5" title="Seat B5, available">5</label>
                            <input type="checkbox" class="btn-check" id="seat_B6" name="selected_seats[]" value="B6" aria-label="Seat B6, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_B6" title="Seat B6, available">6</label>
                            <input type="checkbox" class="btn-check" id="seat_B7" name="selected_seats[]" value="B7" aria-label="Seat B7, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_B7" title="Seat B7, available">7</label>
                            <input type="checkbox" class="btn-check" id="seat_B8" name="selected_seats[]" value="B8" aria-label="Seat B8, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_B8" title="Seat B8, available">8</label>
                            <span class="fw-bold text-dark small text-end" style="width: 1.2rem;" aria-hidden="true">B</span>
                        </div>
                        <div class="d-flex gap-2 align-items-center justify-content-center seat-row">
                            <span class="fw-bold text-dark small" style="width: 1.2rem;" aria-hidden="true">C</span>
                            <input type="checkbox" class="btn-check" id="seat_C1" name="selected_seats[]" value="C1" aria-label="Seat C1, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_C1" title="Seat C1, available">1</label>
                            <input type="checkbox" class="btn-check" id="seat_C2" name="selected_seats[]" value="C2" aria-label="Seat C2, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_C2" title="Seat C2, available">2</label>
                            <input type="checkbox" class="btn-check" id="seat_C3" name="selected_seats[]" value="C3" aria-label="Seat C3, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_C3" title="Seat C3, available">3</label>
                            <input type="checkbox" class="btn-check" id="seat_C4" name="selected_seats[]" value="C4" aria-label="Seat C4, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_C4" title="Seat C4, available">4</label>
                            <span class="seat-aisle" aria-hidden="true"></span>
                            <input type="checkbox" class="btn-check" id="seat_C5" name="selected_seats[]" value="C5" aria-label="Seat C5, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_C5" title="Seat C5, available">5</label>
                            <input type="checkbox" class="btn-check" id="seat_C6" name="selected_seats[]" value="C6" aria-label="Seat C6, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_C6" title="Seat C6, available">6</label>
                            <input type="checkbox" class="btn-check" id="seat_C7" name="selected_seats[]" value="C7" aria-label="Seat C7, already booked" disabled>
                            <label class="btn seat-btn btn-secondary opacity-50" for="seat_C7" title="Seat C7, already booked">7</label>
                            <input type="checkbox" class="btn-check" id="seat_C8" name="selected_seats[]" value="C8" aria-label="Seat C8, already booked" disabled>
                            <label class="btn seat-btn btn-secondary opacity-50" for="seat_C8" title="Seat C8, already booked">8</label>
                            <span class="fw-bold text-dark small text-end" style="width: 1.2rem;" aria-hidden="true">C</span>
                        </div>
                        <div class="d-flex gap-2 align-items-center justify-content-center seat-row">
                            <span class="fw-bold text-dark small" style="width: 1.2rem;" aria-hidden="true">D</span>
                            <input type="checkbox" class="btn-check" id="seat_D1" name="selected_seats[]" value="D1" aria-label="Seat D1, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_D1" title="Seat D1, available">1</label>
                            <input type="checkbox" class="btn-check" id="seat_D2" name="selected_seats[]" value="D2" aria-label="Seat D2, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_D2" title="Seat D2, available">2</label>
                            <input type="checkbox" class="btn-check" id="seat_D3" name="selected_seats[]" value="D3" aria-label="Seat D3, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_D3" title="Seat D3, available">3</label>
                            <input type="checkbox" class="btn-check" id="seat_D4" name="selected_seats[]" value="D4" aria-label="Seat D4, available" checked>
                            <label class="btn seat-btn btn-outline-primary" for="seat_D4" title="Seat D4, available">4</label>
                            <span class="seat-aisle" aria-hidden="true"></span>
                            <input type="checkbox" class="btn-check" id="seat_D5" name="selected_seats[]" value="D5" aria-label="Seat D5, available" checked>
                            <label class="btn seat-btn btn-outline-primary" for="seat_D5" title="Seat D5, available">5</label>
                            <input type="checkbox" class="btn-check" id="seat_D6" name="selected_seats[]" value="D6" aria-label="Seat D6, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_D6" title="Seat D6, available">6</label>
                            <input type="checkbox" class="btn-check" id="seat_D7" name="selected_seats[]" value="D7" aria-label="Seat D7, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_D7" title="Seat D7, available">7</label>
                            <input type="checkbox" class="btn-check" id="seat_D8" name="selected_seats[]" value="D8" aria-label="Seat D8, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_D8" title="Seat D8, available">8</label>
                            <span class="fw-bold text-dark small text-end" style="width: 1.2rem;" aria-hidden="true">D</span>
                        </div>
                        <div class="d-flex gap-2 align-items-center justify-content-center seat-row">
                            <span class="fw-bold text-dark small" style="width: 1.2rem;" aria-hidden="true">E</span>
                            <input type="checkbox" class="btn-check" id="seat_E1" name="selected_seats[]" value="E1" aria-label="Seat E1, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_E1" title="Seat E1, available">1</label>
                            <input type="checkbox" class="btn-check" id="seat_E2" name="selected_seats[]" value="E2" aria-label="Seat E2, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_E2" title="Seat E2, available">2</label>
                            <input type="checkbox" class="btn-check" id="seat_E3" name="selected_seats[]" value="E3" aria-label="Seat E3, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_E3" title="Seat E3, available">3</label>
                            <input type="checkbox" class="btn-check" id="seat_E4" name="selected_seats[]" value="E4" aria-label="Seat E4, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_E4" title="Seat E4, available">4</label>
                            <span class="seat-aisle" aria-hidden="true"></span>
                            <input type="checkbox" class="btn-check" id="seat_E5" name="selected_seats[]" value="E5" aria-label="Seat E5, already booked" disabled>
                            <label class="btn seat-btn btn-secondary opacity-50" for="seat_E5" title="Seat E5, already booked">5</label>
                            <input type="checkbox" class="btn-check" id="seat_E6" name="selected_seats[]" value="E6" aria-label="Seat E6, already booked" disabled>
                            <label class="btn seat-btn btn-secondary opacity-50" for="seat_E6" title="Seat E6, already booked">6</label>
                            <input type="checkbox" class="btn-check" id="seat_E7" name="selected_seats[]" value="E7" aria-label="Seat E7, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_E7" title="Seat E7, available">7</label>
                            <input type="checkbox" class="btn-check" id="seat_E8" name="selected_seats[]" value="E8" aria-label="Seat E8, available">
                            <label class="btn seat-btn btn-outline-primary" for="seat_E8" title="Seat E8, available">8</label>
                            <span class="fw-bold text-dark small text-end" style="width: 1.2rem;" aria-hidden="true">E</span>
                        </div>
                </div>

                <div class="d-flex flex-wrap justify-content-center gap-3 small text-dark pt-3 border-top">
                    <!-- Each swatch is a small copy of the real seat: the .seat-key-* classes and the seats
                         read the same --seat-* colour variables in icinema.css, so they cannot differ. -->
                    <span><span class="seat-key seat-key-available" aria-hidden="true"></span>Available</span>
                    <span><span class="seat-key seat-key-selected" aria-hidden="true"></span>Selected</span>
                    <span><span class="seat-key seat-key-wheelchair" aria-hidden="true"></span>Wheelchair</span>
                    <span><span class="seat-key seat-key-taken" aria-hidden="true"></span>Taken</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Sticky summary bar -->
    <div class="summary-bar">
        <div class="container py-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <div class="small text-muted">Your seats</div>
                <div class="fw-bold text-dark">D4, D5 <span class="text-muted fw-normal small">&nbsp;(2 of 2 needed)</span></div>
            </div>
            <div class="text-end ms-auto">
                <div class="small text-muted">Total</div>
                <div class="h4 fw-bold text-primary mb-0">&pound;24.00</div>
            </div>
            <a href="<?= htmlspecialchars($url('/checkout?' . $bookingQuery)) ?>" class="btn btn-primary btn-lg px-4 fw-bold">Continue to checkout <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>
    </form>
</main>
