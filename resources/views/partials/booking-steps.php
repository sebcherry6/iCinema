<?php
/*
 * Booking progress for the four booking routes. Expects $bookingStep (1-4) from the route table
 * and $url from the ViewRenderer; the step paths below are clean paths.
 * One array, one loop: steps before the current one are links ("done"), the current step is
 * marked with aria-current, later steps are plain text.
 */
$bookingSteps = [
  1 => ['label' => 'Showtimes',        'path' => '/showtimes'],
  2 => ['label' => 'Seats &amp; Tickets', 'path' => '/seats-extras'],
  3 => ['label' => 'Checkout',         'path' => '/checkout'],
  4 => ['label' => 'Confirmation',     'path' => '/confirmation'],
];
?>
<nav class="steps card shadow-sm p-3 mb-4" aria-label="Booking progress">
    <ol class="booking-steps">
        <?php foreach ($bookingSteps as $num => $step): ?>
            <?php if ($num < $bookingStep): ?>
        <li class="booking-step is-done"><a href="<?= $url($step['path']) ?>"><span class="step-marker" aria-hidden="true"><?= $num ?></span><span class="booking-step-label"><?= $step['label'] ?><span class="visually-hidden"> (completed)</span></span></a></li>
            <?php elseif ($num === $bookingStep): ?>
        <li class="booking-step is-current" aria-current="step"><span class="step-marker" aria-hidden="true"><?= $num ?></span><span class="booking-step-label"><?= $step['label'] ?></span></li>
            <?php else: ?>
        <li class="booking-step"><span class="step-marker" aria-hidden="true"><?= $num ?></span><span class="booking-step-label"><?= $step['label'] ?></span></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ol>
</nav>
