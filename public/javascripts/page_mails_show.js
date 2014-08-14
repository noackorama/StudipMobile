var MailView = require('./mail_view'),
    bootstrap = require('./bootstraps');

$(document).on("pagebeforeshow", function () {
    var mail = bootstrap('mail', {});
    var page  = new MailView($("#mail-show"), { model: mail });
});
