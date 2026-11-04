<header class="bg-dark text-white py-4 mb-4 shadow-sm border-bottom border-secondary">
    <div class="container">
        <h1 class="h3 fw-bold mb-1">Welcome Back</h1>
        <p class="text-muted small mb-0">Log in to view your tickets and account history.</p>
    </div>
</header>

<main id="main" class="container mb-5" style="max-width: 500px;">
    <div class="card shadow-sm border-0 p-4 rounded-3 bg-white">
        <form method="post" action="<?= $url('/my-bookings') ?>">
            <div class="mb-3">
                <label for="email" class="form-label small fw-bold text-dark">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="john@example.com">
            </div>
            <div class="mb-4">
                <label for="password" class="form-label small fw-bold text-dark">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill mb-3">Log In</button>
            <p class="text-center small text-muted mb-0">Don't have an account? <a href="<?= $url('/register') ?>" class="text-decoration-none fw-bold">Register here</a></p>
            <p class="text-center small text-muted mt-2 mb-0">You don't need an account to book &mdash; <a href="<?= $url('/movies') ?>" class="text-decoration-none">continue as a guest</a>.</p>
        </form>
    </div>
</main>
