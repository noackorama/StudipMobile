<?php
namespace Studip\Mobile;

require "StudipMobileAuthenticatedController.php";

/**
 *    @author mlunzena@uos.de
 */
class UsersController extends AuthenticatedController
{
    function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);

        require_once 'lib/classes/searchtypes/StandardSearch.class.php';
    }

    function search_action()
    {
        $query = \Request::get('query');
        $search = new \StandardSearch('user_id');
        $results = $search->getResults($query, array(), 20, 0);
        $results = array_map(function (&$item) use ($search) {
            return array(
                'id'   => $item[0],
                'name' => $item[1],
                'img'  => \Avatar::getAvatar($item[0])->getURL(\Avatar::SMALL)
            );
        }, $results);

        $this->render_json($results);
    }
}
