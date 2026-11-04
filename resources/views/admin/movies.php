<header class="bg-dark text-white py-4 mb-4 shadow-sm border-bottom border-secondary">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Manage Movies</h1>
            <p class="text-muted small mb-0">Add new releases with posters, synopses and trailers.</p>
        </div>
        <a href="<?= $url('/admin/dashboard') ?>" class="btn btn-outline-light btn-sm rounded-pill px-3">Back to Dashboard</a>
    </div>
</header>


<main id="main" class="container mb-5">
    <div class="alert alert-success py-3 mb-4 shadow-sm border-0" role="status">Example message: movie 'Interstellar 2' has been added.</div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 p-4 bg-white rounded-3">
                <h2 class="h4 fw-bold mb-3 text-dark">Add New Movie</h2>
                <form method="post" action="<?= $url('/admin/movies') ?>">
                    <div class="mb-3">
                        <label for="title" class="form-label small fw-bold">Movie Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="e.g. Interstellar 2">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label small fw-bold">Synopsis</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="trailer_url" class="form-label small fw-bold">YouTube trailer link (optional)</label>
                        <input type="url" class="form-control" id="trailer_url" name="trailer_url" placeholder="https://www.youtube.com/watch?v=...">
                    </div>
                    <div class="mb-3">
                        <label for="genre" class="form-label small fw-bold">Genre</label>
                        <input type="text" class="form-control" id="genre" name="genre" placeholder="e.g. Sci-Fi / Drama">
                    </div>
                    <div class="mb-3">
                        <label for="rating" class="form-label small fw-bold">Age rating</label>
                        <select class="form-select" id="rating" name="rating"><option>U</option><option>PG-13</option><option>12A</option><option>15</option><option>18</option></select>
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label small fw-bold">Duration</label>
                        <input type="text" class="form-control" id="duration" name="duration" placeholder="e.g. 2h 10m">
                    </div>
                    <div class="mb-4">
                        <label for="movie_image" class="form-label small fw-bold">Poster image (JPG, PNG or WEBP)</label>
                        <input type="file" class="form-control" id="movie_image" name="movie_image">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Add Movie</button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0 p-4 bg-white rounded-3">
                <h2 class="h4 fw-bold mb-3 text-dark">Current Catalogue</h2>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead><tr><th>Poster</th><th>ID</th><th>Title</th><th>Genre</th><th>Rating</th><th>Duration</th><th class="text-end">Action</th></tr></thead>
                        <tbody>
                            <?php foreach ($allMovies as $movie): ?>
                            <tr>
                                <td><img src="<?= $url('/assets/img/' . htmlspecialchars($movie->poster)) ?>" alt="" class="rounded" style="width: 40px; height: 55px; object-fit: cover;"></td>
                                <td class="fw-bold">#<?= (int) $movie->id ?></td>
                                <td><?= htmlspecialchars($movie->title) ?><?php if ($movie->comingSoon): ?> <span class="badge bg-secondary">Coming soon</span><?php endif; ?></td>
                                <td class="text-muted small"><?= htmlspecialchars($movie->genre) ?></td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($movie->ageRating) ?></span></td>
                                <td class="text-muted small"><?= htmlspecialchars($movie->duration) ?></td>
                                <td class="text-end"><a href="#" class="btn btn-sm btn-outline-danger">Delete<span class="visually-hidden"> <?= htmlspecialchars($movie->title) ?></span></a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
