<header class="bg-dark text-white py-4 mb-4 shadow-sm border-bottom border-secondary">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Manage Users</h1>
            <p class="text-muted small mb-0">View and manage registered customer and administrator accounts.</p>
        </div>
        <a href="<?= $url('/admin/dashboard') ?>" class="btn btn-outline-light btn-sm rounded-pill px-3">Back to Dashboard</a>
    </div>
</header>


<main id="main" class="container mb-5">
    <div class="card shadow-sm border-0 p-4 bg-white rounded-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Joined</th><th>Bookings</th><th class="text-end">Action</th></tr></thead>
                <tbody>
                        <tr>
                            <td class="fw-bold">Admin</td>
                            <td>admin@icinema.co.uk</td>
                            <td><span class="badge bg-dark">Administrator</span></td>
                            <td class="text-muted">2026-08-20</td>
                            <td><span class="badge bg-primary rounded-pill">0</span></td>
                            <td class="text-end"><span class="text-muted small">Protected</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Sarah Jones</td>
                            <td>sarah.jones@example.com</td>
                            <td><span class="badge bg-success">Registered User</span></td>
                            <td class="text-muted">2026-09-09</td>
                            <td><span class="badge bg-primary rounded-pill">2</span></td>
                            <td class="text-end"><a href="#" class="btn btn-sm btn-outline-danger rounded-pill px-3">Delete</a></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tom Baker</td>
                            <td>tom.baker@example.com</td>
                            <td><span class="badge bg-success">Registered User</span></td>
                            <td class="text-muted">2026-09-19</td>
                            <td><span class="badge bg-primary rounded-pill">2</span></td>
                            <td class="text-end"><a href="#" class="btn btn-sm btn-outline-danger rounded-pill px-3">Delete</a></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Priya Patel</td>
                            <td>priya.patel@example.com</td>
                            <td><span class="badge bg-success">Registered User</span></td>
                            <td class="text-muted">2026-09-29</td>
                            <td><span class="badge bg-primary rounded-pill">2</span></td>
                            <td class="text-end"><a href="#" class="btn btn-sm btn-outline-danger rounded-pill px-3">Delete</a></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Alex Morgan</td>
                            <td>alex.morgan@example.com</td>
                            <td><span class="badge bg-success">Registered User</span></td>
                            <td class="text-muted">2026-10-14</td>
                            <td><span class="badge bg-primary rounded-pill">0</span></td>
                            <td class="text-end"><a href="#" class="btn btn-sm btn-outline-danger rounded-pill px-3">Delete</a></td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>
