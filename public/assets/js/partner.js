$(document).on('click', '.toggle-partner', function () {
  let button = $(this);
  let id = button.data('id');

  $.ajax({
    url: '/partner/toggle-status/' + id,
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