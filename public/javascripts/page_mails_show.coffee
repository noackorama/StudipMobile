MailView  = require './mail_view.coffee'
bootstrap = require './bootstraps.coffee'

$(document).on "pagebeforeshow", ->
  mail = bootstrap 'mail', {}
  page = new MailView $("#mail-show"), model: mail
