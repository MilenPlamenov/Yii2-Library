$(function () {
    $('.update-modal-link').click(function (e) {
        e.preventDefault();
        $('#modal')
            .modal('show')
            .find('#modelContent')
            .load($(this).attr('href'));
    });
});

