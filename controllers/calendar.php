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
        $this->termine = CalendarModel::getDayDates($this->currentUser()->id, $weekday);
    }

    function kalender_action($year = NULL, $month = NULL)
    {
        //if no date -> make one
        if (empty($year) || empty($month)) {
            $month = date("n");
            $year  = date("Y");
        }
        //make a timestamp for the date
        $this->stamp = mktime(0,0,0,$month,1, $year);
        //get dates of the month
        $this->dates = CalendarModel::getMonthDates( $this->currentUser,$this->stamp );
    }
}
