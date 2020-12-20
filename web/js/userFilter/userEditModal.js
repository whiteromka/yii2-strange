/** Click on btn edit user - open modal edit */
$(document).on('click', '.js-btn-edit', function(e) {
    e.preventDefault();
    let userId = $(this).attr('data-user-id');
    requestData(userId);
    $("#js-modal-user-edit").modal('show');
    loaderInModalWindow();
});

function requestData(userId) {
    let url = '/ajax/get-data?userId='+userId
    fetch(url)
        .then(response => response.json())
        .then(data => {
            pasteInModalWindow(data)
        });
}

function pasteInModalWindow(data) {
    $('.js-paste-content').html();
    $('.js-paste-content').html(data);
}

function loaderInModalWindow() {
    let loader = `<div><h1>Загружаем...</h1></div>`;
    pasteInModalWindow(loader);
}

/** Modal click on submit form */
$(document).on('click', '.js-btn-send-user-data', function(e) {
    e.preventDefault();
    let data = $('#user-edit').serializeArray();
    let url = '/ajax/edit-data'
    $.post(url, data).done(data => {
        if (data.success) {
            $('.js-btn-close-modal').click();
        } else {
            let htmlMessage =`<div class="alert alert-danger">${data.error}</div>`;
            $('.js-paste-message').html(htmlMessage)
        }
    });
});

/** Modal click on add passport */
$(document).on('click', '.js-btn-add-passport', function(e) {
    e.preventDefault();
    $('.js-block-have-no-passport').addClass('d-none');
    $('.js-block-new-passport').removeClass('d-none');
    $('input[name="Passport[action]"]').val('create');
});

/** Modal click on remove passport */
$(document).on('click', '.js-btn-remove-passport', function(e) {
    e.preventDefault();
    let data = {'passportId': $(this).attr('data-passport-id')}
    let url = '/ajax/remove-passport'
    $.get(url, data).done(data => {
        if (data.success) {
            $('.js-btn-close-modal').click();
        } else {
            let htmlMessage =`<div class="alert alert-danger">${data.error}</div>`;
            $('.js-paste-message').html(htmlMessage)
        }
    });
});
