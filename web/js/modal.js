$(document).ready(function(){
    $('#modalBtn').click(function () {
        $('#modal').show()
            .find('#modalContent')
            .load($(this)
                .attr('value')
            )
    })
});