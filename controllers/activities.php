<?php

require "StudipMobileAuthenticatedController.php";
require dirname(__FILE__) . "/../models/activity.php";

use Studip\Mobile\Activity;

/**
 *    ActivitiesController to give newest
 *    information to the view
 *    @author Marcus Lunzenauer - mlunzena@uos.de
 *    @author André Klaßen - aklassen@uos.de
 *    @author Nils Bussmann - nbussman@uos.de
 */
class ActivitiesController extends StudipMobileAuthenticatedController
{
    function index_action($seminar_filter = null)
    {
        $this->activities = Activity::findAllByUser(
            $this->currentUser()->id,
            $seminar_filter,
            \Request::int('days', 30));
    }

}
