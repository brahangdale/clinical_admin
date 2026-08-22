@extends('layouts.main')
@section('main-container')
<div class="mt-4"></div>
   <!-- Table -->
  <div class="sam-patient-card">
    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>Name</th>
            <th>Mobile</th>
            <th>Date of  Birth</th>
            <th>Age</th>
            <th>Gender</th>
            <!-- <th>Clinic</th>
            <th>Doctor</th>
            <th>Status</th>
            <th>Action</th> -->
          </tr>
        </thead>
        <tbody>
          @forelse($birthdayToday as $patient)
            <tr>
              <td>{{$patient->patient_name}}</td>
              <td>{{ $patient->mobile_number }}</td>
              <td>{{ $patient->date_of_birth }}</td>
              <td>{{ $patient->age }}</td>
              <td>{{ $patient->gender }}</td>
              <!-- <td>Akasa Clinic</td>
              <td>Dr. Amit Sharma</td>
              <td><span class="badge bg-success">Active</span></td> -->
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center">
                No Patient Have Birthday Today
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection