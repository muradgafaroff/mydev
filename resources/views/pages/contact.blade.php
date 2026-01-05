@extends('main.layout')
@section('content')

<main class="main">
    <section id="contact" class="contact section">

        <div class="container section-title" data-aos="fade-up">
          <h2>Contact</h2>
          <p>Contact Us</p>
        </div>

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
                </div>
                </div>
            </div>

            <div class="col-lg-6">
                
              {{-- UĞUR MESAJI BURADA GÖRÜNƏCƏK --}}
              @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4" style="background-color: #d1e7dd; color: #0f5132; padding: 15px; border-radius: 8px;">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </div>
              @endif

              {{-- XƏTA MESAJLARI (Validasiya üçün) --}}
              @if($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4" style="background-color: #f8d7da; color: #842029; padding: 15px; border-radius: 8px;">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
              @endif

              <form action="{{ route('contact.store') }}" method="post" class="contact-form" data-aos="fade-up" data-aos-delay="200">
                @csrf 
                
                <div class="row gy-4">
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Your Name" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" placeholder="Your Email" value="{{ old('email') }}" required>
                    </div>

                    <div class="col-12">
                        <input type="text" class="form-control" name="subject" placeholder="Subject" value="{{ old('subject') }}" required>
                    </div>

                    <div class="col-12">
                        <textarea class="form-control" name="message" rows="6" placeholder="Message" required>{{ old('message') }}</textarea>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary px-4 py-2" style="background-color: #4154f1; border: 0; transition: 0.3s;">Send Message</button>
                    </div>
                </div>
              </form>
            </div>

          </div>
        </div>
    </section>
</main>

@endsection