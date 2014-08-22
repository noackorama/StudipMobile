MailComposeView = require './mail_compose_view.coffee'
MailModel = require './mail_model.coffee'
bootstrap = require './bootstraps.coffee'

$(document).on "pagebeforeshow", _.once \
  ->
    mail = new MailModel bootstrap 'mail', {}
    contacts = bootstrap 'contacts'
    page = new MailComposeView $("#mail-compose"), mail: mail, contacts: contacts
