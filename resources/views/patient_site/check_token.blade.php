@extends('layouts.clinic_website')
@section('clinic_website-container')

  <div class="token-card">


      <a class="close-btn" href="index.html">
          ✕
      </a>


      <div class="header">

          <h2>Current Token</h2>

          <p>Please Wait for Your Turn</p>

      </div>

      <div class="info">

          <!-- <div class="info-box">

              <div class="label">

                  Doctor Name

              </div>

              <div class="value" id="doctorName">

                  Dr. Amit Sharma

              </div>

          </div>

          <div class="info-box">

              <div class="label">

                  Patient Name

              </div>

              <div class="value" id="patientName">

                  Rahul Verma

              </div>

          </div> -->
          @if(!empty($currentToken?->token_number))
            <div class="scratch-area">

              <div class="scratch-box">

                  <div id="tokenContent">

                      <span>NOW SERVING</span>

                      <div id="tokenNumber">

                          {{ $currentToken?->token_number }}

                      </div>

                  </div>

                  <canvas id="scratchCanvas"></canvas>

              </div>

            </div>
          @else
            <div class="scratch-area">

              <div class="scratch-box">

                  <div id="NotokenContent">

                      <span>NOT SERVING</span>

                      <!-- <div id="tokenNumber"> -->
                      <div id="noToken">

                        <!-- <span class=""> -->
                          No patient is currently in consultation for<b> Dr. {{ $current_doctor->doctor_name }}</b>
                        <!-- </span> -->
                      </div>

                  </div>

                  <canvas id="scratchCanvas"></canvas>

              </div>

            </div>
          @endif

      </div>

      <div class="footer">

          Touch & Scratch the Silver Card

          <div class="refresh">

              Auto Reset Every 15 Seconds

          </div>

      </div>

  </div>

  <script>
      const canvas = document.getElementById("scratchCanvas");
      const ctx = canvas.getContext("2d");

      const box = document.querySelector(".scratch-box");

      canvas.width = box.clientWidth;
      canvas.height = box.clientHeight;

      let drawing = false;

      // Silver Layer
      function createScratchLayer() {

          ctx.globalCompositeOperation = "source-over";

          const gradient = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);

          gradient.addColorStop(0, "#f5f5f5");
          gradient.addColorStop(.25, "#d9d9d9");
          gradient.addColorStop(.50, "#bdbdbd");
          gradient.addColorStop(.75, "#e5e5e5");
          gradient.addColorStop(1, "#c7c7c7");

          ctx.fillStyle = gradient;
          ctx.fillRect(0, 0, canvas.width, canvas.height);

          // shine lines

          for (let i = 0; i < 60; i++) {

              ctx.strokeStyle = "rgba(255,255,255,.18)";
              ctx.lineWidth = 2;

              ctx.beginPath();

              ctx.moveTo(-100 + i * 10, 0);

              ctx.lineTo(i * 10, canvas.height);

              ctx.stroke();

          }

          // text

          ctx.fillStyle = "#444";
          ctx.textAlign = "center";
          ctx.font = "bold 22px Poppins";

          ctx.fillText("SCRATCH", canvas.width / 2, canvas.height / 2 - 10);

          ctx.font = "16px Poppins";

          ctx.fillText("TO VIEW TOKEN", canvas.width / 2, canvas.height / 2 + 25);

      }

      createScratchLayer();

      function getPosition(e) {

          const rect = canvas.getBoundingClientRect();

          let x, y;

          if (e.touches) {

              x = e.touches[0].clientX - rect.left;
              y = e.touches[0].clientY - rect.top;

          } else {

              x = e.clientX - rect.left;
              y = e.clientY - rect.top;

          }

          return {
              x,
              y
          };

      }


      function scratch(x, y) {

          ctx.globalCompositeOperation = "destination-out";

          ctx.beginPath();

          ctx.arc(x, y, 25, 0, Math.PI * 2);

          ctx.fill();

      }

      canvas.addEventListener("mousedown", function(e) {

          drawing = true;

          const pos = getPosition(e);

          scratch(pos.x, pos.y);

      });

      canvas.addEventListener("mousemove", function(e) {

          if (!drawing) return;

          const pos = getPosition(e);

          scratch(pos.x, pos.y);

      });

      window.addEventListener("mouseup", function() {

          drawing = false;

      });


      canvas.addEventListener("touchstart", function(e) {

          drawing = true;

          const pos = getPosition(e);

          scratch(pos.x, pos.y);

      });

      canvas.addEventListener("touchmove", function(e) {

          e.preventDefault();

          if (!drawing) return;

          const pos = getPosition(e);

          scratch(pos.x, pos.y);

      });

      window.addEventListener("touchend", function() {

          drawing = false;

      });


      function scratchPercent() {

          const pixels = ctx.getImageData(0, 0, canvas.width, canvas.height);

          const total = pixels.data.length / 4;

          let transparent = 0;

          for (let i = 3; i < pixels.data.length; i += 4) {

              if (pixels.data[i] === 0) {
                  transparent++;
              }

          }

          return (transparent / total) * 100;

      }

      let revealed = false;

      function revealToken() {

          if (revealed) return;

          revealed = true;

          // Canvas ko poora hata do

          ctx.clearRect(0, 0, canvas.width, canvas.height);

          // Zoom Animation

          const token = document.getElementById("tokenNumber");

          token.animate([

              {
                  transform: "scale(.3)",
                  opacity: .2
              },

              {
                  transform: "scale(1.25)",
                  opacity: 1
              },

              {
                  transform: "scale(1)"
              }

          ], {

              duration: 700,
              easing: "ease"

          });

      }

      if (scratchPercent() > 70) {

          revealToken();

      }

      function scratch(x, y) {

          ctx.globalCompositeOperation = "destination-out";

          ctx.beginPath();

          ctx.arc(x, y, 25, 0, Math.PI * 2);

          ctx.fill();

          if (scratchPercent() > 70) {

              revealToken();

          }

      }


      function resetCard() {

          revealed = false;

          createScratchLayer();

      }





      /*demo token code start*/
      // let token = 18;

      // function loadNewToken() {

      //     token++;

      //     if (token > 99) {

      //         token = 1;

      //     }

      //     document.getElementById("tokenNumber").innerHTML = token;

      //     document.getElementById("patientName").innerHTML = "Patient " + token;

      //     document.getElementById("doctorName").innerHTML = "Dr. Amit Sharma";

      // }
      /*demo token code end*/


      // setInterval(function() {

      //     loadNewToken();

      //     resetCard();

      // }, 15000);
  </script>

@endsection