<?php

require "StudipMobileAuthenticatedController.php";
require dirname(__FILE__) . "/../models/mail.php";

use Studip\Mobile\Mail;

/**
 *    get th inbox and outbox, write and send mails
 *    @author Nils Bussmann - nbussman@uos.de
 *    @author Marcus Lunzenauer - mlunzena@uos.de
 *    @author André Klaßen - aklassen@uos.de
 */
class MailsController extends StudipMobileAuthenticatedController
{
    /**
     * lists mails of inbox
     */
    function index_action($intervall = 0, $delId = null)
    {
        //  set intervall for the messages
        $this->intervall = $intervall;
        //  if a message should be deleted
        if ($delId != null) {
            Mail::deleteMessage( $delId, $this->currentUser()->id);
        }
        //  get all messages
        $this->inbox = Mail::findAllByUser($this->currentUser()->id, $intervall, true);
    }

    /**
     * lists mails of inbox
     */
    function list_inbox_action($intervall = 0, $delId = null)
    {
        //  set intervall for the messages
        $this->intervall = $intervall;

        //  if a message should be deleted
        if ($delId != null) {
            Mail::deleteMessage( $delId, $this->currentUser()->id);
        }
        //  get all messages
        $this->inbox = Mail::findAllByUser($this->currentUser()->id, $intervall, true);
    }

    /**
     * lists mails of outbox
     */
    function list_outbox_action($intervall = 0, $delId = null )
    {
        //  set intervall for the messages
        $this->intervall = $intervall;

        //  if a message should be deleted
        if ($delId != null) {
            Mail::deleteMessage($delId, $this->currentUser()->id);
        }
        //  get all messages
        $this->outbox = Mail::findAllByUser($this->currentUser()->id, $intervall, false);
    }

    /**
     * show a specific message
     */
    function show_msg_action($id, $mark = 0)
    {
        $this->mail = Mail::findMsgById($this->currentUser()->id, $id, $mark);
    }

    /**
     * preparation for sending a mail
     */
    function write_action($empf = null)
    {
        if ($empf == null) {

            // $this->members  = Mail::findAllInvolvedMembers( $this->currentUser()->id );

            $stmt = DBManager::get()->prepare('SELECT user_id FROM contact '.
            'WHERE owner_id = ?');

            $stmt->execute(array($this->currentUser()->id ));
            $contacts =  $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

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

            // pre 2.5 check
            if (method_exists($this->empfData, 'getData')) {
                $this->empfData = $this->empfData->getData();
            }
        }
    }

    /**
     * sends a mail
     */
    function send_action($empf)
    {
        $betreff     = Request::get("mail_title");
        $nachricht   = Request::get("mail_message");

        # TODO checken!
        $this->sendmessage = Mail::send( $empf, $betreff, $nachricht, $this->currentUser()->id );

        $this->flash["notice"] = _("Nachricht verschickt.");
        $this->redirect("mails");
    }
}
