helpers = require './helpers.coffee'

MailPanel = (@$el, @mail) ->
  self = this

  @$el.on 'click', '.actions button', (event) ->
    action = $(this).data('action')
    if typeof self[action] == 'function'
      self[action](event, $(this))

MailPanel::markasunread = (event, $button) ->

  $button.button('disable')
  $.mobile.loading('show')

  $.post helpers.url_for('mails/status/' + @mail.message_id), read: 0
   .then ->
       $.mobile.loading 'hide'
       helpers.getActivePage().attr 'data-message-read', 0
       $button.button 'enable'
     , ->
       $.mobile.loading('hide')
       helpers.openPopup('TODO: Fehler')

MailPanel::markasread = (event, $button) ->
  $button.button 'disable'
  $.mobile.loading 'show'

  $.post helpers.url_for('mails/status/' + @mail.message_id), read: 1
   .then ->
      $.mobile.loading 'hide'
      helpers.getActivePage().attr 'data-message-read', 1
      $button.button 'enable'
    , ->
      $.mobile.loading 'hide'
      helpers.openPopup 'TODO: Fehler'

confirmDeletion = (cb) ->
  success = false
  $confirmPopup = $ '#popup-message-delete'

  $confirmPopup
    .on 'click.confirmPopup', '.confirm', ->
      success = true
      $confirmPopup.popup('close')
    .on 'popupafterclose.confirmPopup', ->
      $confirmPopup.off('.confirmPopup')
      cb success
    .popup 'open'

MailPanel::delete = (event) ->
  confirmDeletion (status) =>
    @$el.panel 'close'
    if status
      $.mobile.loading 'show', text: 'Löschen', textVisible: true
      @mail.delete()
        .fin -> $.mobile.loading 'hide'

        .done ->
          do $.mobile.back

        , (error) ->
          console.log 'error', error
          helpers.openPopup 'TODO: Fehler'

module.exports = MailPanel
