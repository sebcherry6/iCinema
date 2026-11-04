<header class="bg-dark text-white py-4 mb-4 shadow-sm border-bottom border-secondary">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Manage Showtimes</h1>
            <p class="text-muted small mb-0">Schedule movies across cinema branches and screen formats.</p>
        </div>
        <a href="<?= $url('/admin/dashboard') ?>" class="btn btn-outline-light btn-sm rounded-pill px-3">Back to Dashboard</a>
    </div>
</header>


<main id="main" class="container mb-5">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 p-4 bg-white rounded-3">
                <h2 class="h4 fw-bold mb-3 text-dark">Add Screening</h2>
                <form method="post" action="<?= $url('/admin/showtimes') ?>">
                    <div class="mb-3">
                        <label for="movie_id" class="form-label small fw-bold">Film</label>
                        <select class="form-select" id="movie_id" name="movie_id">
                            <?php foreach ($allMovies as $movie): ?>
                            <?php if (!$movie->comingSoon): /* a coming soon film cannot be scheduled yet */ ?>
                            <option><?= htmlspecialchars($movie->title) ?></option>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cinema_id" class="form-label small fw-bold">Cinema</label>
                        <select class="form-select" id="cinema_id" name="cinema_id">
                            <?php foreach ($cinemas as $cinema): ?>
                            <option><?= htmlspecialchars($cinema['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="screen_type" class="form-label small fw-bold">Screen type</label>
                        <select class="form-select" id="screen_type" name="screen_type"><option>Standard</option><option>IMAX</option><option>VIP</option><option>4DX</option><option>Recliner</option></select>
                    </div>
                    <div class="mb-4">
                        <label for="screening_times" class="form-label small fw-bold">Times (comma separated)</label>
                        <input type="text" class="form-control" id="screening_times" name="screening_times" placeholder="e.g. 1:00 PM, 4:15 PM, 7:30 PM" aria-describedby="timesHelp">
                        <div id="timesHelp" class="form-text">Use the format 7:30 PM.</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Add Screening</button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0 p-4 bg-white rounded-3">
                <h2 class="h4 fw-bold mb-3 text-dark">Active Schedule</h2>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead><tr><th>Film</th><th>Cinema</th><th>Screen</th><th>Daily times</th><th class="text-end">Action</th></tr></thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold">Cosmic Odyssey</td>
                                <td class="small text-muted">iCinema - London Leicester Square</td>
                                <td><span class="badge bg-secondary">IMAX</span></td>
                                <td class="small font-monospace">1:00 PM, 4:15 PM, 7:30 PM</td>
                                <td class="text-end"><a href="#" class="btn btn-sm btn-outline-danger">Delete</a></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Cosmic Odyssey</td>
                                <td class="small text-muted">iCinema - Manchester Arndale</td>
                                <td><span class="badge bg-secondary">IMAX</span></td>
                                <td class="small font-monospace">2:00 PM, 6:45 PM</td>
                                <td class="text-end"><a href="#" class="btn btn-sm btn-outline-danger">Delete</a></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Cosmic Odyssey</td>
                                <td class="small text-muted">iCinema - Birmingham Bullring</td>
                                <td><span class="badge bg-secondary">4DX</span></td>
                                <td class="small font-monospace">12:30 PM, 3:15 PM, 6:00 PM</td>
                                <td class="text-end"><a href="#" class="btn btn-sm btn-outline-danger">Delete</a></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Midnight Heist</td>
                                <td class="small text-muted">iCinema - London Leicester Square</td>
                                <td><span class="badge bg-secondary">Standard</span></td>
                                <td class="small font-monospace">3:00 PM, 6:00 PM, 9:00 PM</td>
                                <td class="text-end"><a href="#" class="btn btn-sm btn-outline-danger">Delete</a></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Whispers in the Mist</td>
                                <td class="small text-muted">iCinema - Manchester Arndale</td>
                                <td><span class="badge bg-secondary">Standard</span></td>
                                <td class="small font-monospace">8:00 PM, 10:15 PM</td>
                                <td class="text-end"><a href="#" class="btn btn-sm btn-outline-danger">Delete</a></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Laugh Track</td>
                                <td class="small text-muted">iCinema - Birmingham Bullring</td>
                                <td><span class="badge bg-secondary">VIP</span></td>
                                <td class="small font-monospace">4:00 PM, 7:00 PM</td>
                                <td class="text-end"><a href="#" class="btn btn-sm btn-outline-danger">Delete</a></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">The Last Crown</td>
                                <td class="small text-muted">iCinema - London Leicester Square</td>
                                <td><span class="badge bg-secondary">VIP</span></td>
                                <td class="small font-monospace">2:30 PM, 6:15 PM</td>
                                <td class="text-end"><a href="#" class="btn btn-sm btn-outline-danger">Delete</a></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Paws &amp; Claws</td>
                                <td class="small text-muted">iCinema - Manchester Arndale</td>
                                <td><span class="badge bg-secondary">Recliner</span></td>
                                <td class="small font-monospace">11:00 AM, 1:30 PM, 4:00 PM</td>
                                <td class="text-end"><a href="#" class="btn btn-sm btn-outline-danger">Delete</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
