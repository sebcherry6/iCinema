<header class="bg-dark text-white py-4 mb-4 shadow-sm border-bottom border-secondary">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Ticket Pricing</h1>
            <p class="text-muted small mb-0">The same prices are used on the seat page, checkout and confirmation email.</p>
        </div>
        <a href="<?= $url('/admin/dashboard') ?>" class="btn btn-outline-light btn-sm rounded-pill px-3">Back to Dashboard</a>
    </div>
</header>


<main id="main" class="container mb-5" style="max-width: 640px;">
    <div class="alert alert-success shadow-sm" role="status">Example message: prices updated. New bookings use them straight away.</div>
    <form method="post" action="<?= $url('/admin/pricing') ?>" class="card shadow-sm border-0 p-4 bg-white rounded-3">
            <div class="row align-items-center mb-3">
                <label for="price_adult" class="col-sm-6 col-form-label fw-bold text-dark">
                    Adult
                    <small class="text-muted d-block fw-normal">1 seat</small>
                </label>
                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-text">&pound;</span>
                        <input type="text" class="form-control" id="price_adult" name="price_adult" value="12.00">
                    </div>
                </div>
            </div>
            <div class="row align-items-center mb-3">
                <label for="price_family" class="col-sm-6 col-form-label fw-bold text-dark">
                    Family Bundle
                    <small class="text-muted d-block fw-normal">4 seats</small>
                </label>
                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-text">&pound;</span>
                        <input type="text" class="form-control" id="price_family" name="price_family" value="35.00">
                    </div>
                </div>
            </div>
            <div class="row align-items-center mb-3">
                <label for="price_student" class="col-sm-6 col-form-label fw-bold text-dark">
                    Student
                    <small class="text-muted d-block fw-normal">1 seat</small>
                </label>
                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-text">&pound;</span>
                        <input type="text" class="form-control" id="price_student" name="price_student" value="9.50">
                    </div>
                </div>
            </div>
            <div class="row align-items-center mb-3">
                <label for="price_senior" class="col-sm-6 col-form-label fw-bold text-dark">
                    Senior (60+)
                    <small class="text-muted d-block fw-normal">1 seat</small>
                </label>
                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-text">&pound;</span>
                        <input type="text" class="form-control" id="price_senior" name="price_senior" value="9.00">
                    </div>
                </div>
            </div>
        <button type="submit" class="btn btn-primary rounded-pill py-2 fw-bold">Save prices</button>
    </form>
</main>
