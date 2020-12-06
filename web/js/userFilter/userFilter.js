let isFilterNoPassport = false;

$(function() {
    checkPassport();
});

$(document).on('change', 'input[name="UserFilter[exist_passport][]"]', function() {
    checkPassport();
});

$(document).on('change', '#userfilter-passport_country, #userfilter-passport_city', function() {
   if (isFilterNoPassport) {
       $(this).val('');
   }
});

$(document).on('pjax:success', function() {
    checkPassport();
});

function checkPassport() {
    let passport = [];
    $('.field-userfilter-exist_passport input:checkbox:checked').each(function(){
        passport.push($(this).val());
    });
    if ( passport.length == 1 && $.inArray('0', passport) !== -1 ) {
        isFilterNoPassport = true;
        cleanCountryAndCity();
    } else {
        isFilterNoPassport = false;
    }
}

function cleanCountryAndCity() {
    $('#userfilter-passport_country').val('');
    $('#userfilter-passport_city').val('');
}
