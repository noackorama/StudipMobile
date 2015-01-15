<?php
namespace Studip\Mobile;

require "StudipMobileAuthenticatedController.php";
require dirname(__FILE__) . "/../models/activity.php";

/**
 *    ActivitiesController to give newest
 *    information to the view
 *    @author Marcus Lunzenauer - mlunzena@uos.de
 *    @author André Klaßen - aklassen@uos.de
 *    @author Nils Bussmann - nbussman@uos.de
 */
class ActivitiesController extends AuthenticatedController
{
    function index_action($cid_filter = null)
    {
        $this->days = \Request::int('days', 30);
        if ($this->days == -1) {
            $this->days = NAN;
        }

        $this->activities = Activity::findAllByUser($this->currentUser()->id, $cid_filter, $this->days);
        $this->nextInterval = Activity::getNextInterval($this->days);
    }
}
