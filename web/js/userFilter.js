$(document).on('pjax:success', function() {
    console.log(  getUrlVar()["UserFilter%5Bexist_passport%5D%5B%5D"]  );
});


$(function() {
    checkPassport();
});

$(document).on('change', 'input[name="UserFilter[exist_passport][]"]', function() {
    checkPassport();
});

function checkPassport() {
    let passport = [];
    $('.field-userfilter-exist_passport input:checkbox:checked').each(function(){
        passport.push($(this).val());
    });

    if ( passport.length == 1 && $.inArray('0', passport) !== -1 ) {
        disabledCountryAndCity();
    } else {
        disabledCountryAndCity(false)
    }
}

function disabledCountryAndCity(disabled = true) {
    $('#userfilter-passport_country').prop('disabled', disabled);
    $('#userfilter-passport_city').prop('disabled', disabled);
}



function getUrlVar(){
    var urlVar = window.location.search; // получаем параметры из урла
    var arrayVar = []; // массив для хранения переменных
    var valueAndKey = []; // массив для временного хранения значения и имени переменной
    var resultArray = []; // массив для хранения переменных
    arrayVar = (urlVar.substr(1)).split('&'); // разбираем урл на параметры
    if(arrayVar[0]=="") return false; // если нет переменных в урле
    for (i = 0; i < arrayVar.length; i ++) { // перебираем все переменные из урла
        valueAndKey = arrayVar[i].split('='); // пишем в массив имя переменной и ее значение
        resultArray[valueAndKey[0]] = valueAndKey[1]; // пишем в итоговый массив имя переменной и ее значение
    }
    return resultArray; // возвращаем результат
}


