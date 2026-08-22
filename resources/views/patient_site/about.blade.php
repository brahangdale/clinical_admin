
@extends('layouts.clinic_website')
@section('clinic_website-container')
<div class="about-header">

    <!-- <img src="https://images.unsplash.com/photo-1614579093335-b6ab37ddaace?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTR8fGRvY3RvciUyMGNsaW5pY3xlbnwwfHwwfHx8MA%3D%3D" alt="Doctor"> -->
    <img src="{{ asset('storage/' . $clinic_about?->logo) }}" width="100" height="100"
              style="object-fit: cover; border-radius: 8px;">
    <h2>Dr. {{$clinic_about?->name}}</h2>

    <p>{{ $clinic_about?->tagline }}</p>

</div>

<!-- About -->

<div class="about-card">

    <h4>
        <i class="fa-solid fa-hospital"></i>
        About Our Clinic
    </h4>

    <p>
        {{ $clinic_about?->about_clinic }}
    </p>

</div>

<!-- Experience -->

<div class="about-card">

    <h4>
        <i class="fa-solid fa-user-doctor"></i>
        Doctor Experience
    </h4>

    <p>
        {{ $clinic_about?->experience }}
    </p>

</div>

<!-- Features -->

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

<!-- Contact -->

<!-- <a href="tel:+918857918045" class="contact-btn">
    <i class="fa-solid fa-phone"></i>
    Call Now
</a>
 -->
<!-- Bottom Navigation -->
@endsection
<!-- <div class="bottom-nav">

    <a href="index.html">
        <i class="fa-solid fa-house"></i>
        <span>Home</span>
    </a>

    <a href="about.html" class="active">
        <i class="fa-solid fa-circle-info"></i>
        <span>About</span>
    </a>

    <a href="location.html">
        <i class="fa-solid fa-location-dot"></i>
        <span>Location</span>
    </a>

    <a href="game.html">
        <i class="fa-solid fa-gamepad"></i>
        <span>Game</span>
    </a>

</div>
</div>
</body>
</html> -->