@extends('layouts.main')
@section('main-container')
<div class="card shadow-sm border-0 mb-4">
  <div class="card-header bg-primary text-white">
      <h5 class="mb-0">
          <i class="bi bi-house-door me-2"></i>
          Home Page Settings
      </h5>
  </div>

  <div class="card-body sam-settings-body">
    <form action="{{ route('clinical_admins.create_setting') }}" method="post" enctype="multipart/form-data">
      @csrf
      @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif
      <div class="row">
        <div class="col-lg-4">
          <div class="sam-form-group">
            <label class="sam-form-label">
                Clinic Name <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control"  value="{{ $clinic->clinic_name }}" 
              placeholder="Enter Clinic Name" readonly>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="sam-form-group">
            <label class="sam-form-label">
                Logo Name <span class="text-danger">*</span>
            </label>

            <input type="text" class="form-control" name="logo_name"
              placeholder="Enter Clinic Name"  value="{{ old('logo_name', $clinicSettings?->logo_name) }}">
            @error('logo_name')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>

        <div class="col-lg-4">
          <div class="sam-form-group">
            <label class="sam-form-label">Banner Title<span class="text-danger">*</span> </label>
            <input type="text" class="form-control" name="banner_title"
            placeholder="Welcome to ABC Clinic"  value="{{ old('banner_title', $clinicSettings?->banner_title) }}">
            @error('banner_title')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>

        <div class="col-12">
          <div class="sam-form-group">
            <label class="sam-form-label">
              Banner Description<span class="text-danger">*</span>
              <small class="text-muted">(Maximum 70 Characters)</small>
            </label>
            <textarea class="form-control" rows="3" name="description"placeholder="Write short clinic description...">{{ old('banner_description', $clinicSettings?->banner_description) }}</textarea>
            <div class="d-flex justify-content-between mt-2">
              <small class="sam-helper">Short description shown on Home Page.</small>
              <small class="text-muted">
                0 / 70
              </small>
            </div>
            @error('description')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
          <div class="sam-form-group">
            <label class="sam-form-label">Facebook Link<span class="text-danger">*</span> </label>
            <input type="url" class="form-control" name="facebook_link"
            placeholder="https://google.com/..."  value="{{ old('facebook_link', $clinicSettings?->facebook_link) }}">
            @error('facebook_link')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
          
          <div class="sam-form-group">
            <label class="sam-form-label">Instagram Link<span class="text-danger">*</span></label>
            <input type="url" class="form-control" name="instagram_link"
            placeholder="https://google.com/..."  value="{{ old('instagram_link', $clinicSettings?->instagram_link) }}">
            @error('instagram_link')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
          <div class="sam-form-group">
            <label class="sam-form-label">Youtube Link<span class="text-danger">*</span></label>
            <input type="url" class="form-control" name="youtube_link"
            placeholder="https://google.com/..."  value="{{ old('youtube_link', $clinicSettings?->youtube_link) }}">
            @error('youtube_link')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
        <div class="col-12">
          <div class="sam-form-group">
            <label class="sam-form-label">Upload Clinic Gallery</label>
            <!-- <input type="file" id="clinicGallery" class="form-control" name="gallary[]" multiple> -->
            <input type="file"
           class="form-control"
           id="clinicGallery"
           name="gallary[]"
           multiple>
            <small class="sam-helper">Maximum 5 images (JPG, PNG)</small>
            @error('gallary')
              <span class="text-danger d-block">
                  {{ $message }}
              </span>
            @enderror

            @error('gallary.*')
              <span class="text-danger d-block">
                {{ $message }}
              </span>
            @enderror
            <!-- Image Preview -->
            <div id="galleryPreview" class="sam-gallery-preview"></div>
          </div>
          @if($galleryImages->count())
            <div class="row g-3" id="existingGallery">
              @foreach($galleryImages as $gallery)
                <div class="col-md-3" id="gallery-{{ $gallery->id }}">
                  <div class="position-relative border rounded p-2">
                    <img src="{{ asset('storage/' . $gallery->image) }}" class="img-fluid rounded"
                      alt="Clinic Gallery" style="width: 100; height: 150px; object-fit: cover;">
                    <button type="button" class="btn btn-danger btn-sm delete-gallery position-absolute top-0 end-0 m-2"
                      data-id="{{ $gallery->id }}" data-url="{{ url('clinical_admins/clinical-admin/gallery/' . $gallery->id) }}">
                      <i class="fa fa-trash"></i>
                    </button>
                  </div>
                </div>
              @endforeach
            </div>
          @else
            <p id="noGalleryMessage" class="text-muted">
              No gallery images available.
            </p>
          @endif
        </div>
        <div class="mt-4 text-end">
          <button type="submit" class="btn btn-primary px-4">
            Save
          </button>
        </div>
      </div>
    </form>
    <hr class="sam-divider">
    <h5 class="sam-section-title">Clinic Timing</h5>
    <form action="{{ route('clinical_admins.clinic_timing') }}" method="post">
      @csrf
      @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif
      <div class="table-responsive">
        <table class="table table-bordered align-middle sam-table">
          <thead class="table-light">
            <tr>
              <th width="20%">Day</th>
              <th>Morning Time<span class="text-danger">*</span></th>
              <th>Evening Time<span class="text-danger">*</span></th>
            </tr>
          </thead>
          <tbody>
            @php
              $days = [
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
                'Sunday'
              ];
            @endphp
            @foreach($days as $day)
              @php
                $timing = $clinicTimings->firstWhere('day', $day);
              @endphp
              <tr>  
                <td>{{ $day }}</td>
                <td>
                  <input type="time" class="form-control" name="timings[{{ $day }}][morning_time]"
                    value="{{ old('timings.'.$day.'.morning_time', $timing?->morning_time) }}">
                  @error('timings.'.$day.'.morning_time')
                    <span class="text-danger d-block mt-1">
                        {{ $message }}
                    </span>
                  @enderror
                  </td>
                <td>
                  <input type="time" class="form-control" name="timings[{{ $day }}][evening_time]"
                  value="{{ old('timings.'.$day.'.evening_time', $timing?->evening_time) }}">
                  @error('timings.'.$day.'.evening_time')
                    <span class="text-danger d-block mt-1">
                        {{ $message }}
                    </span>
                  @enderror
                </td>
              </tr>
              @endforeach
          </tbody>
        </table>
        <div class="mt-4 text-end">
          <button type="submit" class="btn btn-primary px-4">
              <!-- <i class="fas fa-calendar-check me-1"></i> -->
              Save
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="card shadow-sm border-0 mb-4">
  <div class="card-header bg-success text-white">
    <h5 class="mb-0">
      About Page Settings
    </h5>
  </div>

  <div class="card-body sam-settings-body">
    <form action="{{ route('clinical_admins.about_clinic') }}" method="post"  enctype="multipart/form-data" >
    @csrf
    <div class="row">
      <div class="col-lg-4">
        <div class="sam-form-group">
          <label class="sam-form-label">Clinic Logo (1:1)<span class="text-danger">*</span></label>
          <input type="file" class="form-control" name="logo" accept="image/*" value="">
          @error('logo')
            <span class="text-danger">
              {{ $message }}
            </span>
          @enderror
          <small class="sam-helper">Recommended Size : 500 × 500 px</small>
          @if(!empty($aboutClinic?->logo))
            <div class="mt-2">
              <img src="{{ asset('storage/' . $aboutClinic->logo) }}" width="100" height="100"
              style="object-fit: cover; border-radius: 8px;">
            </div>
          @endif
        </div>
      </div>
      <div class="col-lg-8">
        <div class="sam-form-group">
          <label class="sam-form-label">Clinic / Doctor Name<span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control" value="{{ old('name', $aboutClinic?->name) }}">
          @error('name')
            <span class="text-danger">
              {{ $message }}
            </span>
          @enderror
        </div>
      </div>
      <div class="col-12">
        <div class="sam-form-group">
          <label class="sam-form-label">Tagline<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="tagline"
          placeholder="Trusted Care For Every Family" value="{{ old('tagline', $aboutClinic?->tagline) }}">
          @error('tagline')
            <span class="text-danger">
              {{ $message }}
            </span>
          @enderror
        </div>
      </div>
      <div class="col-12">
        <div class="sam-form-group">
          <label class="sam-form-label">About Clinic<span class="text-danger">*</span></label>
          <textarea rows="5" name="about_clinic"
          class="form-control">{{ $aboutClinic?->about_clinic }}</textarea>
          @error('about_clinic')
            <span class="text-danger">
              {{ $message }}
            </span>
          @enderror
        </div>
      </div>
      <div class="col-lg-4">
        <div class="sam-form-group">
          <label class="sam-form-label">Doctor Experience<span class="text-danger">*</span></label>
          <textarea rows="3" name="experience" class="form-control">{{ $aboutClinic?->experience }}</textarea>
          @error('experience')
            <span class="text-danger">
              {{ $message }}
            </span>
          @enderror
        </div>
      </div>
      <div class="mt-4 text-end">
        <button type="submit" class="btn btn-primary px-4">Save</button>
      </div>
    </div>
    </form>
  </div>
</div>

<div class="card shadow-sm border-0">
  <div class="card-header bg-danger text-white">
    <h5 class="mb-0">
      Contact & Location
    </h5>
  </div>
  <div class="card-body sam-settings-body">
    <form action="{{ route('clinical_admins.clinic_contact') }}" method="post">
      @csrf
      <div class="row">
        <div class="col-12">
          <div class="sam-form-group">
            <label class="sam-form-label">Clinic Address<span class="text-danger">*</span></label>
            <textarea class="form-control" name="address" rows="3">{{ old('address', $clinicContact?->address) }}</textarea>
            @error('address')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
        <div class="col-lg-6">
          <div class="sam-form-group">
            <label class="sam-form-label">Google Map Link<span class="text-danger">*</span></label>
              <input type="url" class="form-control" name="google_map_link" 
              value="{{ old('google_map_link', $clinicContact?->google_map_link) }}" placeholder="https://maps.google.com/...">
              @error('google_map_link')
                <span class="text-danger">
                  {{ $message }}
                </span>
              @enderror
            </div>
        </div>
        <div class="col-lg-3">
          <div class="sam-form-group">
            <label class="sam-form-label">Clinic Phone</label>
            <input type="tel" class="form-control" name="phone" placeholder="+91"
            value="{{ $clinic?->mobile_number }}" readonly>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="sam-form-group">
            <label class="sam-form-label">Emergency Contact<span class="text-danger">*</span></label>
            <input type="tel" class="form-control" name="emergency_contact" placeholder="+91"
              value="{{ old('emergency_contact', $clinicContact?->emergency_contact) }}">
            @error('emergency_contact')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
            </div>
        </div>
      </div>
      <div class="mt-4 text-end">
        <button type="submit" class="btn btn-primary px-4">
          Save
        </button>
      </div>
    </form>
  </div>
</div>

<script type="text/javascript">
  const galleryInput = document.getElementById('clinicGallery');
const galleryPreview = document.getElementById('galleryPreview');

let selectedFiles = [];

galleryInput.addEventListener('change', function () {

    const newFiles = Array.from(this.files);

    newFiles.forEach(file => {

        // Only JPG / PNG
        if (!['image/jpeg', 'image/png'].includes(file.type)) {
            return;
        }

        // Duplicate check
        const alreadySelected = selectedFiles.some(
            selectedFile =>
                selectedFile.name === file.name &&
                selectedFile.size === file.size
        );

        if (!alreadySelected) {
            selectedFiles.push(file);
        }
    });

    syncFiles();
    renderGallery();
});


function syncFiles() {

    const dataTransfer = new DataTransfer();

    selectedFiles.forEach(file => {
        dataTransfer.items.add(file);
    });

    galleryInput.files = dataTransfer.files;
}


function renderGallery() {

    galleryPreview.innerHTML = '';

    selectedFiles.forEach((file, index) => {

        const reader = new FileReader();

        reader.onload = function (e) {

            const item = document.createElement('div');

            item.className = 'sam-gallery-item';

            item.innerHTML = `
                <img src="${e.target.result}"
                     alt="Clinic Gallery">

                <button type="button"
                        class="sam-gallery-remove"
                        onclick="removeGalleryImage(${index})">
                    ×
                </button>
            `;

            galleryPreview.appendChild(item);
        };

        reader.readAsDataURL(file);
    });
}


function removeGalleryImage(index) {

    selectedFiles.splice(index, 1);

    syncFiles();
    renderGallery();
}
/*upload photo 5 end*/
</script>

@endsection