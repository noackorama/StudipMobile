var helpers = require('./helpers');

var MailPanel = function (el, model)  {

    var self = this;

    this.el = el;
    this.model = model;

    $(el).on("click", ".actions button", function (event) {
        var action = $(this).data("action");
        if (typeof self[action] === "function") {
            self[action](event, $(this));
        }
    });
};

MailPanel.prototype.markasunread = function (event, $button) {

    $button.button('disable');
    $.mobile.loading("show");

    $
        .post(helpers.url_for("mails/status/" + this.model.message_id), {
            read: 0
        })

        .then(
            function () {
                $.mobile.loading('hide');
                $.mobile.activePage.attr("data-message-read", 0);
                $button.button('enable');
            },


            function () {
                $.mobile.loading('hide');
                helpers.openPopup("TODO: Fehler");
            }
        );
};

MailPanel.prototype.markasread = function (event, $button) {
    $button.button('disable');
    $.mobile.loading("show");

    $
        .post(helpers.url_for("mails/status/" + this.model.message_id), {
            read: 1
        })

        .then(
            function () {
                $.mobile.loading('hide');
                $.mobile.activePage.attr("data-message-read", 1);
                $button.button('enable');
            },


            function () {
                $.mobile.loading('hide');
                helpers.openPopup("TODO: Fehler");
            }
        );
};

MailPanel.prototype.delete = function (event) {

    var $confirmPopup = $("#popup-message-delete");
    $confirmPopup
        .on("popupafteropen.confirmPopup", function (event, ui) {

            console.log("popup open");

            $confirmPopup.on("click.confirmPopup", ".confirm", function () {
                console.log("confirmed");
                $confirmPopup.popup("close");
                return false;
            });
        } )
        .on("popupafterclose.confirmPopup", function () {
            console.log("popup close");
            $confirmPopup.off(".confirmPopup");
        });

    $confirmPopup.popup("open");
};

MailPanel.prototype.reply = function (event) {
    console.log("reply", arguments);
};

module.exports = MailPanel;
