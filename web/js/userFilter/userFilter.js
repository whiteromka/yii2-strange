let isFilterNoPassport = false;

$(function() {
    checkPassport()
});

$(document).on('change', 'input[name="UserFilter[exist_passport][]"]', () => checkPassport());

$(document).on('pjax:success', () => checkPassport());

$(document).on('change', '#userfilter-passport_country, #userfilter-passport_city', () => {
   if (isFilterNoPassport) {
       $(this).val('');
   }
});

function checkPassport() {
    let passport = [];
    $('.field-userfilter-exist_passport input:checkbox:checked').each( () => {
        passport.push( $(this).val() );
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
