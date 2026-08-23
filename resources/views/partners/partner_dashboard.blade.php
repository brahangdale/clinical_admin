@extends('layouts.partner_layout')
@section('partner_layout-container')
<!-- =========================================================
     CONTENT
========================================================= -->
<main class="partner-content">
  <!-- =========================================================
     PAGE HEADER
  ========================================================= -->

  <div class="partner-page-header">
    <div class="partner-heading">
      <h2>My Clinics</h2>
      <p>Manage your clinics and monitor their performance.</p>
    </div>
    <button class="partner-generate-btn" data-bs-toggle="modal" data-bs-target="#partnerAddClinicModal">
      <i class="fa-solid fa-plus"></i>Generate New Clinic
    </button>
  </div>
  <!-- =========================================================
     SEARCH
  ========================================================= -->
  <div class="partner-search-wrapper">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input
        type="text"
        id="partnerClinicSearch"
        class="partner-search"
        placeholder="Search clinic by name or city..."
        onkeyup="searchPartnerClinics()">
  </div>
  <!-- =========================================================
     SECTION
  ========================================================= -->
  <div class="partner-section-header">
    <h6>Clinics</h6>
    <span>{{ $clinics_count }} Clinics</span>
  </div>
  <!-- =========================================================
     CLINIC LIST
  ========================================================= -->

  <div class="row g-3" id="partnerClinicList">
  <!-- =========================================================
     CLINIC 1
  ========================================================= -->
  @forelse($partner_clinic as $clinic)
    <div class="col-12 col-md-6 col-xl-4 partner-clinic-item" data-search="{{ strtolower($clinic->clinic_name . ' ' . $clinic->city . ' ' . $clinic->state) }}">
      <div class="partner-clinic-card">
        <div class="partner-clinic-top">
          <div class="partner-clinic-icon">
            <i class="fa-solid fa-hospital"></i>
          </div>
          <div class="partner-clinic-info">
            <h6>{{ $clinic->clinic_name }}</h6>
            <div class="partner-clinic-location">
              <i class="fa-solid fa-location-dot"></i>
              {{ $clinic->city }}, {{ $clinic->state }}
            </div>
          </div>
         
          @if($clinic->user?->status == 0)
            <span class=" partner-status badge bg-danger ">Inactive</span>
          @else
            <span class=" partner-status badge bg-success">Active</span>
          @endif
        </div>
        <!-- STATS -->
        <div class="partner-clinic-stats">
          <div class="partner-mini-stat">
            <strong>{{ $clinic->today_appointments }}</strong>
            <span>Today's Appt.</span>
          </div>
          <div class="partner-mini-stat">
            <strong>{{ $clinic->completed_appointments  }}</strong>
            <span>Completed</span>
          </div>
          <div class="partner-mini-stat">

                    <strong>
                        {{ $clinic->today_patients }}
                    </strong>

                    <span>
                        Patients
                    </span>

          </div>
        </div>
        <!-- REVENUE -->
        <div class="partner-clinic-revenue">
          <div class="partner-revenue-item">
            <span>Today's Revenue</span>
            <strong>₹{{ $clinic->today_revenue }}</strong>
          </div>
          <div class="partner-revenue-item">
            <span>Partner Payment</span>
              <strong>₹{{ $clinic->partner_payment }}</strong>
          </div>
        </div>
        <!-- ACTIONS -->
        <div class="partner-clinic-actions">
          <button type="button" class="partner-clinic-btn partner-view-info-btn" data-bs-toggle="modal" data-bs-target="#partnerClinicInfoModal{{ $clinic->id }}" data-id="{{ $clinic->id }}">
            <i class="fa-regular fa-eye"></i>View Clinic
          </button>
          
          <button type="button" class="partner-clinic-btn partner-performance-btn"
            onclick="viewPartnerPerformance({{ $clinic->id }}, @js($clinic->clinic_name))">
            <i class="fa-solid fa-chart-line"></i>
            Performance
          </button>
        </div>
      </div>
    </div>
  @empty
    <div class="col-12 text-center py-5">
      <h6>No clinics found</h6>
    </div>
  @endforelse
  </div>
  <!-- =========================================================
     NO RESULT
  ========================================================= -->
  <div
    class="partner-no-result"
    id="partnerNoResult">

    <i class="fa-solid fa-hospital"></i>

    <h6>
        No clinic found
    </h6>

    <p>
        Try another clinic name or city.
    </p>
  </div>
  <!-- =========================================================
     PERFORMANCE PANEL
  ========================================================= -->

  <div class="partner-performance" id="partnerPerformance" data-clinic-id="">
  <!-- HEADER -->
  <div class="partner-performance-header">
    <div class="partner-performance-title">
      <div class="partner-performance-icon">
        <i class="fa-solid fa-chart-column"></i>
      </div>
      <div>
        <h6 id="selectedClinicName">
          <!-- City Care Clinic -->
        </h6>
        <small>Clinic performance overview</small>
      </div>
    </div>
    <button class="partner-close-btn" onclick="closePartnerPerformance()">
      <i class="fa-solid fa-xmark"></i>
    </button>
  </div>
  <!-- DATE FILTER -->
  <div class="partner-date-filter">
    <div class="row g-2 align-items-end">
      <div class="col-6 col-md-4">
        <label class="partner-date-label">
            From Date
        </label>
        <input
            type="date"
            id="partnerFromDate"
            class="partner-date-input">
      </div>
      <div class="col-6 col-md-4">

                <label class="partner-date-label">
                    To Date
                </label>

                <input
                    type="date"
                    id="partnerToDate"
                    class="partner-date-input">

            </div>


            <div class="col-12 col-md-4">

                <button
                    class="partner-apply-btn"
                    onclick="applyPartnerDateFilter()">

                    <i class="fa-solid fa-filter"></i>

                    Apply Date Range

                </button>

            </div>


    </div>
  </div>
  <!-- PERFORMANCE BODY -->
    <div class="partner-performance-body">
      <div class="row g-3">


            <!-- PATIENTS -->

            <div class="col-6 col-lg-3">

                <div class="partner-performance-card">

                    <div class="partner-performance-card-icon">

                        <i class="fa-solid fa-users"></i>

                    </div>


                    <h3 id="performancePatients">
                        124
                    </h3>


                    <p>
                        Total Patients
                    </p>

                </div>

            </div>



            <!-- COMPLETED -->

            <div class="col-6 col-lg-3">

                <div class="partner-performance-card">

                    <div class="partner-performance-card-icon">

                        <i class="fa-solid fa-circle-check"></i>

                    </div>


                    <h3 id="performanceCompleted">
                        108
                    </h3>


                    <p>
                        Completed Patients
                    </p>

                </div>

            </div>



            <!-- APPOINTMENTS -->

            <div class="col-6 col-lg-3">

                <div class="partner-performance-card">

                    <div class="partner-performance-card-icon">

                        <i class="fa-solid fa-calendar-check"></i>

                    </div>


                    <h3 id="performanceAppointments">
                        132
                    </h3>


                    <p>
                        Total Appointments
                    </p>

                </div>

            </div>



            <!-- REVENUE -->

            <div class="col-6 col-lg-3">

                <div class="partner-performance-card revenue">

                    <div class="partner-performance-card-icon">

                        <i class="fa-solid fa-indian-rupee-sign"></i>

                    </div>


                    <h3 id="performanceRevenue">
                        ₹74,850
                    </h3>


                    <p>
                        Revenue Generated
                    </p>

                </div>

            </div>


      </div>
      <!-- REVENUE SUMMARY -->
      <div class="partner-revenue-summary">


            <h6>
                Revenue Summary
            </h6>


            <div class="partner-revenue-line">

                <span>
                    Total Revenue Generated
                </span>

                <strong id="summaryTotalRevenue">
                    ₹74,850
                </strong>

            </div>


            <div class="partner-revenue-line partner-payment">

                <span>
                    Partner Payment
                </span>

                <strong id="summaryPartnerPayment">
                    ₹7,485
                </strong>

            </div>


        </div>


    </div>

  </div>
</main>

</div>
  <!-- =========================================================
      VIEW CLINIC MODAL
  ========================================================= -->
  @foreach($partner_clinic as $clinic)
    <div class="modal fade partner-info-modal" id="partnerClinicInfoModal{{ $clinic->id }}" tabindex="-1"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="partner-info-header">
            <div class="partner-info-heading">
              <div class="partner-info-icon">
                <i class="fa-solid fa-hospital"></i>
              </div>
              <div>
                <h6 id="infoClinicName">
                  {{ $clinic->clinic_name }}
                </h6>
                <small>Clinic Information</small>
              </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="partner-info-body">
            <div class="partner-info-grid">
              <div class="partner-info-item">
                <span>Clinic Name</span>
                <strong id="infoClinicName2">{{ $clinic->clinic_name }}</strong>
              </div>
              <div class="partner-info-item">
                <span>Status</span>
                  @if($clinic->user?->status == 1)
                  <strong id="infoClinicStatus"style="color:#15803d;">Active</strong>
                  @else
                  <strong id="infoClinicStatus"style="color:#e70946;">Inctive</strong>
                  @endif
              </div>
              <div class="partner-info-item">
                <span>Phone Number</span>
                <strong id="infoClinicPhone"> +91 {{ $clinic->mobile_number }}</strong>
              </div>
              <div class="partner-info-item">
                <span>Created Date</span>
                <strong id="infoClinicDate">{{ $clinic->created_at }}</strong>
              </div>
              <div class="partner-info-item full">
                <span>Clinic Address</span>
                <strong id="infoClinicAddress">
                  {{ $clinic->address }}, {{ $clinic->city }},
                  {{ $clinic->state }}
                </strong>
              </div>
            </div>
          </div>
          <div class="partner-info-footer">
            <button type="button" class="partner-modal-close" data-bs-dismiss="modal">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  <!-- =========================================================
      VIEW CLINIC MODAL END
  ========================================================= -->


  <!-- =========================================================
      ADD CLINIC MODAL
  ===== ==================================================== -->
  <div class="modal fade partner-add-modal" id="partnerAddClinicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="partner-modal-header">
            <div class="partner-modal-title">
              Generate New Clinic
            </div>
            <div class="partner-modal-subtitle">
              Create a new clinic under your partnership.
            </div>
          </div>
          <form id="partnerClinicForm" action="{{ route('partners.store_clinic') }}" method="post">
            @csrf
            <div class="partner-modal-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="partner-form-label">Clinic Name *</label>
                  <!-- <input type="text" class="partner-form-control" name="clinic_name" placeholder="Enter clinic name" required> -->
                  <input type="text" name="clinic_name"  value="{{ old('clinic_name') }}" class="partner-form-control" placeholder="Enter Clinic Name" required>
                  <span class="text-danger">
                    @error('clinic_name')
                      <small>{{ $message }}</small> 
                    @enderror
                  </span>

                </div>
                <div class="col-md-6">
                  <label class="partner-form-label">
                    Partner User Name *
                  </label>
                  <input type="text" name="user_name" value="{{ old('user_name') }}" class="partner-form-control" placeholder="Enter Owner Name">
                  <span class="text-danger">
                      @error('user_name')
                        <small>{{ $message }}</small> 
                      @enderror
                    </span>
                </div>
                <div class="col-md-6">
                  <label class="partner-form-label"> Mobile Number</label>
                  <input type="number" name="mobile_number" value="{{ old('mobile_number') }}" class="partner-form-control" placeholder="Enter Mobile">
                    <span class="text-danger">
                      @error('mobile_number')
                        <small>{{ $message }}</small> 
                      @enderror
                    </span>
                </div>
                <div class="col-md-6">
                  <label class="partner-form-label"> Partner Email</label>
                  <input type="email" name="email" value="{{ old('email') }}" class="partner-form-control" placeholder="Enter Email">
                    <span class="text-danger">
                      @error('email')
                        <small>{{ $message }}</small> 
                      @enderror
                    </span>
                </div>
                <div class="col-md-6">
                  <label class="partner-form-label">City *</label>
                  <input type="text" class="partner-form-control" name="city" placeholder="Enter city" value="{{ old('city') }}" required>
                </div>
                  <div class="col-md-6 mb-3">
                    <label class="partner-form-label">State *</label>
                    <input type="text" name="state" value="{{ old('state') }}" class="partner-form-control" placeholder="Enter State">
                  </div>

                <div class="col-12">
                  <label class="partner-form-label">Clinic Address *</label>
                  <textarea class="partner-form-control" name="address"
                        style="height:75px;padding-top:10px;resize:none;"
                        placeholder="Enter complete clinic address"
                        required>{{ old('address') }}
                  </textarea>
                </div>
                <div class="col-md-6">
                    <label class="partner-form-label">Status</label>
                    <select class="partner-form-select" name="status">
                      <option value="0" selected>Inactive</option>
                      <option value="1" >Active</option>
                    </select>
                  </div>
              </div>
            </div>
            <div class="partner-modal-footer">
              <button type="button" class="partner-cancel-btn" data-bs-dismiss="modal">
                Cancel
              </button>
              <button type="submit" class="partner-create-btn">
                <i class="fa-solid fa-plus"></i>
                  Generate Clinic
              </button>
            </div>
          </form>
        </div>
    </div>
  </div>
  <!-- =========================================================
      ADD CLINIC MODAL END
  ========================================================= -->
@endsection