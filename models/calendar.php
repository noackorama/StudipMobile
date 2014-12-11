<?php

namespace Studip\Mobile;

$RELATIVE_PATH_CALENDAR = $GLOBALS['RELATIVE_PATH_CALENDAR'];
require_once(  $GLOBALS['RELATIVE_PATH_CALENDAR'] . "/lib/DbCalendarMonth.class.php" );


class CalendarModel {

    static function getDayDates($user, $current_semester)
    {
        return \CalendarScheduleModel::getEntries($user->id, $current_semester, 0800, 2000, range(0, 6), false);
    }

    static function getCalendar($user, $start, $end)
    {
        $user_id = $user->id;
        $_calendar = \Calendar::getInstance($user_id);
        $events = new \DbCalendarEventList($_calendar, $start, $end, false, \Calendar::getBindSeminare($user_id), array());

        $termine = array();
        while ($termin = $events->nextEvent()) {
            $termine[] = array(
                'id'          => $termin->id,
                'sem_id'      => $termin->properties['SEM_ID'] ?: null,

                'summary'     => $termin->getTitle(),
                'begin'       => date('c', $termin->getStart()),
                'end'         => date('c', $termin->getEnd()),

                'description' => $termin->getDescription(),
                'location'    => $termin->getLocation(),
                'category'    => $termin->toStringCategories(),
                'visibility'  => $termin->properties['CLASS'],
                'recurrence'  => $termin->properties['RRULE']['rtype'] == 'SINGLE' ? false : $termin->toStringRecurrence()
            );
        }

        return $termine;
    }
}
