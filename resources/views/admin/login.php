<header class="bg-dark text-white py-4 mb-4 shadow-sm border-bottom border-secondary">
    <div class="container">
        <h1 class="h3 fw-bold mb-1">Admin Portal Login</h1>
        <p class="text-muted small mb-0">Authorised personnel only.</p>
    </div>
</header>

<main id="main" class="container mb-5" style="max-width: 450px;">
    <div class="card shadow-sm border-0 p-4 rounded-3 bg-white">
        <form method="post" action="<?= $url('/admin/dashboard') ?>">
            <div class="mb-3">
                <label for="email" class="form-label small fw-bold text-dark">Admin Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-4">
                <label for="password" class="form-label small fw-bold text-dark">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-dark w-100 py-2 fw-bold rounded-pill mb-3">Admin Log In</button>
            <div class="text-center"><a href="<?= $url('/') ?>" class="small text-muted text-decoration-none">Return to Website</a></div>
        </form>
    </div>
</main>
