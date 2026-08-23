<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>

/* =========================================================
   SEARCH CLINICS
========================================================= */

function searchPartnerClinics(){

    const searchValue =
        document
        .getElementById(
            'partnerClinicSearch'
        )
        .value
        .toLowerCase()
        .trim();


    const clinics =
        document.querySelectorAll(
            '.partner-clinic-item'
        );


    let visibleCount = 0;


    clinics.forEach(function(clinic){

        const searchableText =
            clinic.dataset.search
            .toLowerCase();


        if(
            searchableText.includes(
                searchValue
            )
        ){

            clinic.style.display = '';

            visibleCount++;

        }else{

            clinic.style.display = 'none';

        }

    });


    document.getElementById(
        'partnerNoResult'
    ).style.display =
        visibleCount === 0
        ? 'block'
        : 'none';

}

/* =========================================================
   VIEW PERFORMANCE
========================================================= */
function viewPartnerPerformance(clinicId, clinicName) {

    const performance = document.getElementById('partnerPerformance');

    // Store selected clinic ID
    performance.dataset.clinicId = clinicId;

    // Show clinic name
    document.getElementById('selectedClinicName').innerText = clinicName;

    // Open performance section
    performance.classList.add('active');

    // Default date = today
    const today = new Date().toISOString().split('T')[0];

    document.getElementById('partnerFromDate').value = today;
    document.getElementById('partnerToDate').value = today;

    // Load performance data
    loadPartnerPerformance();

    // Scroll
    performance.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}


function loadPartnerPerformance() {

    const performance =
        document.getElementById('partnerPerformance');

    const clinicId =
        performance.dataset.clinicId;

    const fromDate =
        document.getElementById('partnerFromDate').value;

    const toDate =
        document.getElementById('partnerToDate').value;


    console.log('Clinic ID:', clinicId);
    console.log('From Date:', fromDate);
    console.log('To Date:', toDate);


    if (!clinicId) {
        console.log('Clinic ID is missing');
        return;
    }


    fetch("{{ route('partner.clinic.performance') }}", {

        method: "POST",

        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        },

        body: JSON.stringify({
            clinic_id: clinicId,
            from_date: fromDate,
            to_date: toDate
        })

    })

    .then(response => {

        console.log('HTTP Status:', response.status);

        return response.json();

    })

    .then(data => {

        console.log('Performance Response:', data);

        if (!data.success) {
            console.log('API returned success = false');
            return;
        }


        console.log('Total Patients:', data.total_patients);
        console.log('Completed:', data.completed_patients);
        console.log('Appointments:', data.total_appointments);
        console.log('Revenue:', data.total_revenue);
        console.log('Partner Payment:', data.partner_payment);


        document.getElementById('performancePatients').innerText =
            data.total_patients;

        document.getElementById('performanceCompleted').innerText =
            data.completed_patients;

        document.getElementById('performanceAppointments').innerText =
            data.total_appointments;

        document.getElementById('performanceRevenue').innerText =
            '₹' + Number(data.total_revenue)
                .toLocaleString('en-IN');

        document.getElementById('summaryTotalRevenue').innerText =
            '₹' + Number(data.total_revenue)
                .toLocaleString('en-IN');

        document.getElementById('summaryPartnerPayment').innerText =
            '₹' + Number(data.partner_payment)
                .toLocaleString('en-IN');

    })

    .catch(error => {

        console.error('Performance Error:', error);

    });
}


/* =========================================================
   CLOSE PERFORMANCE
========================================================= */

function closePartnerPerformance(){

    document
        .getElementById(
            'partnerPerformance'
        )
        .classList.remove(
            'active'
        );

}


/* =========================================================
   APPLY PERFORMANCE FILTER
========================================================= */

// function applyPartnerDateFilter(){

//     const fromDate =
//         document.getElementById(
//             'partnerFromDate'
//         ).value;


//     const toDate =
//         document.getElementById(
//             'partnerToDate'
//         ).value;


//     if(!fromDate || !toDate){

//         alert(
//             'Please select both dates.'
//         );

//         return;

//     }


//     if(fromDate > toDate){

//         alert(
//             'From Date cannot be greater than To Date.'
//         );

//         return;

//     }


//     /*
//         =====================================================
//         REAL BACKEND
//         =====================================================

//         Example:

//         GET:

//         /partner/clinics/{clinicId}/performance

//         ?from=2026-08-01
//         &to=2026-08-22


//         Backend response:

//         {
//             patients: 124,
//             completed: 108,
//             appointments: 132,
//             revenue: 74850,
//             partner_payment: 7485
//         }

//     */


//     /* DEMO VALUES */

//     document.getElementById(
//         'performancePatients'
//     ).innerText = '124';


//     document.getElementById(
//         'performanceCompleted'
//     ).innerText = '108';


//     document.getElementById(
//         'performanceAppointments'
//     ).innerText = '132';


//     document.getElementById(
//         'performanceRevenue'
//     ).innerText = '₹74,850';


//     document.getElementById(
//         'summaryTotalRevenue'
//     ).innerText = '₹74,850';


//     document.getElementById(
//         'summaryPartnerPayment'
//     ).innerText = '₹7,485';

// }

function applyPartnerDateFilter() {

    const fromDate =
        document.getElementById('partnerFromDate').value;

    const toDate =
        document.getElementById('partnerToDate').value;

    if (!fromDate || !toDate) {
        alert('Please select both dates.');
        return;
    }

    if (fromDate > toDate) {
        alert('From Date cannot be greater than To Date.');
        return;
    }

    loadPartnerPerformance();
}


/* =========================================================
   LOGOUT
========================================================= */

function partnerLogout(){

    const confirmLogout =
        confirm(
            'Are you sure you want to logout?'
        );


    if(!confirmLogout){

        return;

    }


    /*
        Laravel example:

        window.location.href =
        '/partner/logout';

        OR:

        document
        .getElementById('logoutForm')
        .submit();

    */


    alert(
        'Logout process goes here.'
    );

}


/* =========================================================
   GENERATE CLINIC
========================================================= */


</script>


</body>
</html>