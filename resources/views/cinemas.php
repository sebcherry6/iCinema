<header class="bg-dark text-white py-5 mb-5 shadow-sm border-bottom border-secondary">
    <div class="container">
        <h1 class="display-5 fw-bold mb-1">Our Cinemas</h1>
        <p class="text-muted lead mb-0">Three independent screens, each with wheelchair spaces in Row A.</p>
    </div>
</header>

<main id="main" class="container mb-5">
    <div class="row g-4">
            <?php foreach ($cinemas as $cinema): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0 h-100 rounded-3 overflow-hidden">
                    <img src="<?= $url('/assets/img/' . htmlspecialchars($cinema['image'])) ?>" class="card-img-top" loading="lazy" alt="<?= htmlspecialchars($cinema['name']) ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <?php if ($selectedCinema !== null && $selectedCinema['id'] === $cinema['id']): ?>
                        <p class="mb-2"><span class="badge bg-primary">Your cinema</span></p>
                        <?php endif; ?>
                        <h2 class="h5 fw-bold text-dark"><?= htmlspecialchars($cinema['name']) ?></h2>
                        <p class="text-muted small mb-1"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> <?= htmlspecialchars($cinema['address']) ?></p>
                        <p class="text-muted small mb-3"><i class="bi bi-telephone-fill" aria-hidden="true"></i> <?= htmlspecialchars($cinema['phone']) ?></p>
                        <div class="d-flex flex-wrap gap-1 mb-3">
                            <?php foreach ($cinema['features'] as $feature): ?>
                            <span class="badge bg-secondary"><?= htmlspecialchars($feature) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <div class="mt-auto pt-2">
                            <!-- ?cinema=ID saves this cinema as the visitor's choice (the header picker changes too), then the Movies page opens. -->
                            <a href="<?= $url('/movies?cinema=' . (int) $cinema['id']) ?>" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Browse films &amp; book<span class="visually-hidden"> at <?= htmlspecialchars($cinema['name']) ?></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
    </div>
</main>
