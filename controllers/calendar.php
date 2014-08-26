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
    function index_action($weekday = NULL)
    {
        // if no weekday -> make one
        if ($weekday == NULL) {
            $weekday = date("N");
        }
        //give weekday to the view
        $this->weekday = $weekday;
        //get events for current weekday
        $this->termine = CalendarModel::getDayDates($this->currentUser(), $weekday);
    }

    function kalender_action($year = NULL, $month = NULL)
    {
        //if no date -> make one
        if (empty($year) || empty($month)) {
            $month = date("n");
            $year  = date("Y");
        }

        $this->stamp = mktime(0, 0, 0, $month, 1, $year);
        $last_month    = $this->getEvents($year, $month - 1);
        $current_month = $this->getEvents($year, $month);
        $next_month    = $this->getEvents($year, $month + 1);

        $this->events = array_merge($last_month, $current_month, $next_month);
    }

    function events_action($year, $month)
    {
        $this->render_json($this->getEvents($year, $month));
    }

    private function getEvents($year, $month)
    {
        $timestamp = mktime(0, 0, 0, $month, 1, $year);
        return CalendarModel::getMonthEvents($this->currentUser(), $timestamp);
    }
}
