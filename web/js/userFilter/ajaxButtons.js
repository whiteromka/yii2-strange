$(function() {
    $('body').on('click', '.js-ajax-bnt', function() {
        let loader = $(this).find('.d-none');
        $(loader).removeClass('d-none');

        setTimeout(()=>{
            $(this).attr('disabled', true);
        },20);
    });
});