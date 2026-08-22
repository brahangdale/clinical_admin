
$(document).on('click', '.delete-gallery', function () {

    let button = $(this);
    let galleryId = button.data('id');
    let url = button.data('url');
    if (!confirm('Are you sure you want to delete this image?')) {
        return;
    }

    $.ajax({
        // url: "{{ route('clinical_admins.delete_gallery', '') }}/" + galleryId,
        url: url,
        type: "DELETE",

        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },


        beforeSend: function () {
            button.prop('disabled', true);
        },

        success: function (response) {

            if (response.success) {

                // Image remove from UI
                $('#gallery-' + galleryId).fadeOut(300, function () {
                    $(this).remove();

                    // If no images left
                    if ($('#existingGallery .col-md-3').length === 0) {
                        $('#existingGallery').remove();

                        $('#galleryPreview').after(`
                            <p id="noGalleryMessage" class="text-muted">
                                No gallery images available.
                            </p>
                        `);
                    }
                });

            }
        },

        error: function (xhr) {

            console.log(xhr.responseText);

            alert('Something went wrong while deleting the image.');

            button.prop('disabled', false);
        }
    });

});