helpers = require './helpers.coffee'

MailPanel = (el, model) ->
  self = this
  @el = el
  @model = model

  $(el).on 'click', '.actions button', (event) ->
    action = $(this).data('action')
    if typeof self[action] == 'function'
      self[action](event, $(this))

MailPanel.prototype.markasunread = (event, $button) ->

  $button.button('disable')
  $.mobile.loading('show')

  $.post helpers.url_for('mails/status/' + @model.message_id), read: 0
   .then ->
       $.mobile.loading 'hide'
       $.mobile.activePage.attr 'data-message-read', 0
       $button.button 'enable'
     , ->
       $.mobile.loading('hide')
       helpers.openPopup('TODO: Fehler')

MailPanel.prototype.markasread = (event, $button) ->
  $button.button 'disable'
  $.mobile.loading 'show'

  $.post helpers.url_for('mails/status/' + @model.message_id), read: 1
   .then ->
      $.mobile.loading 'hide'
      $.mobile.activePage.attr 'data-message-read', 1
      $button.button 'enable'
    , ->
      $.mobile.loading 'hide'
      helpers.openPopup 'TODO: Fehler'

MailPanel.prototype.delete = (event) ->

  $confirmPopup = $ '#popup-message-delete'

  $confirmPopup
    .on 'popupafteropen.confirmPopup', (event, ui) ->
      console.log 'popup open'

      $confirmPopup.on 'click.confirmPopup', '.confirm', ->
        console.log 'confirmed'
        $confirmPopup.popup 'close'
        false
      .on 'popupafterclose.confirmPopup', ->
        console.log 'popup close'
        $confirmPopup.off '.confirmPopup'

    $confirmPopup.popup 'open'

MailPanel.prototype.reply = (event) ->
    console.log 'reply', arguments

module.exports = MailPanel
