$(document).on('click', '.mymainclinicskipbtn', function () {

    let button = $(this);
    let url = button.attr('data-url');

    console.log('SKIP URL:', url);

    button.prop('disabled', true);

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },

        success: function (response) {

            console.log('SKIP RESPONSE:', response);

            if (response.success) {

                updateCurrentTokenCard(response);

            } else {

                alert(response.message);
            }
        },

        error: function (xhr) {

            console.log('SKIP ERROR:', xhr.responseText);

            alert('Something went wrong while skipping token.');
        },

        complete: function () {

            button.prop('disabled', false);
        }
    });

});


$(document).on('click', '.mymaincliniccompletebtn', function () {

    let button = $(this);
    let url = button.attr('data-url');

    console.log('COMPLETE URL:', url);

    button.prop('disabled', true);

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },

        success: function (response) {

            console.log('COMPLETE RESPONSE:', response);

            if (response.success) {

                updateCurrentTokenCard(response);

            } else {

                alert(response.message);
            }
        },

        error: function (xhr) {

            console.log('COMPLETE ERROR:', xhr.responseText);

            alert('Something went wrong while completing token.');
        },

        complete: function () {

            button.prop('disabled', false);
        }
    });

});


function updateCurrentTokenCard(response) {

    console.log('UPDATE CARD RESPONSE:', response);

    let doctorId = response.doctor_id;

    let card = $(
        '.mymainclinicservingcard[data-doctor-id="' +
        doctorId +
        '"]'
    );

    console.log('DOCTOR ID:', doctorId);
    console.log('CARD FOUND:', card.length);

    let next = response.nextAppointment;

    console.log('NEXT APPOINTMENT:', next);


    // -----------------------------------------
    // NEXT PATIENT NAHI HAI
    // -----------------------------------------

    if (!next) {

        card.find('.mymainclinicstatus')
        .text('QUEUE COMPLETED');

    card.find('.mymainclinictokennumber')
        .text('--');

    card.find('.mymainclinicpatient')
        .text('All Patients Completed');

    card.find('.mymainclinicdoctor')
        .text(response.doctor_name);

    card.find('.mymainclinicskipbtn')
        .hide();

    card.find('.mymaincliniccompletebtn')
        .hide();

    return;
    }


    // -----------------------------------------
    // NEXT PATIENT
    // -----------------------------------------

    card.find('.mymainclinicstatus')
        .text('NOW SERVING');

    card.find('.mymainclinictokennumber')
        .text(next.token_number);

    card.find('.mymainclinicpatient')
        .text(next.patient_name);

    card.find('.mymainclinicdoctor')
        .text(next.doctor_name);


    // -----------------------------------------
    // UPDATE SKIP BUTTON
    // -----------------------------------------

    card.find('.mymainclinicskipbtn')
        .attr('data-id', next.id)
        .attr('data-url', next.skip_url)
        .data('id', next.id)
        .data('url', next.skip_url)
        .show()
        .prop('disabled', false);


    // -----------------------------------------
    // UPDATE COMPLETE BUTTON
    // -----------------------------------------

    card.find('.mymaincliniccompletebtn')
        .attr('data-id', next.id)
        .attr('data-url', next.complete_url)
        .data('id', next.id)
        .data('url', next.complete_url)
        .show()
        .prop('disabled', false);


    // -----------------------------------------
    // SMALL PULSE EFFECT
    // -----------------------------------------

    card.css('transform', 'scale(1.03)');

    setTimeout(function () {

        card.css('transform', 'scale(1)');

    }, 300);
}

document.addEventListener('change', function(e) {
  if (e.target.classList.contains('appointment-status')) {

    const appointmentId = e.target.dataset.id;
    const status = e.target.value;

    const feeBox = document.getElementById(
        'consultationFee' + appointmentId
    );

    const feeInput = document.getElementById(
        'fee' + appointmentId
    );


    // If Completed → Show Fee Input
    if (status === 'completed') {

        feeBox.style.display = 'block';

        // If fee is empty, use doctor's default fee
        if (!feeInput.value) {

            feeInput.value =
                feeInput.dataset.defaultFee ?? '';

        }

    } else {

        // Other status → Hide Fee Input
        feeBox.style.display = 'none';

    }

}


// FEE CHANGE
if (e.target.classList.contains('consultation-fee-input')) {

    const appointmentId = e.target.dataset.id;

    const fee = e.target.value;


    if (fee === '') {
        return;
    }
    fetch('/appointments/' + appointmentId + '/fee', {
        method: 'POST',

        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector(
                'meta[name="csrf-token"]'
            ).getAttribute('content'),
            'Accept': 'application/json'
        },

        body: JSON.stringify({
            consultation_fee: fee
        })
    })
    .then(response => response.json())
    .then(data => {

        if (data.success) {

            console.log('Fee saved successfully');

        }

    })
    .catch(error => {

        console.error(error);

    });
  }
});
