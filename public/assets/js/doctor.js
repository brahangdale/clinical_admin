$(document).on('click', '.toggle-status', function () {
  let button = $(this);
  let id = button.data('id');

  $.ajax({
    url: '/doctor/toggle-status/' + id,
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

// document.querySelectorAll(".form-check-input").forEach(function (checkbox) {
//     function toggleDay() {
//      let container = checkbox.closest(".justify-content-between");
//      let inputDay = container.querySelector(".inputday");

//      if (checkbox.checked) {
//       inputDay.classList.add("off-day");

//       // Disable all inputs
//       inputDay.querySelectorAll("input, select, textarea").forEach(function (el) {
//        el.disabled = true;
//       });
//      } else {
//       inputDay.classList.remove("off-day");

//       // Enable all inputs
//       inputDay.querySelectorAll("input, select, textarea").forEach(function (el) {
//        el.disabled = false;
//       });
//      }
//     }

//     checkbox.addEventListener("change", toggleDay);

//     // Page load ke time bhi check karega
//     toggleDay();
// });

// $(document).ready(function () {

//     /*
//     |--------------------------------------------------------------------------
//     | TIMEPICKER SETTINGS
//     |--------------------------------------------------------------------------
//     */

//     const timePickerOptions = {
//         timeFormat: 'h:i A',
//         interval: 15,
//         minTime: '12:00 AM',
//         maxTime: '11:45 PM',
//         dynamic: false,
//         dropdown: true,
//         scrollbar: true
//     };


//     /*
//     |--------------------------------------------------------------------------
//     | INITIALIZE ALL TIME INPUTS
//     |--------------------------------------------------------------------------
//     */

//     $('.schedule-time').each(function () {

//         $(this).timepicker(timePickerOptions);

//     });


//     /*
//     |--------------------------------------------------------------------------
//     | FUNCTION: GET END TIME PICKER
//     |--------------------------------------------------------------------------
//     */

//     function updateEndTime(startInput, endInput) {

//         const startTime = $(startInput).val();

//         if (!startTime) {
//             return;
//         }

//         /*
//         Remove existing timepicker
//         */

//         $(endInput).timepicker('remove');


//         /*
//         Get start time
//         */

//         const startDate = new Date(
//             '2000/01/01 ' + startTime
//         );


//         /*
//         Add 15 minutes
//         */

//         startDate.setMinutes(
//             startDate.getMinutes() + 15
//         );


//         /*
//         Convert to 12-hour format
//         */

//         let hours = startDate.getHours();
//         let minutes = startDate.getMinutes();

//         let ampm = hours >= 12 ? 'PM' : 'AM';

//         hours = hours % 12;

//         hours = hours ? hours : 12;

//         minutes = minutes < 10
//             ? '0' + minutes
//             : minutes;

//         const minEndTime =
//             hours + ':' + minutes + ' ' + ampm;


//         /*
//         Initialize End Time picker
//         */

//         $(endInput).timepicker({

//             timeFormat: 'h:i A',

//             interval: 15,

//             minTime: minEndTime,

//             maxTime: '11:45 PM',

//             dynamic: false,

//             dropdown: true,

//             scrollbar: true

//         });


//         /*
//         Check existing End Time
//         */

//         const currentEnd = $(endInput).val();

//         if (currentEnd) {

//             const currentEndDate =
//                 new Date('2000/01/01 ' + currentEnd);

//             if (currentEndDate <= startDate) {

//                 $(endInput).val('');

//             }

//         }

//     }


//     /*
//     |--------------------------------------------------------------------------
//     | MORNING START → MORNING END
//     |--------------------------------------------------------------------------
//     */

//     $(document).on(
//         'change',
//         '.morning-start',
//         function () {

//             const dayContainer =
//                 $(this).closest('.day-schedule');

//             const endInput =
//                 dayContainer.find('.morning-end');

//             updateEndTime(this, endInput);

//         }
//     );


//     /*
//     |--------------------------------------------------------------------------
//     | EVENING START → EVENING END
//     |--------------------------------------------------------------------------
//     */

//     $(document).on(
//         'change',
//         '.evening-start',
//         function () {

//             const dayContainer =
//                 $(this).closest('.day-schedule');

//             const endInput =
//                 dayContainer.find('.evening-end');

//             updateEndTime(this, endInput);

//         }
//     );


//     /*
//     |--------------------------------------------------------------------------
//     | GENERAL START → GENERAL END
//     |--------------------------------------------------------------------------
//     */

//     $(document).on(
//         'change',
//         '.general-start',
//         function () {

//             const dayContainer =
//                 $(this).closest('.day-schedule');

//             const endInput =
//                 dayContainer.find('.general-end');

//             updateEndTime(this, endInput);

//         }
//     );


//     /*
//     |--------------------------------------------------------------------------
//     | OFF DAY
//     |--------------------------------------------------------------------------
//     */

//     $('.off-day').on('change', function () {

//         const dayContainer =
//             $(this).closest('.day-schedule');

//         const inputs =
//             dayContainer.find('.schedule-time');


//         if ($(this).is(':checked')) {

//             /*
//             | OFF DAY
//             */

//             inputs
//                 .val('')
//                 .prop('disabled', true);

//         } else {

//             /*
//             | WORKING DAY
//             */

//             inputs
//                 .prop('disabled', false);

//         }

//     });


//     /*
//     |--------------------------------------------------------------------------
//     | INITIAL OFF DAY STATE
//     |--------------------------------------------------------------------------
//     */

//     $('.off-day').each(function () {

//         if ($(this).is(':checked')) {

//             const dayContainer =
//                 $(this).closest('.day-schedule');

//             dayContainer
//                 .find('.schedule-time')
//                 .val('')
//                 .prop('disabled', true);

//         }

//     });

    

// });