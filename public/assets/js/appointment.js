$(document).ready(function () {
  $('.clinic_id').on('change', function () {
    let clinicId = $(this).val();
    $('.doctor_id').html('<option value="">Loading...</option>');
    if(clinicId){
      $.ajax({
        url: '/get-doctors/' + clinicId,
        type: 'GET',
        success: function(response){
          let options = '<option value="">Select Doctor</option>';
          $.each(response, function(index, doctor){
            // alert(doctor);
            options += `<option value="${doctor.id}">${doctor.doctor_name}</option>`;
          });
          $('.doctor_id').html(options);
        }
      });
    }else
    {
      $('.doctor_id').html('<option value="">Select Doctor</option>');
    }
  });

  $('.appointment-status').change(function () {
    console.log($(this).val());
    console.log($(this).data('id'));
    let status = $(this).val();
    let id = $(this).data('id');

    $.ajax({
      url: '/update-status/'+ id,
      type: "POST",
      data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            status: status
        },
      success: function (response) {
        // alert(response.message, "successs");
        console.log(response.message, "successs")
      },
      error: function () {
        alert('Something went wrong.');
      }
    });

  });


  
});
$(document).on('change', '.dob', function () {

    let dobValue = $(this).val();

    console.log("Selected DOB:", dobValue);

    let dob;

    if (dobValue.includes('/')) {

        let parts = dobValue.split('/');

        let day = parseInt(parts[0]);
        let month = parseInt(parts[1]) - 1;
        let year = parseInt(parts[2]);

        dob = new Date(year, month, day);

    } else {

        dob = new Date(dobValue);
    }

    let today = new Date();

    let age = today.getFullYear() - dob.getFullYear();

    let month = today.getMonth() - dob.getMonth();

    if (
        month < 0 ||
        (month === 0 && today.getDate() < dob.getDate())
    ) {
        age--;
    }

    // SAME modal/form ke andar age update
    $(this).closest('form').find('.age').val(age);

    console.log("Calculated Age:", age);
});

$('#doctor_id, #appointment_date').on('change', function () {
  
    const doctorId = $('#doctor_id').val();
    const date = $('#appointment_date').val();

    if (!doctorId || !date) {

        $('#doctor-shifts').html(`
            <p class="text-muted">
                Select doctor and appointment date.
            </p>
        `);

        return;
    }

    $.ajax({

        url: `/doctors/${doctorId}/schedule`,

        type: 'GET',

        data: {
            date: date
        },

        success: function (response) {

            let html = '';

            if (!response.shifts.length) {

                html = `
                    <div class="alert alert-warning">
                        Doctor is not available on this day.
                    </div>
                `;

            } else {

                response.shifts.forEach(function (shift, index) {

                    html += `
                        <div class="form-check mb-2">

                            <input
                                class="form-check-input"
                                type="radio"
                                name="shift"
                                id="shift_${index}"
                                value="${shift.name}"
                                data-start="${shift.start}"
                                data-end="${shift.end}"
                            >

                            <label
                                class="form-check-label"
                                for="shift_${index}"
                            >
                                <strong>${shift.name}</strong>
                                -
                                ${shift.start} to ${shift.end}
                            </label>

                        </div>
                    `;
                });
            }

            $('#doctor-shifts').html(html);
        },

        error: function () {

            $('#doctor-shifts').html(`
                <div class="alert alert-danger">
                    Unable to load doctor schedule.
                </div>
            `);

        }

    });

});
// SELECT SHIFT
// ======================================

$(document).on('change', 'input[name="shift"]', function () {

    const shiftName = $(this).val();
    const shiftStart = $(this).data('start');
    const shiftEnd = $(this).data('end');

    $('#shift_name').val(shiftName);

    $('#shift_time').val(`${shiftStart} - ${shiftEnd}`);

    console.log('Shift Name:', shiftName);
    console.log('Shift Time:', `${shiftStart} - ${shiftEnd}`);

});

// edit appointment shift loading
// $(document).ready(function () {

  function loadDoctorShifts($form) {

    let doctorId = $form.find('.edit_doctor_id').val();
    let date = $form.find('.edit_appointment_date').val();

    let savedShift = $form.find('.saved_shift_name').val() || '';
    let savedTime = $form.find('.saved_shift_time').val() || '';

    console.log('Doctor:', doctorId);
    console.log('Date:', date);
    console.log('Saved Shift:', savedShift);
    console.log('Saved Time:', savedTime);


    let $shiftContainer = $form.find('.doctor-shifts');
    let $timeContainer = $form.find('.shift-times');


    if (!doctorId || !date) {

        $shiftContainer.html(`
            <p class="text-muted mb-0">
                Select doctor and appointment date.
            </p>
        `);

        $timeContainer.html(`
            <p class="text-muted mb-0">
                Select a shift.
            </p>
        `);

        return;
    }


    $.ajax({

        url: '/doctors/' + doctorId + '/schedule',

        type: 'GET',

        data: {
            date: date
        },

        success: function(response) {

            console.log('Schedule Response:', response);


            $shiftContainer.empty();

            $timeContainer.html(`
                <p class="text-muted mb-0">
                    Select a shift.
                </p>
            `);


            if (
                !response.success ||
                !response.shifts ||
                response.shifts.length === 0
            ) {

                $shiftContainer.html(`
                    <p class="text-danger mb-0">
                        No shift available for this date.
                    </p>
                `);

                return;
            }


            // ==============================
            // SHOW ALL SHIFTS
            // ==============================

            $.each(response.shifts, function(index, shift) {

                let checked =
                    shift.name === savedShift
                        ? 'checked'
                        : '';


                // unique ID for this form
                let radioId =
                    'shift_' +
                    Date.now() +
                    '_' +
                    index;


                $shiftContainer.append(`

                    <div class="form-check me-3">

                        <input
                            class="form-check-input shift-radio"
                            type="radio"
                            name="edit_shift"
                            id="shift_${index}"
                            value="${shift.name}"
                            data-start="${shift.start}"
                            data-end="${shift.end}"
                            ${checked}
                        >


                         

                        <label
                            class="form-check-label"
                            for="${radioId}"
                        >

                            <strong>${shift.name}</strong>

                            <br>

                            <small class="text-muted">
                                ${shift.start} - ${shift.end}
                            </small>

                        </label>

                    </div>

                `);

            });


            // ==============================
            // FIND SAVED SHIFT
            // ==============================

            let selectedShift =
                response.shifts.find(function(shift) {

                    return shift.name === savedShift;

                });


            if (selectedShift) {

                loadShiftTimes(
                    $form,
                    selectedShift.start,
                    selectedShift.end,
                    savedTime
                );

            } else {

                // No saved shift
                // Select first shift

                let firstShift = response.shifts[0];

                $form
                    .find('.shift-radio')
                    .first()
                    .prop('checked', true);


                loadShiftTimes(
                    $form,
                    firstShift.start,
                    firstShift.end,
                    ''
                );
            }

        },

        error: function(xhr) {

            console.log(
                'Schedule Error:',
                xhr.responseText
            );

        }

    });
  }


    // --------------------------------
    // LOAD SHIFT TIMES
    // --------------------------------

//     function loadShiftTimes(
//     $form,
//     start,
//     end,
//     selectedTime = ''
// ) {

//     let $timeContainer = $form.find('.shift-times');

//     $timeContainer.empty();


//     let startMinutes = convertToMinutes(start);
//     let endMinutes = convertToMinutes(end);


//     if (
//         startMinutes === null ||
//         endMinutes === null
//     ) {

//         $timeContainer.html(`
//             <p class="text-danger">
//                 Invalid shift time.
//             </p>
//         `);

//         return;
//     }


//     // ==============================
//     // HANDLE OVERNIGHT SHIFT
//     // Example:
//     // 10:00 AM -> 02:00 AM
//     // ==============================

//     if (endMinutes <= startMinutes) {
//         endMinutes += 24 * 60;
//     }


//     for (
//         let minutes = startMinutes;
//         minutes <= endMinutes;
//         minutes += 30
//     ) {

//         let time = convertTo12Hour(minutes);


//         let checked =
//             time === selectedTime
//                 ? 'checked'
//                 : '';


//         let radioId =
//             'time_' +
//             Date.now() +
//             '_' +
//             minutes;


//         $timeContainer.append(`

//             <div class="form-check form-check-inline">

//                 <input
//                     class="form-check-input time-radio"
//                     type="radio"
//                     name="shift_time"
//                     id="${radioId}"
//                     value="${time}"
//                     ${checked}
//                 >

//                 <label
//                     class="form-check-label"
//                     for="${radioId}"
//                 >
//                     ${time}
//                 </label>

//             </div>

//         `);

//     }
// }

function loadShiftTimes(
    $form,
    start,
    end,
    selectedTime = ''
) {

    let $timeContainer = $form.find('.shift-times');

    $timeContainer.empty();

    // DB value:
    // "10:00 AM - 02:00 AM"
    //
    // We only need:
    // "10:00 AM"

    if (selectedTime && selectedTime.includes(' - ')) {

        selectedTime = selectedTime
            .split(' - ')[0]
            .trim();

    }

    console.log('Time to select:', selectedTime);


    // let startMinutes = convertToMinutes(start);
    // let endMinutes = convertToMinutes(end);

    // if (
    //     startMinutes === null ||
    //     endMinutes === null
    // ) {

    //     $timeContainer.html(`
    //         <p class="text-danger">
    //             Invalid shift time.
    //         </p>
    //     `);

    //     return;
    // }


    // Overnight shift
    // if (endMinutes <= startMinutes) {
    //     endMinutes += 24 * 60;
    // }


    // for (
    //     let minutes = startMinutes;
    //     minutes <= endMinutes;
    //     minutes += 30
    // ) {

//         let time = convertTo12Hour(minutes);

//         let checked =
//             time === selectedTime
//                 ? 'checked'
//                 : '';

//         let radioId =
//             'time_' +
//             Date.now() +
//             '_' +
//             minutes;


//         $timeContainer.append(`

//             <div class="form-check form-check-inline">

//                 <input
//                     class="form-check-input time-radio"
//                     type="radio"
//                     name="shift_time"
//                     id="${radioId}"
//                     value="${time}"
//                     ${checked}
//                 >

//                 <label
//                     class="form-check-label"
//                     for="${radioId}"
//                 >
//                     ${time}
//                 </label>

//             </div>

//         `);
//     }
}


    // --------------------------------
    // SHIFT RADIO CHANGE
    // --------------------------------
    $(document).on('change', 'input[name="edit_shift"]', function () {

    const shiftName = $(this).val();
    const shiftStart = $(this).data('start');
    const shiftEnd = $(this).data('end');

    $('.saved_shift_name').val(shiftName);

    $('.saved_shift_time').val(`${shiftStart} - ${shiftEnd}`);

    console.log('Shift Name:', shiftName);
    console.log('Shift Time:', `${shiftStart} - ${shiftEnd}`);

});

    // $(document).on('change', '.shift-radio', function () {

    //         let $form = $(this).closest('form');

    //         let start = $(this).data('start');
    //         let end = $(this).data('end');

    //         console.log('Selected Shift:', $(this).val());
    //         console.log('Start:', start);
    //         console.log('End:', end);


    //         loadShiftTimes(
    //             $form,
    //             start,
    //             end,
    //             ''
    //         );

    //     });


    
        $(document).on('change','.edit_doctor_id, .edit_appointment_date',function () {

          let $form = $(this).closest('form');
          // console.log('Changed:',$(this).attr('class'));
          // console.log('Doctor:',$form.find('.edit_doctor_id').val());
          // console.log('Date:',$form.find('.edit_appointment_date').val());
          $form.find('.saved_shift_name').val('');
          $form.find('.saved_shift_time').val('');
          loadDoctorShifts($form);
        }
);


    // --------------------------------
    // INITIAL LOAD
    // --------------------------------

    $(document).on(
    'shown.bs.modal',
    '.modal',
    function() {

        let $form =
            $(this).find('form');

        if (!$form.length) {
            return;
        }

        console.log(
            'EDIT MODAL OPENED'
        );

        console.log(
            'Doctor:',
            $form.find('.edit_doctor_id').val()
        );

        console.log(
            'Date:',
            $form.find('.edit_appointment_date').val()
        );

        console.log(
            'Saved Shift:',
            $form.find('.saved_shift_name').val()
        );

        console.log(
            'Saved Time:',
            $form.find('.saved_shift_time').val()
        );

        loadDoctorShifts($form);
    }
);


    // --------------------------------
    // TIME FUNCTIONS
    // --------------------------------

    // function convertToMinutes(time) {

    //     let parts = time.match(
    //         /^(\d{1,2}):(\d{2})\s?(AM|PM)$/i
    //     );

    //     if (!parts) {
    //         return null;
    //     }

    //     let hour = parseInt(parts[1]);
    //     let minute = parseInt(parts[2]);
    //     let period = parts[3].toUpperCase();

    //     if (period === 'AM' && hour === 12) {
    //         hour = 0;
    //     }

    //     if (period === 'PM' && hour !== 12) {
    //         hour += 12;
    //     }

    //     return hour * 60 + minute;
    // }


    // function convertTo12Hour(totalMinutes) {

    //     let hour = Math.floor(totalMinutes / 60);
    //     let minute = totalMinutes % 60;

    //     let period = hour >= 12 ? 'PM' : 'AM';

    //     hour = hour % 12;

    //     if (hour === 0) {
    //         hour = 12;
    //     }

    //     return String(hour).padStart(2, '0')
    //         + ':' +
    //         String(minute).padStart(2, '0')
    //         + ' ' +
    //         period;
    // }

// });