$( document ).ready(function() {
    showCurrentRates();
});

$('body').on('click', '.js-watcher-modal', function() {
    altcoinWatcherModal.call(this)
})

$('.js-delete-watcher').on('click', function() {
    deleteWatcher.call(this)
})

function altcoinWatcherModal() {
    let name = $(this).attr('data-altcoin-name');
    let id = $(this).attr('data-altcoin-id');
    let price = $(this).parents('tr').find('.js-price').text();
    $('#js-watcher-name-placeholder').html(name)
    $('#js-watcher-id-placeholder').val(id)
    $('#js-watcher-price-placeholder').val(price)
}

function showCurrentRates() {
    $.get('/crypto/get-rates').done(function(res) {
        if (res.success) {
            for (altcoin in res.data) {
                let price = res.data[altcoin]['USD'].toFixed(2);
                let html = `<span>${price}<span>`;
                let selector = '#' + altcoin;
                $(selector).html(html);
            }
        }
    })
}

function deleteWatcher() {
    let parent = $(this).parents('span.watcher');
    let id = parent.attr('data-watcher-id');
    $.get('/crypto/delete-watcher?id='+id).done(function(data) {
        if (data.success) {
            $(parent).remove()
        }
    })
}