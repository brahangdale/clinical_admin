@extends('layouts.clinic_website')
@section('clinic_website-container')
  <!-- Header -->
  <header class="top-header">
      <div class="logo-area">
          <i class="fa-solid fa-stethoscope"></i>
          <span>{{ $clinic_setting->logo_name }}</span>
      </div>

      <!-- Menu Button -->

      <button class="menu-btn" id="menuBtn">
          <i class="fa-solid fa-bars"></i>
      </button>

      <!-- Overlay -->

      <div class="overlay" id="overlay"></div>

      <!-- Side Menu -->

      <div class="side-menu" id="sideMenu">
          <div class="menu-header">
              <h4>Menu</h4>
              <button id="closeMenu">
                  <i class="fa-solid fa-xmark"></i>
              </button>
          </div>

          <ul>
              <li>
                  <a href="{{ route('patient_site.home') }}">
                      <i class="fa-solid fa-house"></i>
                      Home
                  </a>
              </li>

              <li>
                  <a href="Appointment.html">
                      <i class="fa-solid fa-calendar-check"></i>
                      Appointment
                  </a>
              </li>

              <li>
                  <a href="{{ route('patient_site.about') }}">
                      <i class="fa-solid fa-circle-info"></i>
                      About
                  </a>
              </li>

              <li>
                  <a href="{{ route('patient_site.location') }}">
                      <i class="fa-solid fa-location-dot"></i>
                      Location
                  </a>
              </li>

              <li>
                <a href="{{ route('patient_site.games') }}">
                    <i class="fa-solid fa-gamepad"></i>
                    Game
                </a>
              </li>
          </ul>
      </div>
  </header>

  <!-- Hero -->
  <section class="hero-section">
      <div class="hero-content">
          <h1>
              <!-- Welcome to <br />
              <span>Our Clinic</span> -->
              {{ $clinic_setting->banner_title }}
          </h1>

          <p>{{ $clinic_setting->banner_description }}</p>

          <!--  <a href="Appointment.html" class="appointment-btn">
            <i class="fa-solid fa-calendar-check"></i>
            Book Appointment
        </a> -->
      </div>

      <div class="hero-image">
          <!-- <img src="img/drbanner.png" alt=""> -->
          <img src="{{ url('/assets/static_images/img/drbanner.png') }}" alt="" />
      </div>
  </section>
  <section class="">
      <div class="center-box">
          <div class="hero-content">
              <a href="{{ route('patient_site.appointment') }}" class="appointment-btn">
                  <i class="fa-solid fa-calendar-check"></i>
                  Book Appointment
              </a>

              <a href="{{ route('patient_site.token_page') }}" style="background: #0d6efd" class="appointment-btn">
                  <i class="fa-solid fa-calendar-check"></i>
                  Check Token
              </a>
          </div>
      </div>

      <!-- <div class="center-box">
            <div class="hero-content">
                <button id="installBtn" class="installbtnbody install-btn">
                    <i class="fa-solid fa-download"></i> Install App
                </button>
            </div>
            <style type="text/css">
                .installbtnbody {
                    min-width: auto;
                    background: #1678ff;
                    color: #fff;
                    border: none;
                    border-radius: 10px 10px 30px 30px;
                    padding: 10px 40px;
                }

            </style>

            <script>
                window.addEventListener('beforeinstallprompt', (e) => {
                    console.log('PWA Install Available');
                    e.preventDefault();
                    deferredPrompt = e;

                    const installBtn = document.getElementById('installBtn');
                    if (installBtn) {
                        installBtn.style.display = 'block';
                    }
                });
                </script>

        </div> -->
  </section>
  <!-- Facilities -->

  <section class="section-title">
      <h3>Our Features</h3>
  </section>

  <div class="container">
    <div class="row g-3">
        <div class="col-6">
            <div class="feature-box">
                <i class="fa-solid fa-heart-pulse"></i>
                <h6>Quality Care</h6>
            </div>
        </div>

        <div class="col-6">
            <div class="feature-box">
                <i class="fa-solid fa-clock"></i>
                <h6>Quick Service</h6>
            </div>
        </div>

        <div class="col-6">
            <div class="feature-box">
                <i class="fa-solid fa-shield-heart"></i>
                <h6>Safe Treatment</h6>
            </div>
        </div>

        <div class="col-6">
            <div class="feature-box">
                <i class="fa-solid fa-stethoscope"></i>
                <h6>Expert Doctor</h6>
            </div>
        </div>
    </div>
  </div>

  <!-- Gallery -->

  <section class="section-title mt-4">
    <h3>Clinic Gallery</h3>
  </section>

  <div class="gallery-scroll">
    @foreach($clinic_gallary as $gallery)
      <img src="{{ asset('storage/' . $gallery->image) }}" class="img-fluid rounded"
                      alt="Clinic Gallery" style="width: 100; height: 150px; object-fit: cover;">
    @endforeach
  </div>

  <!-- Clinic Time -->

  <section class="section-title mt-4">
      <h3>Clinic Time</h3>
  </section>

  <div class="container">
      <div class="time-card">
          <table class="table">
              <thead>
                  <tr>
                      <th>Day</th>
                      <th>Morning</th>
                      <th>Evening</th>
                  </tr>
              </thead>

              <tbody class="tablefont">
                @foreach ($clinic_timings as $timing )
                  <tr>
                    <td>{{ $timing->day }}</td>
                    <td>{{ $timing->morning_time }} - {{ $timing->morning_time }}</td>
                    <td>{{ $timing->morning_time }} - {{ $timing->morning_time }}</td>
                  </tr>
                @endforeach
                  
              </tbody>
          </table>
      </div>
  </div>
@endsection