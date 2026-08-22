<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>Doctor Clinic</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

        <!-- <link rel="stylesheet" href="style.css?v=1234" /> -->

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
        <link rel="stylesheet" type="text/css" href="{{ url('assets\css\patient_style.css') }}" />
        
        <link rel="preconnect" href="https://fonts.googleapis.com">

		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <meta name="theme-color" content="#1976d2" />
        <meta name="mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
    </head>
    <body>
      <div class="sec1">
          <div id="page-loader">
              <img src="{{  url('/assets/static_images/icon-192.png') }}" alt="Loading" class="loader-logo" />
          </div>

          <style type="text/css">
              body {
                  opacity: 1;
                  transition: opacity 0.4s ease;
              }

              body.fade-out {
                  opacity: 0;
              }

              #page-loader {
                  position: fixed;
                  top: 0;
                  left: 0;
                  width: 100%;
                  height: 100%;
                  background: #fff;
                  display: flex;
                  justify-content: center;
                  align-items: center;
                  z-index: 99999;

                  opacity: 0;
                  visibility: hidden;
                  transition: all 0.4s ease;
              }

              #page-loader.active {
                  opacity: 1;
                  visibility: visible;
              }

              .loader-logo {
                  width: 90px;
                  animation: pulse 1.2s infinite;
              }

              @keyframes pulse {
                  0%,
                  100% {
                      transform: scale(1);
                  }
                  50% {
                      transform: scale(1.15);
                  }
              }
              /*voice start*/
        .voice-input-wrapper{
            position:relative;
        }

        .voice-input{
            width:100%;
            padding-right:55px;
        }

        .voice-btn{

            position:absolute;
            right:10px;
            top:50%;
            transform:translateY(-50%);

            width:38px;
            height:38px;

            border:none;
            border-radius:50%;

            background:#0d6efd;
            color:#fff;

            cursor:pointer;

            display:flex;
            align-items:center;
            justify-content:center;

            transition:.3s;

        }

        .voice-btn:hover{

            background:#0b5ed7;

        }

        .voice-btn.listening{

            background:#dc3545;

            animation:pulse 1s infinite;

        }

        @keyframes pulse{

        0%{

        transform:translateY(-50%) scale(1);

        }

        50%{

        transform:translateY(-50%) scale(1.15);

        }

        100%{

        transform:translateY(-50%) scale(1);

        }

        }

        /* textarea ke liye */

        .voice-input-wrapper textarea + .voice-btn{

            top:20px;
            transform:none;

        }
    /*voice end*/
          </style>

          <script>
              document.addEventListener("DOMContentLoaded", function () {
                  document.querySelectorAll("a").forEach((link) => {
                      link.addEventListener("click", function (e) {
                          let href = this.getAttribute("href");

                          if (
                              href &&
                              !href.startsWith("#") &&
                              !href.startsWith("javascript:") &&
                              this.target !== "_blank"
                          ) {
                              e.preventDefault();

                              // Fade + Loader
                              document.body.classList.add("fade-out");
                              document.getElementById("page-loader").classList.add("active");

                              setTimeout(() => {
                                  window.location.href = href;
                              }, 500);
                          }
                      });
                  });
              });
          </script>