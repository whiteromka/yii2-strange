$( document ).ready(function() {
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
});