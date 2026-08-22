@extends('layouts.clinic_website')
@section('clinic_website-container')
<div class="about-header">

    <img src="https://images.unsplash.com/photo-1614579093335-b6ab37ddaace?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTR8fGRvY3RvciUyMGNsaW5pY3xlbnwwfHwwfHx8MA%3D%3D" alt="Doctor">

    <h2>Select Doctor</h2>

    <p>Trusted Healthcare For Your Family</p>

</div>

<!-- About -->

<!-- <div class="about-card">

    <a href="" style="text-decoration: none; font-weight: bold;">
        <i class="fa-solid fa-user-doctor"></i> &nbsp;
        <span>Dr. Rajesh Sharma</span>
    </a>


</div> -->
@forelse($doctors as $doctor)

    <div class="about-card">

        <a href="{{ route('patient_site.check_token', ['doctor' => $doctor->id]) }}"
           style="text-decoration: none; font-weight: bold;">

            <i class="fa-solid fa-user-doctor"></i>&nbsp;

            <span>{{ $doctor->doctor_name }}</span>

        </a>

    </div>

@empty

    <div class="about-card">
        <p>No doctors available.</p>
    </div>

@endforelse

<!-- Experience -->


<!-- Features -->

<!-- Contact -->

<!-- Bottom Navigation -->
@endsection