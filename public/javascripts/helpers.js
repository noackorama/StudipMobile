var url_for = function (to) {
    return [global.STUDIP.ABSOLUTE_URI_STUDIP, 'plugins.php/studipmobile', to].join('/');
};

var popupCounter = 0;
$(document).on('popupafterclose', '.onetimepopup', function() { $(this).remove(); });

var openPopup = function (message) {
    var activePage = $.mobile.activePage,
        id = 'popup-' + popupCounter++,
        popup = ['<div class=onetimepopup data-role=popup id=', id, '><p>', message, '</p></div>'].join('');

    activePage.append(popup).trigger('pagecreate');

    return $("#" + id).popup('open');
};

module.exports = {
    url_for: url_for,
    openPopup: openPopup
};
