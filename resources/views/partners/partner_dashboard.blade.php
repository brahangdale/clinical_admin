@extends('layouts.partner_layout')
@section('partner_layout-container')
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