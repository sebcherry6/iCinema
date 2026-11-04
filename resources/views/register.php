<header class="bg-dark text-white py-4 mb-4 shadow-sm border-bottom border-secondary">
    <div class="container">
        <h1 class="h3 fw-bold mb-1">Create an Account</h1>
        <p class="text-muted small mb-0">Register to see your booking history and cancel bookings online.</p>
    </div>
</header>

<main id="main" class="container mb-5" style="max-width: 500px;">
    <div class="card shadow-sm border-0 p-4 rounded-3 bg-white">
        <form method="post" action="<?= $url('/my-bookings') ?>">
            <div class="mb-3">
                <label for="fullName" class="form-label small fw-bold text-dark">Full Name</label>
                <input type="text" class="form-control" id="fullName" name="fullName" placeholder="John Doe">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label small fw-bold text-dark">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="john@example.com">
            </div>
            <div class="mb-4">
                <label for="password" class="form-label small fw-bold text-dark">Password</label>
                <input type="password" class="form-control" id="password" name="password" aria-describedby="pwHelp">
                <div id="pwHelp" class="form-text">At least 8 characters.</div>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill mb-3">Register Account</button>
            <p class="text-center small text-muted mb-0">Already have an account? <a href="<?= $url('/login') ?>" class="text-decoration-none">Log in here</a></p>
        </form>
    </div>
</main>
