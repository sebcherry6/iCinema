<?php
/* Shared customer layout, bottom half: footer, scripts and the closing tags. */
?>
<!-- Footer (shared by every customer page) -->
<footer class="site-footer bg-dark text-white pt-5 pb-3 mt-auto">
    <div class="container">
        <div class="row g-4 pb-4">
            <div class="col-md-5">
                <a class="h4 fw-bold text-white text-decoration-none d-inline-block mb-2" href="<?= $url('/') ?>"><i class="bi bi-film brand-icon" aria-hidden="true"></i> iCinema</a>
                <p class="small footer-text mb-0">An independent boutique cinema with three screens across London, Manchester and Birmingham. Book your seats in a few simple steps.</p>
            </div>
            <div class="col-6 col-md-3">
                <h2 class="h6 text-uppercase footer-heading mb-3">Explore</h2>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-2"><a href="<?= $url('/movies') ?>" class="footer-link text-decoration-none">Movies</a></li>
                    <li class="mb-2"><a href="<?= $url('/cinemas') ?>" class="footer-link text-decoration-none">Our Cinemas</a></li>
                    <li class="mb-2"><a href="<?= $url('/my-bookings') ?>" class="footer-link text-decoration-none">My Bookings</a></li>
                    <li><a href="<?= $url('/support') ?>" class="footer-link text-decoration-none">Support</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-4">
                <h2 class="h6 text-uppercase footer-heading mb-3">Need help?</h2>
                <ul class="list-unstyled small mb-0 footer-text">
                    <li class="mb-2"><i class="bi bi-telephone" aria-hidden="true"></i> 0800 123 4567 (Freephone)</li>
                    <li class="mb-2"><i class="bi bi-envelope" aria-hidden="true"></i> support@icinema.co.uk</li>
                    <li><i class="bi bi-clock" aria-hidden="true"></i> Daily 9:00 AM &ndash; 10:00 PM</li>
                </ul>
            </div>
        </div>
        <div class="border-top border-secondary pt-3 text-center small footer-text">
            &copy; <?= date('Y') ?> iCinema &mdash; All Rights Reserved
        </div>
    </div>
</footer>

<!-- Bootstrap JS (menu dropdown and mobile menu) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= $url('/assets/js/icinema.js') ?>"></script>

</body>
</html>
