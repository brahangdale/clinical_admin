<!-- Bottom Nav -->

  <div class="bottom-nav">
  <a href="{{ route('patient_site.home') }}" class="active">
      <i class="fa-solid fa-house"></i>
      <span>Home</span>
  </a>

  <a href="{{ route('patient_site.about') }}">
      <i class="fa-solid fa-circle-info"></i>
      <span>About</span>
  </a>

  <a href="{{ route('patient_site.location') }}">
      <i class="fa-solid fa-location-dot"></i>
      <span>Location</span>
  </a>

  <a href="{{ route('patient_site.games') }}">
      <i class="fa-solid fa-gamepad"></i>
      <span>Game</span>
  </a>
  </div>

  <!-- Floating Social Button -->
  <div class="social-float">
  <a href="https://www.instagram.com/" target="_blank" class="social-item instagram">
      <i class="fab fa-instagram"></i>
  </a>

  <a href="https://www.facebook.com/" target="_blank" class="social-item facebook">
      <i class="fab fa-facebook-f"></i>
  </a>

  <button class="social-toggle" id="socialToggle">
      <i class="fas fa-comments"></i>
  </button>
  </div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <script type="text/javascript">
  const socialToggle = document.getElementById("socialToggle");
  const socialFloat = document.querySelector(".social-float");

  socialToggle.addEventListener("click", () => {
      socialFloat.classList.toggle("active");
  });
  </script>
  <!-- Floating Social Button end -->

  <script type="text/javascript" src="{{ url('assets\js\appointment.js') }}"></script>

  <script src="{{ url('assets\js\patient_script.js') }}">

  document.getElementById("popupInstallBtn")
  .addEventListener("click", async () => {

      if(!deferredPrompt) return;

      deferredPrompt.prompt();

      const result = await deferredPrompt.userChoice;

      popup.style.display = "none";
  });

  document.getElementById("closePopup")
  .addEventListener("click", () => {

      popup.style.display = "none";

      localStorage.setItem(
          "hideInstallPopup",
          "yes"
      );
  });
  </script>
  <!-- voice script start -->
<script type="text/javascript">
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

if (SpeechRecognition) {

    document.querySelectorAll(".voice-btn").forEach(function(btn){

        btn.addEventListener("click",function(){

            const recognition = new SpeechRecognition();

            // recognition.lang = "hi-IN"; Hindi
             recognition.lang = "en-IN"; // English
            // recognition.lang = "mr-IN";

            recognition.interimResults = false;
            recognition.maxAlternatives = 1;

            const input = this.previousElementSibling;

            this.classList.add("listening");

            recognition.start();

            recognition.onresult = function(event){

                input.value = event.results[0][0].transcript;

            };

            recognition.onend = ()=>{

                btn.classList.remove("listening");

            };

            recognition.onerror = ()=>{

                btn.classList.remove("listening");

            };

        });

    });

}else{

    alert("Speech Recognition is not supported in this browser.");

}
</script>


<!-- ********farm fill validations and automatic fill Age start******** -->
<!-- <script type="text/javascript">
const day = document.getElementById("dobDay");
const month = document.getElementById("dobMonth");
const year = document.getElementById("dobYear");
const age = document.getElementById("patientAge");

const currentYear = new Date().getFullYear();

[day, month, year].forEach(input => {

    input.addEventListener("input", function () {

        // Only Numbers
        this.value = this.value.replace(/\D/g, "");

        // ======================
        // Day
        // ======================
        if (this.id === "dobDay") {

            if (parseInt(this.value) > 31)
                this.value = "31";

            if (this.value.length == 2)
                month.focus();
        }

        // ======================
        // Month
        // ======================
        if (this.id === "dobMonth") {

            if (parseInt(this.value) > 12)
                this.value = "12";

            if (this.value.length == 2)
                year.focus();
        }

        // ======================
        // Year
        // ======================
        if (this.id === "dobYear") {

            if (this.value.length == 4) {

                let y = parseInt(this.value);

                if (y < 1900)
                    this.value = "1900";

                if (y > currentYear)
                    this.value = currentYear;

                calculateAge();
            }
        }

    });

});


// ==========================
// Calculate Age
// ==========================
function calculateAge() {

    if (
        day.value.length != 2 ||
        month.value.length != 2 ||
        year.value.length != 4
    ) {
        age.value = "";
        return;
    }

    const dob = new Date(
        parseInt(year.value),
        parseInt(month.value) - 1,
        parseInt(day.value)
    );

    // Invalid Date Check
    if (
        dob.getDate() != parseInt(day.value) ||
        dob.getMonth() != parseInt(month.value) - 1 ||
        dob.getFullYear() != parseInt(year.value)
    ) {
        age.value = "";
        return;
    }

    const today = new Date();

    let years = today.getFullYear() - dob.getFullYear();

    let m = today.getMonth() - dob.getMonth();

    if (
        m < 0 ||
        (m == 0 && today.getDate() < dob.getDate())
    ) {
        years--;
    }

    age.value = years;
}
</script> -->
<!-- ********farm fill validations and automatic fill Age End******** -->

  </div>
  </body>
  </html>