


@extends('main.layout')
@section('content')

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
            <h1 data-aos="fade-up">Biznesinizi inkişaf etdirmək üçün müasir həllər təklif edirik</h1>
            <p data-aos="fade-up" data-aos-delay="100">Biz veb saytlar hazırlayan istedadlı dizaynerlərdən ibarət komandayıq</p>
            <div class="d-flex flex-column flex-md-row" data-aos="fade-up" data-aos-delay="200">
              <a href="#about" class="btn-get-started">Get Started <i class="bi bi-arrow-right"></i></a>
              <a href="https://www.youtube.com/watch?v=ReG10VJu6J4" class="glightbox btn-watch-video d-flex align-items-center justify-content-center ms-0 ms-md-4 mt-4 mt-md-0"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>
            </div>
          </div>
          <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out">
            <img src="assets/img/hero-img.png" class="img-fluid animated" alt="">
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

   
  </main>


@endsection
