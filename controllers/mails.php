<?php
namespace Studip\Mobile;

require "StudipMobileAuthenticatedController.php";
require dirname(__FILE__) . "/../models/mail.php";
require dirname(__FILE__) . "/../models/contact.php";

/**
 *    get th inbox and outbox, write and send mails
 *    @author Nils Bussmann - nbussman@uos.de
 *    @author Marcus Lunzenauer - mlunzena@uos.de
 *    @author André Klaßen - aklassen@uos.de
 */
class MailsController extends AuthenticatedController
{

    function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);

        if (sizeof($args) === 1 && ($action === 'inbox' || $action === 'outbox')) {
            $this->is_outbox = $action === 'outbox';
            $action = 'show';
        }
    }

    /**
     * lists mails of inbox
     */
    function inbox_action()
    {
        //  get all messages
        $ids = Mail::inbox($this->currentUser());
        $this->messages = Mail::load($this->currentUser(), $ids);
    }

    /**
     * lists mails of outbox
     */
    function outbox_action()
    {
        //  get all messages
        $ids = Mail::outbox($this->currentUser());
        $this->messages = Mail::load($this->currentUser(), $ids);
    }

    /**
     * show a specific received message
     */
    function show_action($id)
    {
        $this->mail = Mail::load($this->currentUser(), $id);
        if (!$this->mail) {
            $this->error(404);
        }

        Mail::markMail($this->currentUser(), $this->mail, true);
    }

    function reply_action($id)
    {
        $mail = Mail::load($this->currentUser(), $id);
        if (!$mail) {
            $this->error(404);
        }

        $body = \Request::get("reply");
        $reply = Mail::replyTo($this->currentUser(), $mail, $body);

        if ($reply) {
            $this->render_json(array('status' => 'ok'));
        } else {
            // TODO: figure out real status code
            $this->error(500);
        }
    }

    function status_action($id)
    {
        $mail = Mail::load($this->currentUser(), $id);
        if (!$mail) {
            $this->error(404);
        }

        $read = \Request::int('read');
        if ($read === null) {
            $this->error(400);
        }

        Mail::markMail($this->currentUser(), $mail, $read);

        $this->render_json(array('status' => 'ok'));
    }


    function delete_action($msg_id)
    {
        if (\Request::method() !== 'DELETE' || !\Request::isXhr()) {
            $this->error(400);
        }

        $mail = Mail::load($this->currentUser(), $msg_id);
        if (!$mail) {
            $this->error(404);
        }

        $status = Mail::delete($this->currentUser(), $mail);
        if ($status) {
            $this->render_json(array('status' => 'ok'));
        } else {
            $this->error(500, 'Could not delete mail.');
        }
    }

    /**
     * preparation for sending a mail
     */
    function compose_action()
    {
        $this->mail = array();

        if ($msg_id = \Request::option('in_reply_to', false)) {
            $msg = Mail::load($this->currentUser(), $msg_id);
            if (!$msg) {
                $this->error(404);
            }

            $this->mail['recipients'] = array($this->getUser($msg['sender_id']));
            $this->mail['subject']    = Mail::getReplySubject($msg);
            $this->mail['message']    = Mail::getQuotedMessage($msg);
        }

        else if ($user_id = \Request::option('to', false)) {
            if ($user = \User::find($user_id)) {
                $this->mail['recipients'] = array($this->getUser($user_id));
            }
        }


        $this->contacts = array_map(
            function ($contact) {
                return array(
                    'id'   => $contact['id'],
                    'name' => $contact['name'],
                    'img'  => $contact['avatar']
                );
            }, Contact::findAllByUser($this->currentUser()));
    }

    /**
     * sends a mail
     */
    function send_action()
    {
        $recipients  = \Request::optionArray('recipients');
        $betreff     = studip_utf8decode(\Request::get('subject', ''));
        $nachricht   = studip_utf8decode(\Request::get('message', ''));

        if (!sizeof($recipients)) {
            $this->error(400, 'Recipients required');
        }

        if (!strlen($betreff)) {
            $this->error(400, 'Subject required');
        }

        $empf = array_filter(array_map('get_username', $recipients));
        if (!sizeof($empf)) {
            $this->error(400, 'Recipient/s required');
        }

        $sendmessage = Mail::send($empf, $betreff, $nachricht, $this->currentUser()->id);
        if ($sendmessage) {
            return $this->render_json(array('status' => 'ok'));
        }

        $this->error(400);
    }

    private function getUser($id)
    {
        return array(
            'id'   => $id,
            'name' => get_fullname($id, 'no_title'),
            'img'  => \Avatar::getAvatar($id)->getUrl(\Avatar::SMALL)
        );
    }
}
