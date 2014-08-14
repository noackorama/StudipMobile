var MailView = require('./mail_view'),
    bootstrap = require('./bootstraps');

var mail = bootstrap('model', {});
var page  = new MailView($("#mail-show"), { model: mail });
