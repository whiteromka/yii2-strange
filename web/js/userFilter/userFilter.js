let isFilterNoPassport = false;

$(function() {
    checkPassport()
});

$(document).on('change', 'input[name="UserFilter[exist_passport][]"]', () => checkPassport());

$(document).on('pjax:success', () => checkPassport());

$(document).on('change', '#userfilter-passport_country, #userfilter-passport_city', (e) => {
   if (isFilterNoPassport) {
       $(e.target).val('');
       alert('Если у пользователя нет пасспорта, не имеет смысла искать его по городу или стране');
   }
});

function checkPassport() {
    let existPassport = $('input[name="UserFilter[exist_passport][]"]'); // two checkboxes (exist_passport)
    let noPassport = $(existPassport[0]).is(':checked');
    let withPassport = $(existPassport[1]).is(':checked');
    if (noPassport) {
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
