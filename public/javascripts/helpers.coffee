url_for = (to) ->
    [global.STUDIP.ABSOLUTE_URI_STUDIP, 'plugins.php/studipmobile', to].join('/')


getActivePage = () ->
  $('body').pagecontainer 'getActivePage'


popupCounter = 0

$(document).on 'popupafterclose', '.onetimepopup', -> $(this).remove()

openPopup = (message) ->
  id = 'popup-' + popupCounter++
  popup = ['<div class=onetimepopup data-role=popup id=', id, '><p>', message, '</p></div>'].join ''

  getActivePage().append(popup)
  $("#" + id).popup().popup('open')

module.exports =
    url_for:   url_for
    getActivePage: getActivePage
    openPopup: openPopup
