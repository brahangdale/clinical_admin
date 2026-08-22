@extends('layouts.clinic_website')
@section('clinic_website-container')

<!-- Header -->

<div class="location-header">

    <i class="fa-solid fa-location-dot"></i>

    <h2>Location</h2>

    <p>Find Us Easily</p>

</div>

<!-- Address -->

<div class="location-card">

    <h4>
        <i class="fa-solid fa-hospital"></i>
        Address
    </h4>

    <p>
        {{ $location?->address }}
    </p>

</div>

<!-- Google Map -->

<!-- <div class="map-box">

<iframe
src="https://maps.google.com/maps?q=Nagpur&t=&z=13&ie=UTF8&iwloc=&output=embed">
</iframe>

</div> -->

<!-- Buttons -->

<div class="container">

    <a href="tel:+918857918045"
       class="action-btnn call-btnn">
       <i class="fa-solid fa-phone"></i>
       Call Clinic
    </a>

    <a href="https://maps.app.goo.gl/icwu2fT9Qmz4r9zm9"
       class="action-btnn direction-btnn">
       <i class="fa-solid fa-route"></i>
       Get Directions
    </a>

</div>

<!-- Timing -->



<!-- Emergency -->

<div class="location-card">

    <h4>
        <i class="fa-solid fa-truck-medical"></i>
        Emergency Contact
    </h4>

    <p>
        Emergency Helpline :
        +91 {{ $location?->emergency_contact }}
    </p>

</div>

<!-- Bottom Navigation -->

@endsection
