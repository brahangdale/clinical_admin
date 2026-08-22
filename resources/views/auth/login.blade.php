<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Super Admin Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

   <link rel="stylesheet" type="text/css" href=" {{url('assets/css/superadmin.css')}}">

    

</head>

<body class="sam-login-page">

<div class="container-fluid">

  <div class="row sam-login-wrapper">

    <div class="col-lg-6 sam-login-left">

            <i class="fa-solid fa-hospital sam-login-brand-icon"></i>

            <h1 class="sam-login-brand-title">
                Clinic Management
            </h1>

            <p class="sam-login-brand-text">
                Manage unlimited clinics, doctors, patients and appointments
                from a single Super Admin Dashboard.
            </p>

            <div class="sam-login-features">

                <div class="sam-login-feature">
                    <i class="fa-solid fa-hospital"></i>
                    Unlimited Clinics & Hospitals
                </div>

                <div class="sam-login-feature">
                    <i class="fa-solid fa-user-doctor"></i>
                    Doctor Management
                </div>

                <div class="sam-login-feature">
                    <i class="fa-solid fa-calendar-check"></i>
                    Appointment Tracking
                </div>

                <div class="sam-login-feature">
                    <i class="fa-solid fa-chart-line"></i>
                    Reports & Analytics
                </div>

            </div>

    </div>
    <div class="col-lg-6 sam-login-right">
      <div class="sam-login-card">

        <div class="sam-login-logo">
            <i class="fa-solid fa-user-shield"></i>
        </div>

        <h3 class="sam-login-title">
            Super Admin Login
        </h3>

        <p class="sam-login-subtitle">
            Sign in to continue
        </p>

        <form action="{{ route('authenticate') }}" method="post">
          @csrf
          <div class="mb-3">
            <label class="sam-login-label">Username</label>

              <div class="input-group">
                <span class="input-group-text sam-login-input-group-text">
                  <i class="fa fa-user"></i>
                </span>
                <input type="text" class="form-control sam-login-input"placeholder="Enter Username" name="user_name">
                <br>
                
              </div>
              <span class="text-danger">
                  @error('user_name')
                  {{ $message }}
                  @enderror
                </span>
          </div>

          <div class="mb-3">
            <label class="sam-login-label">Password</label>
            <div class="input-group">
              <span class="input-group-text sam-login-input-group-text">
                <i class="fa fa-lock"></i>
              </span>
              <input
                    type="password"
                    id="samLoginPassword"
                    class="form-control sam-login-input"
                    placeholder="Enter Password" name="password">
                  
                <button
                    type="button"
                    class="btn btn-outline-secondary sam-login-password-btn"
                    onclick="samTogglePassword()">

                    <i class="fa fa-eye"></i>

                </button>
              </div>
              <span class="text-danger">
                  @error('password')
                  {{ $message }}
                  @enderror
                </span>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="rememberMe">

                    <label
                        class="form-check-label"
                        for="rememberMe">

                        Remember Me

                    </label>

            </div>

            <a href="#" class="text-decoration-none">
                    Forgot Password?
            </a>
          </div>

            <button
                type="submit"
                class="btn text-white w-100 sam-login-btn">

                Login

            </button>

        </form>

        <div class="sam-login-footer">
            © 2026 Clinic Management System
        </div>

      </div>

    </div>
  </div>

</div>

<script type="text/javascript" src="{{ url('assets/js/superadmin.js') }}"></script>
</body>
</html>