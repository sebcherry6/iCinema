<?php
/* Administration layout, bottom half: slim footer, scripts and the closing tags. */
?>
<footer class="site-footer bg-dark text-white py-3 mt-auto">
    <div class="container d-flex flex-wrap justify-content-between gap-2 small footer-text">
        <span>iCinema Admin &mdash; Session 2 prototype (films are read from the database; nothing is saved yet)</span>
        <a href="<?= $url('/') ?>" class="footer-link text-decoration-none">Back to the website</a>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= $url('/assets/js/icinema.js') ?>"></script>

</body>
</html>
