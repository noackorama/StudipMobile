<?php

namespace Studip\Mobile;


class News {

    static function find($user, $id)
    {
        $news = new \StudipNews($id);

        $has_perm = self::havePermission($news, 'view', '', $user->id);
        if (!$has_perm) {
            return false;
        }

        return $news;
    }

    static function findGlobal($user)
    {

    }

    static function findForCourse($user, $course)
    {
        $has_perm = self::haveRangePermission('view', $course->id, $user->id);
        if (!$has_perm) {
            return false;
        }

        $news = \StudipNews::getNewsByRange($course->id, true, true);

        return $news;
    }

    /**
     * checks, if user has permission to perform given operation on news object
     *
     * @param object $news            news
     * @param string $operation       delete, unassign, edit, copy, or view
     * @param string $check_range_id  specified range-id, used only for unassign-operation
     * @param string $user_id         optional; check permission for
     *                                given user ID; otherwise for the
     *                                global $user's ID
     * @return boolean true or false
     */
    public static function havePermission($news, $operation, $check_range_id = '', $user_id = null) {
        if (!$user_id)
            $user_id = $GLOBALS['auth']->auth['uid'];
        if (!in_array($operation, array('delete', 'unassign', 'edit', 'copy', 'view')))
            return false;
        // in order to unassign, there must be more than one range assigned; $check_range_id must be specified.
        if (($operation == 'unassign') AND (count($news->getRanges()) < 2))
            return false;
        // root, owner, and owner's deputy have full permission
        if ($GLOBALS['perm']->have_perm('root', $user_id)
              OR (($user_id == $news->user_id) AND $GLOBALS['perm']->have_perm('autor'))
              OR (isDeputyEditAboutActivated() AND isDeputy($user_id, $news->user_id, true)))
            return true;
        // check news' ranges for edit, copy or view permission
        if (($operation == 'unassign') OR ($operation == 'delete'))
            $range_operation = 'edit';
        else
            $range_operation = $operation;
        foreach ($news->getRanges() as $range_id) {
            if (self::haveRangePermission($range_operation, $range_id, $user_id)) {
                // in order to view, edit, copy, or unassign, access to one of the ranges is sufficient
                if (($operation == 'view') OR ($operation == 'edit') OR ($operation == 'copy')) {
                    return true;
                // in order to unassign, access to the specified range is needed
                } elseif (($operation == 'unassign') AND ($range_id == $check_range_id)) {
                    return true;
                }
                // in order to delete, access to all ranges is necessary
                $permission_ranges++;
            } elseif ($operation == 'delete')
                return false;
        }
        if (($operation == 'delete') AND (count($news->getRanges()) == $permission_ranges))
            return true;
        return false;
    }

    public static function haveRangePermission($operation, $range_id, $user_id = '') {
        static $news_range_perm_cache;
        if (isset($news_range_perm_cache[$user_id.$range_id.$operation]))
            return $news_range_perm_cache[$user_id.$range_id.$operation];
        if (!$user_id)
            $user_id = $GLOBALS['auth']->auth['uid'];
        if ($GLOBALS['perm']->have_perm('root', $user_id))
            return $news_range_perm_cache[$user_id.$range_id.$operation] = true;
        $type = get_object_type($range_id, array('global', 'sem', 'inst', 'fak', 'user'));
        switch($type) {
            case 'global':
                if ($operation == 'view')
                    return $news_range_perm_cache[$user_id.$range_id.$operation] = true;
                break;
            case 'fak':
            case 'inst':
            case 'sem':
                if (($operation == 'view') AND $GLOBALS['perm']->have_studip_perm('user', $range_id))
                    return $news_range_perm_cache[$user_id.$range_id.$operation] = true;
                if (($operation == 'edit') OR ($operation == 'copy')) {
                    if ($GLOBALS['perm']->have_studip_perm('tutor', $range_id))
                        return $news_range_perm_cache[$user_id.$range_id.$operation] = true;
                }
                break;
            case 'user':
                if ($operation == 'view') {
                    if (($range_id = $user_id) OR get_visibility_by_id($range_id))
                        return $news_range_perm_cache[$user_id.$range_id.$operation] = true;
                }
                elseif (($operation == 'edit') OR ($operation == 'copy')) {
                    if ($GLOBALS['perm']->have_profile_perm('user', $range_id))
                        return $news_range_perm_cache[$user_id.$range_id.$operation] = true;
                }
                break;
        }
        return $news_range_perm_cache[$user_id.$range_id.$operation] = false;
    }
}
