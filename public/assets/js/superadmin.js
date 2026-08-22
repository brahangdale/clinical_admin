
// login show off password script start -->
function samTogglePassword(){

    let input =
    document.getElementById(
    "samLoginPassword"
    );

    if(input.type === "password")
    {
        input.type = "text";
    }
    else
    {
        input.type = "password";
    }

}
//login show off password script end -->

//Clinic save popup start

function samCreateClinic(){

    console.log("Save Clinic Clicked");

    const addModal =
    bootstrap.Modal.getOrCreateInstance(
        document.getElementById("samAddClinicModal")
    );

    addModal.hide();

    setTimeout(() => {

        const credentialModal =
        bootstrap.Modal.getOrCreateInstance(
            document.getElementById("samCredentialModal")
        );

        credentialModal.show();

    }, 300);

}

//status auto color change start
document.querySelectorAll('.sam-status-dropdown')
.forEach(function(select){

    function updateColor(){

        select.classList.remove(
            'sam-status-pending',
            'sam-status-confirmed',
            'sam-status-patient',
            'sam-status-running',
            'sam-status-completed',
            'sam-status-cancelled',
            'sam-status-noshow'
        );

        switch(select.value){

            case 'pending':
                select.classList.add('sam-status-pending');
            break;

            case 'confirmed':
                select.classList.add('sam-status-confirmed');
            break;

            case 'patient_in':
                select.classList.add('sam-status-patient');
            break;

            case 'running':
                select.classList.add('sam-status-running');
            break;

            case 'completed':
                select.classList.add('sam-status-completed');
            break;

            case 'cancelled':
                select.classList.add('sam-status-cancelled');
            break;

            case 'no_show':
                select.classList.add('sam-status-noshow');
            break;
        }
    }

    updateColor();

    select.addEventListener(
        'change',
        updateColor
    );

});

// status auto color change end //

// super report js start// Reports Page Charts

// if(document.getElementById('appointmentChart')){
//     const months = JSON.parse(chart.dataset.months);
//     const counts = JSON.parse(chart.dataset.counts);
//     new Chart(
//         document.getElementById('appointmentChart'),
//         {
//             type:'line',

//             data:{
//                 labels: months,
//                 // labels: months[
//                 //     'Jan',
//                 //     'Feb',
//                 //     'Mar',
//                 //     'Apr',
//                 //     'May',
//                 //     'Jun'
//                 // ],

//                 datasets:[{
//                     label:'Appointments',
//                     data: counts,
//                     // data:[
//                     //     120,
//                     //     180,
//                     //     220,
//                     //     260,
//                     //     300,
//                     //     420
//                     // ],

//                     borderWidth:3,

//                     tension:.4
//                 }]
//             }
//         }
//     );

// }
const chart = document.getElementById('appointmentChart');

if (chart) {

    const months = JSON.parse(chart.dataset.months);
    const counts = JSON.parse(chart.dataset.counts);

    new Chart(chart, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Appointments',
                data: counts,
                borderWidth: 3,
                tension: 0.4
            }]
        }
    });

}

// if(document.getElementById('statusChart')){

//     new Chart(
//         document.getElementById('statusChart'),
//         {
//             type:'doughnut',

//             data:{
//                 labels:[
//                     'Completed',
//                     'Pending',
//                     'Cancelled'
//                 ],

//                 datasets:[{
//                     data:[
//                         4200,
//                         245,
//                         135
//                     ]
//                 }]
//             }
//         }
//     );

// }


// super report js end


// mobile menu collapes bar start
// ==========================
// MOBILE SIDEBAR
// ==========================
const statusChart = document.getElementById('statusChart');

if (statusChart) {

    const statusData = JSON.parse(statusChart.dataset.status);

    new Chart(statusChart, {
        type: 'doughnut',

        data: {
            labels: [
                'Completed',
                'Pending',
                'Cancelled'
            ],

            datasets: [{
                data: statusData
            }]
        }
    });

}
const sidebar =
document.querySelector(
'.sam-dashboard-sidebar'
);

const overlay =
document.querySelector(
'.sam-sidebar-overlay'
);

const toggleBtn =
document.getElementById('samSidebarToggle');

if(
    sidebar &&
    overlay &&
    toggleBtn
){

    toggleBtn.addEventListener(
    'click',
    function(){

        sidebar.classList.toggle(
            'sam-sidebar-open'
        );

        overlay.classList.toggle(
            'active'
        );

    });

    overlay.addEventListener(
    'click',
    function(){

        sidebar.classList.remove(
            'sam-sidebar-open'
        );

        overlay.classList.remove(
            'active'
        );

    });

}

// mobile menu collapes bar end

/*sudy monday start*/
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".day-schedule").forEach(dayCard => {

        const checkbox = dayCard.querySelector(".form-check-input");
        const timeInputs = dayCard.querySelectorAll('input[type="time"]');

        function toggleInputs() {

            if (checkbox.checked) {

                timeInputs.forEach(input => {
                    input.disabled = true;
                    input.value = "";
                });

                dayCard.style.opacity = "0.6";

            } else {

                timeInputs.forEach(input => {
                    input.disabled = false;
                });

                dayCard.style.opacity = "1";
            }
        }

        checkbox.addEventListener("change", toggleInputs);

        toggleInputs();
    });

});
/*sudy monday end*/
/*Add Model open with error*/
// document.addEventListener("DOMContentLoaded", function () {
//     // alert("fgffg")
//     const pageData = document.getElementById("page-data");

//     if (!pageData) return;

//     const hasErrors = pageData.dataset.errors;
//     const hasSuccess = pageData.dataset.success;

//     if (hasErrors === "1") {

//         const addModal = document.getElementById("samAddClinicModal");

//         if (addModal) {
//             new bootstrap.Modal(addModal).show();
//         }

        
//     }

//     if (hasSuccess === "1") {

//         const successModal = document.getElementById("samCredentialModal");

//         if (successModal) {
//             new bootstrap.Modal(successModal).show();
//         }
//     }

// });
/*Add Model open with error*/

document.addEventListener("DOMContentLoaded", function () {
   
    const pageData = document.getElementById("page-data");
    
    if (!pageData) return;
    const hasSuccess = pageData.dataset.success;

    if (pageData.dataset.errors === "1") {

        const modalId = pageData.dataset.modalId;
        

        if (modalId) {
            const modal = document.getElementById(modalId);

            if (modal) {
                new bootstrap.Modal(modal).show();
            }
        }
    }

    if (hasSuccess === "1") {

        const successModal = document.getElementById("samCredentialModal");

        if (successModal) {
            new bootstrap.Modal(successModal).show();
        }
    }

});

/*enable disable status*/ 
$(document).on('click', '.toggle-clinic', function () {
    // alert("hoooo");
    let button = $(this);
    let id = button.data('id');

    $.ajax({
      url: '/clinic/toggle-status/' + id,
      type: 'POST',
      data: {
        _token: $('meta[name="csrf-token"]').attr('content')
      },
      success: function (response) {
        console.log(response);
        let row = $('#row-' + id);
        // alert(response.status)
        if(response.status == 1){

            button
                .removeClass('btn-success')
                .addClass('btn-danger')
                .text('Disable');

            row.find('.status-text').html(
                '<span class="badge bg-success">Active</span>'
            );

        }else{

            button
                .removeClass('btn-danger')
                .addClass('btn-success')
                .text('Enable');

            row.find('.status-text').html(
                '<span class="badge bg-danger">Inactive</span>'
            );
        }
      },
      error: function () {
        console.log(xhr.responseText);
      }
    });
});
/*enable disable status*/ 

$('.edit-btn').click(function () {
    console.log("edit doctor")
     console.log("alert")
    let id = $(this).data('id');

    $.get('/doctors/' + id + '/edit', function (response) {

        $('#doctor_name').val(response.doctor.doctor_name);

        $('#samEditDoctorModal').attr(
            'action',
            '/doctors/' + id
        );

    });

});


