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
        if (!$this->news = News::find($this->currentUser(), $id)) {
            $this->notFound("News not found");
        }

        $this->ranges = $this->filterRanges($this->news);
    }

    private function filterRanges($news)
    {
        $user_id = $this->currentUser()->id;
        return $news->news_ranges->filter(function ($range) use ($user_id) {
                return News::haveRangePermission('view', $range->range_id, $user_id);
            });
    }
}
