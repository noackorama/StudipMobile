<?php
namespace Studip\Mobile;

require "StudipMobileAuthenticatedController.php";
require dirname(__FILE__) . "/../models/quickdail.php";

/**
 *    The Start Screen of studipmobile
 *    @author Nils Bussmann - nbussman@uos.de
 *    @author Marcus Lunzenauer - mlunzena@uos.de
 *    @author André Klaßen - aklassen@uos.de
 */
class QuickdialController extends AuthenticatedController
{
    function index_action()
    {
        // get next 5 courses of the day
        $this->next_courses = Quickdail::get_next_courses($this->currentUser()->id);
        $this->user_id = $this->currentUser()->id;


        // get numbers of new mails
        $this->number_unread_mails = Quickdail::get_number_unread_mails($this->currentUser()->id);
    }
}
