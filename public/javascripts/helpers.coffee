url_for = (to) ->
    [global.STUDIP.ABSOLUTE_URI_STUDIP, 'plugins.php/studipmobile', to].join('/')

popupCounter = 0

$(document).on 'popupafterclose', '.onetimepopup', -> $(this).remove()

openPopup = (message) ->
  activePage = $.mobile.activePage
  id = 'popup-' + popupCounter++
  popup = ['<div class=onetimepopup data-role=popup id=', id, '><p>', message, '</p></div>'].join ''

  activePage.append(popup).trigger('pagecreate')
  $("#" + id).popup('open')

module.exports =
    url_for:   url_for,
    openPopup: openPopup
