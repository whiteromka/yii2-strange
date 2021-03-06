$(function() {

    $('.js-sidebar-collapse').on('click', function() {
        changeSidebarMode();
    })

});

/** Change sidebar mode (narrow/wide) */
function changeSidebarMode() {
    let url = '/lte/change-sidebar-mode';
    $.get(url).done(function(data) {});
}