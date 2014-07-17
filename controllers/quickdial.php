<?php
namespace Studip\Mobile;

require "StudipMobileAuthenticatedController.php";
require dirname(__FILE__) . "/../models/quickdail.php";
require dirname(__FILE__) . "/../models/activity.php";

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

        list($this->days, $this->activities) = $this->getSmartActivities();

        $this->nextInterval = $this->getNextInterval($this->days);
    }


    const SMART_ACTIVITIES_THRESHOLD = 3;

    private function getSmartActivities($days = 1)
    {
        $activities = Activity::findAllByUser($this->currentUser()->id, null, $days);

        if (is_finite($days) && sizeof($activities) < self::SMART_ACTIVITIES_THRESHOLD) {
            return $this->getSmartActivities($this->getNextInterval($days));
        }

        return array($days, $activities);
    }


    private static $intervals = array(1, 7, 30, 365);

    private function getNextInterval($days)
    {
        $next = NAN;
        foreach (self::$intervals as $interval) {
            if ($interval > $days) {
                $next = $interval;
                break;
            }
        }

        return $next;
    }
}
