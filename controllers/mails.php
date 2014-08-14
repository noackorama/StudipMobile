<?php
namespace Studip\Mobile;

require "StudipMobileAuthenticatedController.php";
require dirname(__FILE__) . "/../models/mail.php";

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

        $mail = Mail::load($this->currentUser(), $id);
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
    function write_action()
    {
        return $this->render_json(array($_POST));

        if ($empf == null) {

            // $this->members  = Mail::findAllInvolvedMembers( $this->currentUser()->id );

            $stmt = \DBManager::get()->prepare('SELECT user_id FROM contact '.
            'WHERE owner_id = ?');

            $stmt->execute(array($this->currentUser()->id ));
            $contacts =  $stmt->fetchAll(\PDO::FETCH_COLUMN, 0);

            if(!empty($contacts)) {
                $query = "SELECT auth_user_md5.user_id, auth_user_md5.Vorname, auth_user_md5.Nachname, user_info.title_front
                              FROM   auth_user_md5
                              JOIN   user_info     ON auth_user_md5.user_id = user_info.user_id
                              WHERE auth_user_md5.user_id IN (:user_ids)
                              ORDER BY auth_user_md5.Nachname";
                $stmt = \DBManager::get()->prepare($query);
                $stmt->bindParam(':user_ids', $contacts, \StudipPDO::PARAM_ARRAY);
                $stmt->execute();

                $this->members = $stmt->fetchAll();
            } else {
                $this->members = false;
            }

        } else {
            $this->empfData = User::find($empf);
        }
    }

    /**
     * sends a mail
     */
    function send_action($empf)
    {
        $betreff     = \Request::get("mail_title");
        $nachricht   = \Request::get("mail_message");

        # TODO checken!
        $this->sendmessage = Mail::send( $empf, $betreff, $nachricht, $this->currentUser()->id );

        $this->flash["notice"] = _("Nachricht verschickt.");
        $this->redirect("mails");
    }
}
