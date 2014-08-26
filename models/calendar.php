<?php

namespace Studip\Mobile;

$RELATIVE_PATH_CALENDAR = $GLOBALS['RELATIVE_PATH_CALENDAR'];
require_once(  $GLOBALS['RELATIVE_PATH_CALENDAR'] . "/lib/DbCalendarMonth.class.php" );


class CalendarModel {

    static function getMonthEvents($user, $timestamp)
    {
        $_calendar = \Calendar::getInstance($user->id);

        $cal = new \DbCalendarMonth($_calendar, $timestamp, null, \Calendar::getBindSeminare($user->id) );

        $start_stamp = $cal->getStart();
        $end_stamp   = $cal->getEnd();
        $dates       =  array();

        for ($act_stamp = $start_stamp; $act_stamp < $end_stamp; $act_stamp += 86400) {
            $event = $cal->getEventsOfDay($act_stamp);

            if (!isset($event)) {
                continue;
            }

            foreach ($event as $key => $value) {
                if ($value != NULL && is_object($value)) {
                    if (is_a($value, 'CalendarEvent') || is_a($value, 'SeminarEvent')) {
                        if ($value->getPermission() >= 2) {
                            $dates[] = array(
                                "summary"      =>  $value->getTitle(),
                                "begin"        =>  date("c", $value->getStart()),
                                "end"          =>  date("c", $value->getEnd()),

                                "description"  =>  $value->getDescription(),
                                "location"     =>  $value->getLocation());
                        }
                    }
                }
            }
        }

        return $dates;
    }

    static function getDayDates($user, $weekday)
    {
        //get current semester
        $semdata = new \SemesterData();
        $current_semester = $semdata->getCurrentSemesterData();
        $current_semester_id = $current_semester['semester_id'];

        return \CalendarScheduleModel::getEntries($user->id, $current_semester, 0800, 2000, array($weekday-1), false);
    }
}
