helpers = require './helpers.coffee'
Q = require '../vendor/q/q.js'

class MailModel

  constructor: (data = {}) ->
    @message_id = data.message_id ? null
    @recipients = data.recipients ? {}
    @subject    = data.subject ? ''
    @message    = data.message ? ''

  send: ->
    errors = @validate()
    return Q.fcall(-> throw errors)  if _.values(errors).length

    Q $.post helpers.url_for('mails/send'),
      recipients: _.pluck @recipients, 'id'
      subject:    @subject
      message:    @message

  delete: ->
    Q $.ajax
      type: 'DELETE'
      url: helpers.url_for "mails/delete/#{@message_id}"

  validate: ->
    _.tap {}, (errors) =>
      if @subject.trim() is ''
        errors.subject = 'Betreff erforderlich'
      unless _.values(@recipients).length > 0
        errors.recipients = 'Empfänger erforderlich'

module.exports = MailModel
