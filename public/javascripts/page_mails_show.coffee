MailView  = require './mail_view.coffee'
MailModel = require './mail_model.coffee'
bootstrap = require './bootstraps.coffee'

$(document).on "pagecontainerbeforeshow", _.once \
  ->
    mail = new MailModel bootstrap 'mail', {}
    page = new MailView $("#mail-show"), mail: mail
