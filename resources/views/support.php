<header class="bg-dark text-white py-5 mb-5 shadow-sm border-bottom border-secondary">
    <div class="container">
        <h1 class="display-5 fw-bold">Customer Support &amp; Help</h1>
        <p class="text-muted lead mb-0">Have a question about your booking or need assistance? We're here to help.</p>
    </div>
</header>

<main id="main" class="container mb-5">
    <div class="row g-5">

        <div class="col-lg-7">
            <div class="card shadow-sm border-0 p-4 p-md-5 rounded-3 bg-white">
                <h2 class="h3 fw-bold mb-3 text-dark">Send Us a Message</h2>
                <p class="text-muted small mb-4">Fill out the form below and our UK support team will get back to you promptly.</p>
                <form method="post" action="<?= $url('/support') ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label small fw-bold text-dark">Your Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="John Doe">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label small fw-bold text-dark">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="john@example.com">
                        </div>
                        <div class="col-md-12">
                            <label for="subject" class="form-label small fw-bold text-dark">Subject / Inquiry Type</label>
                            <select class="form-select" id="subject" name="subject">
                                <option value="">Select a topic...</option>
                                <option>Booking or Ticket Issue</option>
                                <option>Refund Request</option>
                                <option>Accessibility &amp; Special Assistance</option>
                                <option>General Question</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="message" class="form-label small fw-bold text-dark">Message Details</label>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Please describe how we can help you..."></textarea>
                        </div>
                        <div class="col-md-12 pt-2">
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill">Submit Enquiry</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm border-0 p-4 mb-4 bg-light rounded-3">
                <h2 class="h4 fw-bold mb-3 text-dark">Need Immediate Assistance?</h2>
                <p class="text-muted small mb-3">You can also reach our customer service hotline or visit us directly during opening hours.</p>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-2"><strong>Phone Helpline:</strong> 0800 123 4567 (Freephone)</li>
                    <li class="mb-2"><strong>Hours:</strong> Mon&ndash;Sun: 9:00 AM &ndash; 10:00 PM</li>
                    <li class="mb-0"><strong>Email:</strong> support@icinema.co.uk</li>
                </ul>
            </div>

            <div class="card shadow-sm border-0 p-4 rounded-3 bg-white">
                <h2 class="h4 fw-bold mb-3 text-dark">Frequently Asked Questions</h2>
                <div class="mb-3">
                    <h3 class="h6 fw-bold text-dark mb-1">Can I cancel or refund my tickets?</h3>
                    <p class="text-muted small mb-0">Yes, you can cancel your tickets up to 24 hours before the screening time directly through your My Account portal.</p>
                </div>
                <div class="mb-3">
                    <h3 class="h6 fw-bold text-dark mb-1">Do I need to print my e-ticket?</h3>
                    <p class="text-muted small mb-0">No need to print! You can simply scan the digital QR code directly from your smartphone at the cinema entrance.</p>
                </div>
                <div class="mb-0">
                    <h3 class="h6 fw-bold text-dark mb-1">Are wheelchair accessible seats available?</h3>
                    <p class="text-muted small mb-0">Yes, front row (Row A) features dedicated wheelchair spaces with easy accessibility. You can select them during the seat booking step.</p>
                </div>
            </div>
        </div>

    </div>
</main>
