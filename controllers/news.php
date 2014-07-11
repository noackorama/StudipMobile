<?php
namespace Studip\Mobile;

require "StudipMobileAuthenticatedController.php";
require dirname(__FILE__) . "/../models/news.php";

/**
 *    @author mlunzena@uos.de
 */
class NewsController extends AuthenticatedController
{
    function show_action($id)
    {
        $this->news = News::find($id);
    }
}
