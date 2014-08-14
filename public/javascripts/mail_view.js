var MailPanel = require('./mail_panel');
var helpers   = require('./helpers');

var MailsView = function (el, options)  {
    var self = this;

    this.el = el;
    this.model = options.model;


    this.panel = new MailPanel($("#mail-panel"), this.model);

    $(el).on("submit", "form", function (event) {
        var $form = $(this),
            $textarea = $form.find('textarea'),
            url   = $form.attr("action"),
            reply = $textarea.val().trim();

        if (!reply.length) {
            return false;
        }

        // now send the reply home
        $.post(url, { reply: reply })
            .then(
                function () {
                    helpers.openPopup("Antwort verschickt");
                    $textarea.val("");
                },

                function () {
                    helpers.openPopup("Antwort konnte nicht verschickt werden");
                });


        return false;

    });
};

module.exports = MailsView;
