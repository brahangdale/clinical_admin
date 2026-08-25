<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Super Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

<link rel="stylesheet" type="text/css" href="{{ url('assets\css\superadmin.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('assets\css\setting.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>
<!-- bottom bar for mobile start -->
<div class="sam-mobile-bottom-nav">
  @if(auth()->user()->role == 'super_admin')
    <a href="{{route('superadmin.dashboard')}}" class="{{ request()->is('superadmin/dashboard*') ? 'active' : '' }}">
      <i class="fa-solid fa-house"></i>
      Dashboard
    </a>
  @else
    <a href="{{route('clinical_admins.dashboard.clinic_dashboard')}}" class="{{ request()->is('clinical_admins/clinic_dashboard*') ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i>
        Dashboard
    </a>
  @endif
  <a href="{{route('doctors.index')}}" class="{{ request()->is('doctors*') ? 'active' : '' }}">
  <i class="fa-solid fa-user-doctor"></i>
  <span>Doctors</span>
  </a>
  <a href="{{route('appointments.index')}}" class="{{ request()->is('appointments*') ? 'active' : '' }}">
  <i class="fa-solid fa-calendar-check"></i>
  <span>Appts</span>
  </a>
  <form id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf
  </form>

  <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="fa-solid fa-right-from-bracket"></i>
    <span>Logout</span>
  </a>
</div>
<!-- bottom bar for mobile end -->
<!-- Sidebar -->
<div class="sam-dashboard-sidebar">
  <div class="sam-dashboard-logo">
    <i class="fa-solid fa-hospital"></i>
    Clinic Admin
  </div>
  <div class="sam-dashboard-menu">
    @if(auth()->user()->role == 'super_admin')
      <a href="{{route('superadmin.dashboard')}}" class="{{ request()->is('superadmin/dashboard*') ? 'active' : '' }}">
      <i class="fa-solid fa-house"></i>
      Dashboard
      </a>
      <a href="{{route('partners.index')}}" class="{{ request()->is('partners*') ? 'active' : '' }}">
        <i class="fa-solid fa-person"></i>
        Partners
      </a>
    @else
      <a href="{{route('clinical_admins.dashboard.clinic_dashboard')}}" class="{{ request()->is('clinical_admins/clinic_dashboard*') ? 'active' : '' }}">
      <i class="fa-solid fa-house"></i>
      Dashboard
      </a>
    @endif
    <a href="{{route('clinical_admins.index')}}" class="{{ request()->is('clinical_admins') ? 'active' : '' }}">
    <i class="fa-solid fa-hospital"></i>
    Clinic
    </a>
    
    <a href="{{route('doctors.index')}}" class="{{ request()->is('doctors*') ? 'active' : '' }}">
    <i class="fa-solid fa-user-doctor"></i>
    Doctors
    </a>
    
    <a href="{{route('appointments.index')}}" class="{{ request()->is('appointments*') ? 'active' : '' }}">
    <i class="fa-solid fa-calendar-check"></i>
    Appointments
    </a>
    <a href="{{route('reports')}}" class="{{ request()->is('reports*') ? 'active' : '' }}">
    <i class="fa-solid fa-chart-line"></i>
    Reports
    </a>
    @if(auth()->user()->role == 'clinic_admin')
      <a href="{{route('clinical_admins.setting')}}" class="{{ request()->is('clinical_admins.setting*') ? 'active' : '' }}">
      <i class="fa-solid fa-chart-line"></i>
      Settings
      </a>
    @endif
    <!-- <a href="supersetting.html">
    <i class="fa-solid fa-gear"></i>
    Settings
    </a> -->
    <!-- <a href="">
    <i class="fa-solid fa-right-from-bracket"></i>
    Logout
    </a> -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
      @csrf
    </form>

    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
      <i class="fa-solid fa-right-from-bracket"></i>
      <span>Logout</span>
    </a>
  </div>
</div>
<div class="sam-dashboard-main">
  <div class="sam-sidebar-overlay"></div>
<div class="sam-dashboard-header">
  <button id="samSidebarToggle" class="btn btn-light">
  <i class="fa-solid fa-bars"></i>
  </button>
  <div class="sam-dashboard-search">
  </div>
  <div class="sam-dashboard-header-right">
    <!-- <div class="sam-dashboard-notification">
      <i class="fa-solid fa-bell"></i>
    </div> -->
    <div class="sam-dashboard-profile">
      <img
          src="https://ui-avatars.com/api/?name={{ session('name') }}"
          alt="">
      <strong>{{ session('name') }}</strong>
    </div>
  </div>
</div>
     
<!-- Sidebar -->