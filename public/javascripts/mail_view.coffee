MailPanel = require './mail_panel.coffee'
helpers   = require './helpers.coffee'

MailView = (el, options) ->
  self = @
  @el = el
  @model = options.model


  @panel = new MailPanel $("#mail-panel"), @model

  $(el).on "submit", "form", (event) ->
    $form = $(this)
    $textarea = $form.find 'textarea'
    url = $form.attr "action"
    reply = $textarea.val().trim();

    if reply.length

      # now send the reply home
      $.post url, reply: reply
       .then ->
           helpers.openPopup "Antwort verschickt"
           $textarea.val ""
        ,->
           helpers.openPopup("Antwort konnte nicht verschickt werden");

    false

module.exports = MailView
