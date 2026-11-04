<header class="bg-dark text-white py-4 mb-4 shadow-sm border-bottom border-secondary">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Manage Bookings</h1>
            <p class="text-muted small mb-0">View, search, and manage all customer cinema ticket reservations.</p>
        </div>
        <a href="<?= $url('/admin/dashboard') ?>" class="btn btn-outline-light btn-sm rounded-pill px-3">Back to Dashboard</a>
    </div>
</header>


<main id="main" class="container mb-5">
    <div class="card shadow-sm border-0 p-4 bg-white rounded-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead>
                    <tr><th>Reference</th><th>Customer</th><th>Film / Cinema</th><th>When</th><th>Seats</th><th>Total</th><th>Status</th><th class="text-end">Actions</th></tr>
                </thead>
                <tbody>
                            <tr>
                                <td class="font-monospace">ICINEMA-A1B2C3D4</td>
                                <td>Sarah Jones<br><span class="text-muted small">sarah.jones@example.com</span></td>
                                <td>Cosmic Odyssey<br><span class="text-muted small">iCinema - London Leicester Square</span></td>
                                <td class="small">Wed 21 Oct, 7:30 PM</td>
                                <td>D4, D5</td>
                                <td class="fw-bold">&pound;24.00</td>
                                <td><span class="badge bg-success">Confirmed</span></td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-outline-warning mb-1">Cancel</a>
                                    <a href="#" class="btn btn-sm btn-outline-danger mb-1">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-monospace">ICINEMA-B2C3D4E5</td>
                                <td>Sarah Jones<br><span class="text-muted small">sarah.jones@example.com</span></td>
                                <td>Paws &amp; Claws<br><span class="text-muted small">iCinema - Manchester Arndale</span></td>
                                <td class="small">Tue 20 Oct, 1:30 PM</td>
                                <td>C3, C4, C5, C6</td>
                                <td class="fw-bold">&pound;35.00</td>
                                <td><span class="badge bg-success">Confirmed</span></td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-outline-warning mb-1">Cancel</a>
                                    <a href="#" class="btn btn-sm btn-outline-danger mb-1">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-monospace">ICINEMA-C3D4E5F6</td>
                                <td>Tom Baker<br><span class="text-muted small">tom.baker@example.com</span></td>
                                <td>Midnight Heist<br><span class="text-muted small">iCinema - London Leicester Square</span></td>
                                <td class="small">Tue 20 Oct, 9:00 PM</td>
                                <td>B7, B8</td>
                                <td class="fw-bold">&pound;21.50</td>
                                <td><span class="badge bg-success">Confirmed</span></td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-outline-warning mb-1">Cancel</a>
                                    <a href="#" class="btn btn-sm btn-outline-danger mb-1">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-monospace">ICINEMA-D4E5F607</td>
                                <td>Tom Baker<br><span class="text-muted small">tom.baker@example.com</span></td>
                                <td>Laugh Track<br><span class="text-muted small">iCinema - Birmingham Bullring</span></td>
                                <td class="small">Wed 14 Oct, 7:00 PM</td>
                                <td>E1, E2</td>
                                <td class="fw-bold">&pound;24.00</td>
                                <td><span class="badge bg-success">Confirmed</span></td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-outline-warning mb-1">Cancel</a>
                                    <a href="#" class="btn btn-sm btn-outline-danger mb-1">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-monospace">ICINEMA-E5F60718</td>
                                <td>Priya Patel<br><span class="text-muted small">priya.patel@example.com</span></td>
                                <td>The Last Crown<br><span class="text-muted small">iCinema - London Leicester Square</span></td>
                                <td class="small">Sat 24 Oct, 6:15 PM</td>
                                <td>C4</td>
                                <td class="fw-bold">&pound;9.00</td>
                                <td><span class="badge bg-danger">Cancelled</span></td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-outline-success mb-1">Confirm</a>
                                    <a href="#" class="btn btn-sm btn-outline-danger mb-1">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-monospace">ICINEMA-F6071829</td>
                                <td>Priya Patel<br><span class="text-muted small">priya.patel@example.com</span></td>
                                <td>Whispers in the Mist<br><span class="text-muted small">iCinema - Manchester Arndale</span></td>
                                <td class="small">Fri 23 Oct, 10:15 PM</td>
                                <td>E4, E5</td>
                                <td class="fw-bold">&pound;19.00</td>
                                <td><span class="badge bg-success">Confirmed</span></td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-outline-warning mb-1">Cancel</a>
                                    <a href="#" class="btn btn-sm btn-outline-danger mb-1">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-monospace">ICINEMA-0718293A</td>
                                <td>Guest Customer<br><span class="text-muted small">guest@example.com</span></td>
                                <td>Cosmic Odyssey<br><span class="text-muted small">iCinema - London Leicester Square</span></td>
                                <td class="small">Wed 21 Oct, 7:30 PM</td>
                                <td>D6</td>
                                <td class="fw-bold">&pound;9.00</td>
                                <td><span class="badge bg-success">Confirmed</span></td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-outline-warning mb-1">Cancel</a>
                                    <a href="#" class="btn btn-sm btn-outline-danger mb-1">Delete</a>
                                </td>
                            </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>
