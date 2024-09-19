
@extends('main.layout')
@section('content')

<main class="main">

 <!-- Values Section -->
 <section id="values" class="values section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>Our Values</h2>
      <p>What we value most<br></p>
    </div><!-- End Section Title -->

    <div class="container">

      <div class="row gy-4">

        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
          <div class="card">
            <img src="assets/img/values-1.png" class="img-fluid" alt="">
            <h3>Ad cupiditate sed est odio</h3>
            <p>Eum ad dolor et. Autem aut fugiat debitis voluptatem consequuntur sit. Et veritatis id.</p>
          </div>
        </div><!-- End Card Item -->

        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
          <div class="card">
            <img src="assets/img/values-2.png" class="img-fluid" alt="">
            <h3>Voluptatem voluptatum alias</h3>
            <p>Repudiandae amet nihil natus in distinctio suscipit id. Doloremque ducimus ea sit non.</p>
          </div>
        </div><!-- End Card Item -->

        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
          <div class="card">
            <img src="assets/img/values-3.png" class="img-fluid" alt="">
            <h3>Fugit cupiditate alias nobis.</h3>
            <p>Quam rem vitae est autem molestias explicabo debitis sint. Vero aliquid quidem commodi.</p>
          </div>
        </div><!-- End Card Item -->

      </div>

    </div>

  </section><!-- /Values Section -->

   <!-- Stats Section -->
   <section id="stats" class="stats section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

      <div class="row gy-4">

        <div class="col-lg-3 col-md-6">
          <div class="stats-item d-flex align-items-center w-100 h-100">
            <i class="bi bi-emoji-smile color-blue flex-shrink-0"></i>
            <div>
              <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1" class="purecounter"></span>
              <p>Happy Clients</p>
            </div>
          </div>
        </div><!-- End Stats Item -->

        <div class="col-lg-3 col-md-6">
          <div class="stats-item d-flex align-items-center w-100 h-100">
            <i class="bi bi-journal-richtext color-orange flex-shrink-0" style="color: #ee6c20;"></i>
            <div>
              <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1" class="purecounter"></span>
              <p>Projects</p>
            </div>
          </div>
        </div><!-- End Stats Item -->

        <div class="col-lg-3 col-md-6">
          <div class="stats-item d-flex align-items-center w-100 h-100">
            <i class="bi bi-headset color-green flex-shrink-0" style="color: #15be56;"></i>
            <div>
              <span data-purecounter-start="0" data-purecounter-end="1463" data-purecounter-duration="1" class="purecounter"></span>
              <p>Hours Of Support</p>
            </div>
          </div>
        </div><!-- End Stats Item -->

        <div class="col-lg-3 col-md-6">
          <div class="stats-item d-flex align-items-center w-100 h-100">
            <i class="bi bi-people color-pink flex-shrink-0" style="color: #bb0852;"></i>
            <div>
              <span data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="1" class="purecounter"></span>
              <p>Hard Workers</p>
            </div>
          </div>
        </div><!-- End Stats Item -->

      </div>

    </div>

  </section><!-- /Stats Section -->
  </main>


@endsection
