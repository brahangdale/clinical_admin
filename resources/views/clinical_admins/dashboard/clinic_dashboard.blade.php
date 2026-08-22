@extends('layouts.main')
@section('main-container')

  <div class="container-fluid mymaincliniccontainer">
    <!---------------- Header ---------------->
    <!-- <div class="mymainclinicheader">
        <div>
            <h2>
                Good Afternoon 👋
            </h2>
            <p>
                Welcome Back, Dr. Akash Verma
            </p>
        </div>
    </div> -->
    <!---------------- Main Row ---------------->
    <div class="row g-4">
      <!-- LEFT TOKEN PANEL -->
      <div class="col-lg-4">
        <div class="mymainclinictokenpanel">
          <h4 class="mymainclinictitle">Current Token</h4>
            <!---------------- doctor1 Token ---------------->
            <div class="dflexmob">
              @forelse($currentTokens as $token)
                @php
                  $doctorColors = [
                      'blue',
                      'purple',
                      'green',
                      'orange',
                      'pink',
                      'teal',
                      'red',
                      'indigo'
                  ];

                    $color = $doctorColors[($token->doctor_id - 1) % count($doctorColors)];
                @endphp

                <div class="mymainclinicservingcard doctor-card-{{ $color }}"  data-doctor-id="{{ $token->doctor_id }}">

                        <span class="mymainclinicstatus">
                            NOW SERVING
                        </span>

                        <h1 class="mymainclinictokennumber">
                            {{ $token->token_number }}
                        </h1>

                        <h4 class="mymainclinicpatient">
                            {{ $token->patient->patient_name }}
                        </h4>

                        <p class="mymainclinicdoctor">
                            {{ $token->doctor->doctor_name }}
                        </p>

                        <!-- SKIP -->
                        <button
                            type="button"
                            class="btn btn-warning btn-sm mymainclinicskipbtn"
                            data-id="{{ $token->id }}"
                            data-url="{{ route(
                                'clinical_admins.appointment.skip',
                                $token->id
                            ) }}"
                        >
                            <i class="bi bi-skip-forward-fill"></i>
                            Skip for Now
                        </button>

                        <!-- COMPLETE -->
                        <button
                            type="button"
                            class="btn btn-success btn-sm mymaincliniccompletebtn"
                            data-id="{{ $token->id }}"
                            data-url="{{ route(
                                'clinical_admins.appointment.complete',
                                $token->id
                            ) }}"
                        >
                            <i class="bi bi-check-circle-fill"></i>
                            Complete
                        </button>

                    </div>

                @empty

                    <div class="alert alert-info w-100">
                        No patient is currently in consultation.
                    </div>

                @endforelse
              <!----------------  doctor2 Token ---------------->
              <!-- <div class="mymainclinicservingcard" style="background:#f59e0b;">
                  <span class="mymainclinicstatus">
                      NOW SERVING
                  </span>
                  <h1 class="mymainclinictokennumber">
                      A-028
                  </h1>
                  <h4 class="mymainclinicpatient">
                      Rahul Sharma
                  </h4>
                  <p class="mymainclinicdoctor">
                      Dr. Akash Verma
                  </p>
                  <button type="button" class="btn btn-warning btn-sm mymainclinicskipbtn">
                      <i class="bi bi-skip-forward-fill">
                      </i>
                      Skip for Now
                  </button>
                  <button type="button" class="btn btn-success btn-sm mymaincliniccompletebtn">
                      <i class="bi bi-check-circle-fill">
                      </i>
                      Complete
                  </button>
              </div> -->
            </div>
        </div>
      </div>
      <!------------------------------------------------------------>
      <!-- RIGHT PANEL -->
      <!------------------------------------------------------------>
      <div class="col-lg-8">
        <div class="row g-4">
          <!------------ Card 1 ------------>
          <div class="col-md-6">
            <div class="mymaincliniccard">
                <div class="mymainclinicicon mymainclinicblue">
                    <i class="bi bi-calendar-check">
                    </i>
                </div>
                <div class="mymaincliniccontent">
                    <div class="mymainclinictop">
                        <h3>
                            Today's Appointment
                        </h3>
                        <h1>
                            {{ $todayAppointments }}
                        </h1>
                    </div>
                    <div class="mymainclinicbottom">
                        <span>
                            Today's Appointment
                        </span>
                        <a href="{{ route('clinical_admins.dashboard.today_appointments') }}">
                            View All
                        </a>
                    </div>
                </div>
            </div>
          </div>
          <!------------ Card 2 ------------>
          <div class="col-md-6">
            <div class="mymaincliniccard">
                <div class="mymainclinicicon mymainclinicgreen">
                    <i class="bi bi-check2-circle">
                    </i>
                </div>
                <div class="mymaincliniccontent">
                    <div class="mymainclinictop">
                        <h3>
                            Completed Today
                        </h3>
                        <h1>
                            {{ $completedToday }}
                        </h1>
                    </div>
                    <div class="mymainclinicbottom">
                        <span>
                            Completed Appointment
                        </span>
                        <a href="{{ route('clinical_admins.dashboard.completed_today_appointments') }}">
                            View All
                        </a>
                    </div>
                </div>
            </div>
          </div>
          <!------------ Card 3 ------------>
          <div class="col-md-6">
            <div class="mymaincliniccard">
                <div class="mymainclinicicon mymainclinicorange">
                    <i class="bi bi-gift">
                    </i>
                </div>
                <div class="mymaincliniccontent">
                    <div class="mymainclinictop">
                        <h3>
                            Today's Birthday
                        </h3>
                        <h1>
                            {{ $birthdayToday }}
                        </h1>
                    </div>
                    <div class="mymainclinicbottom">
                        <span>
                            Birthday Patients
                        </span>
                        <a href="{{ route('clinical_admins.dashboard.todays_birthday') }}">
                            View All
                        </a>
                    </div>
                </div>
            </div>
          </div>
          <!------------ Card 4 ------------>
          <div class="col-md-6">
              <div class="mymaincliniccard">
                  <div class="mymainclinicicon mymainclinicpurple">
                      <i class="bi bi-calendar-event">
                      </i>
                  </div>
                  <div class="mymaincliniccontent">
                      <div class="mymainclinictop">
                          <h3>
                              Future Appointment
                          </h3>
                          <h1>
                              {{ $futureAppointments }}
                          </h1>
                      </div>
                      <div class="mymainclinicbottom">
                          <span>
                              Upcoming Appointment
                          </span>
                          <a href="{{ route('clinical_admins.dashboard.future_appointments') }}">
                              View All
                          </a>
                      </div>
                  </div>
              </div>
          </div>
          <!------------ Card 5 ------------>
          <div class="col-md-6">
              <div class="mymaincliniccard">
                  <div class="mymainclinicicon mymainclinicpurple">
                      <i class="bi bi-calendar-event">
                      </i>
                  </div>
                  <div class="mymaincliniccontent">
                      <div class="mymainclinictop">
                          <h3>
                              Follow Up Appointment
                          </h3>
                          <h1>
                              {{ $follow_ups }}
                          </h1>
                      </div>
                      <div class="mymainclinicbottom">
                          <span>
                              Upcoming Appointment
                          </span>
                          <a href="{{ route('clinical_admins.dashboard.follow_up') }}">
                              View All
                          </a>
                      </div>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!---------------- Floating Button ---------------->
  <!-- <button class="mymainclinicbookbtn">
      <i class="bi bi-plus-lg">
      </i>
      Appointment Book
  </button> -->
   <a href="{{ route('clinical_admins.dashboard.add_appointment') }}" class="mymainclinicbookbtn">
                  <i class="fa-solid fa-calendar-check"></i>
                  Appointment Book
              </a>
  <script>
    /*==================================================
  MY MAIN CLINIC DASHBOARD JS
==================================================*/

    document.addEventListener("DOMContentLoaded", function () {
        // mymainclinicAnimateCounter();

        // mymainclinicPulse();

        // mymainclinicBindButtons();

        // mymainclinicClock();
    });

      /*========================================
Counter Animation
========================================*/

      // function mymainclinicAnimateCounter() {
      //   const counters = document.querySelectorAll(".mymainclinictop h1");

      //   counters.forEach((counter) => {
      //       let target = parseInt(counter.innerText);

      //       let count = 0;

      //       let speed = 35;

      //       let interval = setInterval(() => {
      //           count++;

      //           counter.innerHTML = String(count).padStart(2, "0");

      //           if (count >= target) {
      //               clearInterval(interval);
      //           }
      //       }, speed);
      //   });
      // }

      /*========================================
Serving Card Pulse
========================================*/

      function mymainclinicPulse() {
          const card = document.querySelector(".mymainclinicservingcard");

          if (!card) return;

          setInterval(() => {
              card.style.transform = "scale(1.02)";

              setTimeout(() => {
                  card.style.transform = "scale(1)";
              }, 400);
          }, 1800);
      }

      /*========================================
Book Appointment
========================================*/

      // function mymainclinicBookAppointment() {
      //     alert("Open Appointment Booking Page");
      // }

      /*========================================
Floating Button
========================================*/

      // const bookBtn = document.querySelector(".mymainclinicbookbtn");

      // if (bookBtn) {
      //     bookBtn.addEventListener("click", mymainclinicBookAppointment);
      // }

      /*========================================
View All Buttons
========================================*/

    //   function mymainclinicBindButtons() {
    //       document.querySelectorAll(".mymainclinicbottom a").forEach((btn) => {
    //           btn.addEventListener("click", function (e) {
    //               e.preventDefault();

    //               alert(this.parentElement.querySelector("span").innerText);
    //           });
    //       });
    //   }

      /*========================================
Live Clock
========================================*/

    // function mymainclinicClock() {
    //   const header = document.querySelector(".mymainclinicheader");

    //   if (!header) return;

    //   const clock = document.createElement("div");

    //   clock.className = "mymainclinicclock";

    //   header.appendChild(clock);

    //   setInterval(() => {
    //       const now = new Date();

    //       clock.innerHTML = now.toLocaleTimeString();
    //   }, 1000);
    // }

      /*========================================
Demo Token Update
========================================*/

      // setTimeout(() => {
      //     document.querySelector(".mymainclinicpatient").innerHTML = "Rohit Sharma";

      //     document.querySelector(".mymainclinictokennumber").innerHTML = "A-030";
      // }, 12000);

      /*========================================
Future API Functions
========================================*/

      function mymainclinicLoadDashboard(data) {
          // Future Laravel/PHP API
      }

      function mymainclinicRefreshDashboard() {
          // Ajax Fetch
      }

      function mymainclinicLoadAppointments() {
          // Appointment List
      }

      function mymainclinicLoadBirthdayPatients() {
          // Birthday Patients
      }

      function mymainclinicLoadFutureAppointments() {
          // Future Appointment
      }

      /*========================================
Card Hover Shadow
========================================*/

      document.querySelectorAll(".mymaincliniccard").forEach((card) => {
          card.addEventListener("mouseenter", () => {
              card.style.transition = ".35s";
          });
      });

      console.log("My Main Clinic Dashboard Loaded Successfully.");

      /*=====================================
Greeting Change
=====================================*/

      // (function () {
      //     const h = document.querySelector(".mymainclinicheader h2");

      //     const hr = new Date().getHours();

      //     if (hr
      // < 12) {
      //         h.innerHTML = "Good Morning ☀️";
      //     } else if (hr < 17) {
      //         h.innerHTML = "Good Afternoon 🌤️";
      //     } else {
      //         h.innerHTML = "Good Evening 🌙";
      //     }
      // })();

      /*=====================================
Today's Date
=====================================*/

      // (function () {
      //     const p = document.querySelector(".mymainclinicheader p");

      //     const today = new Date();

      //     const options = {
      //         weekday: "long",

      //         day: "numeric",

      //         month: "long",

      //         year: "numeric",
      //     };

      //     p.innerHTML = "Today : " + today.toLocaleDateString("en-IN", options);
      // })();

      /*=====================================
Card Ripple
=====================================*/

      document.querySelectorAll(".mymaincliniccard").forEach((card) =>
          {
          card.addEventListener("click", function () {
              this.animate([{ transform: "scale(1)" }, { transform: "scale(.98)" }, { transform: "scale(1)" }], {
                  duration: 250,
              });
          });
      });

      /*=====================================
Floating Button Animation
=====================================*/

      setInterval(() => {
          const btn = document.querySelector(".mymainclinicbookbtn");

          btn.animate(
              [
                  {
                      transform: "translateY(0px)",
                  },

                  {
                      transform: "translateY(-4px)",
                  },

                  {
                      transform: "translateY(0px)",
                  },
              ],
              {
                  duration: 1000,
              }
          );
      }, 4000);

      /*=====================================
Dashboard Ready
=====================================*/

      console.log("Premium Dashboard Ready");
      </script>

   
@endsection