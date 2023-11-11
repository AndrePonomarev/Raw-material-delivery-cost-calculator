
$('#calculation-form').on('submit', function(event) {
    var form = $(this);
    $.ajax({
        url: '/calculate',
        type: 'post',
        data: form.serialize(),
        success: function(response) {
            // В response должен быть HTML с результатами расчета
            console.log(response);
            $('#result-container').html(response);
        }
    });
    
    return false;
});
