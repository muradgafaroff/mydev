
@extends('main.layout')
@section('content')

<main class="main">
    <section id="contact" class="contact section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Contact</h2>
          <p>Contact Us</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

          <div class="row gy-4">

            <div class="col-lg-6">

              <div class="row gy-4">
                <div class="col-md-6">
                  <div class="info-item" data-aos="fade" data-aos-delay="200">
                    <i class="bi bi-geo-alt"></i>
                    <h3>Address</h3>
                    <p>Az Ahmed Recebli</p>
                    <p>Baku, Aze</p>
                  </div>
                </div><!-- End Info Item -->

                <div class="col-md-6">
                  <div class="info-item" data-aos="fade" data-aos-delay="300">
                    <i class="bi bi-telephone"></i>
                    <h3>Call Us</h3>
                    <p>+994 55 329 20 29</p>
                    <p>+994 55 329 20 29</p>
                  </div>
                </div><!-- End Info Item -->

                <div class="col-md-6">
                  <div class="info-item" data-aos="fade" data-aos-delay="400">
                    <i class="bi bi-envelope"></i>
                    <h3>Email Us</h3>
                    <p>mydev.az</p>
                    <p>muradgafaroff@mydev.az</p>
                  </div>
                </div><!-- End Info Item -->

                <div class="col-md-6">
                  <div class="info-item" data-aos="fade" data-aos-delay="500">
                    <i class="bi bi-clock"></i>
                    <h3>Open Hours</h3>
                    <p>Monday - Friday</p>
                    <p>9:00AM - 05:00PM</p>
                  </div>
                </div><!-- End Info Item -->

              </div>

            </div>

            <div class="col-lg-6">
              <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
                <div class="row gy-4">

                  <div class="col-md-6">
                    <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                  </div>

                  <div class="col-md-6 ">
                    <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                  </div>

                  <div class="col-12">
                    <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                  </div>

                  <div class="col-12">
                    <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                  </div>

                  <div class="col-12 text-center">
                    <div class="loading">Loading</div>
                    <div class="error-message"></div>
                    <div class="sent-message">Your message has been sent. Thank you!</div>

                    <button type="submit">Send Message</button>
                  </div>

                </div>
              </form>
            </div><!-- End Contact Form -->

          </div>

        </div>

      </section><!-- /Contact Section -->



  </main>


@endsection
