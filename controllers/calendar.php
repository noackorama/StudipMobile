<?php
namespace Studip\Mobile;

require "StudipMobileAuthenticatedController.php";
require dirname(__FILE__) . "/../models/calendar.php";

/**
 * Get cycle events and dates for schedule and calendar
 * @author Nils Bussmann - nbussman@uos.de
 */
class CalendarController extends AuthenticatedController
{
    function index_action()
    {
        $semdata = new \SemesterData();
        $this->current_semester = $semdata->getCurrentSemesterData();
        $this->termine = CalendarModel::getDayDates($this->currentUser(), $this->current_semester);
    }

    function kalender_action($year = NULL, $month = NULL)
    {
        //if no date -> make one
        if (empty($year) || empty($month)) {
            $month = date("n");
            $year  = date("Y");
            $this->stamp = time();
        } else {
            $this->stamp = mktime(0, 0, 0, $month, 1, $year);
        }

        $last_month    = $this->getEvents($year, $month - 1);
        $current_month = $this->getEvents($year, $month);
        $next_month    = $this->getEvents($year, $month + 1);

        $this->events = array_merge($last_month, $current_month, $next_month);
    }

    function events_action($year, $month)
    {
        $this->render_json(@$this->getEvents($year, $month));
    }

    private function getEvents($year, $month)
    {
        $start = mktime(0, 0, 0, $month,     1, $year);
        $end   = mktime(0, 0, 0, $month + 1, 1, $year);

        return CalendarModel::getCalendar($this->currentUser(), $start, $end);
    }
}
