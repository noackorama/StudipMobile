<?php

namespace Studip\Mobile;

class Helper {

    static function getLastMidnight($time = null)
    {

        return 86400 * intval(($time ?: time()) / 86400);
    }

    static function beautifyDate($time)
    {
        $today     = self::getLastMidnight($now = time());
        $yesterday = $today - 86400;

        if ($time > $now) {
            return _("zukünftig");
        }

        if ($time >= $today) {
            return _("heute");
        }

        if ($time >= $yesterday) {
            return _("gestern");
        }
        return _("am") . " " . date("d.m.Y", $time);
    }

    static function formatDate($date, $with_time = true)
    {
        return self::get_weekday(date("N", $date)) . date(" j. ", $date) . self::get_month(date("m", $date)) . ($with_time ? date(" Y H:i", $date) : '');
    }

    static function get_weekday($day)
    {
        switch ($day) {
        case 1:
            $ausgabe = "Montag";
            break;
        case 2:
            $ausgabe = "Dienstag";
            break;
        case 3:
            $ausgabe = "Mittwoch";
            break;
        case 4:
            $ausgabe = "Donnerstag";
            break;
        case 5:
            $ausgabe = "Freitag";
            break;
        case 6:
            $ausgabe = "Samstag";
            break;
        case 7:
            $ausgabe = "Sonntag";
            break;
        }
        return $ausgabe;
    }

    static function get_month($month)
    {
        switch ($month) {
        case 1:
            $ausgabe = "Januar";
            break;
        case 2:
            $ausgabe = "Februar";
            break;
        case 3:
            $ausgabe = "März";
            break;
        case 4:
            $ausgabe = "April";
            break;
        case 5:
            $ausgabe = "Mai";
            break;
        case 6:
            $ausgabe = "Juni";
            break;
        case 7:
            $ausgabe = "Juli";
            break;
        case 8:
            $ausgabe = "August";
            break;
        case 9:
            $ausgabe = "September";
            break;
        case 10:
            $ausgabe = "Oktober";
            break;
        case 11:
            $ausgabe = "November";
            break;
        case 12:
            $ausgabe = "Dezember";
            break;
        }
        return $ausgabe;
    }

    public static function out($text)
    {
        return mb_convert_encoding(htmlReady($text), 'UTF-8', 'WINDOWS-1252');
    }

    public static function fout($text)
    {
        return mb_convert_encoding(formatReady($text), 'UTF-8', 'WINDOWS-1252');
    }

    public static function correctText($text)
    {
        return Helper::url_to_link(studip_utf8encode($text));
    }

    public static function url_to_link($text)
    {
        return preg_replace("#(https?|ftp)://\S+[^\s.,>)\];'\"!?]#", '<a href="\\0">\\0</a>', $text);
    }

    //filters a string so thats ist vaild for filenames and pathes, slashes are not filterd
    static function cleanFilename($string, $lowercase = false)
    {
        // Remove special accented characters - ie. sí.
        $clean_name = strtr($string, 'ŠŽšžŸÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝàáâãäåçèéêëìíîïñòóôõöøùúûüýÿ',
                                     'SZszYAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy');
        $clean_name = strtr($clean_name, array('Þ' => 'TH', 'þ' => 'th', 'Ð' => 'DH', 'ð' => 'dh', 'ß' => 'ss', 'Œ' => 'OE', 'œ' => 'oe', 'Æ' => 'AE', 'æ' => 'ae', 'µ' => 'u'));

        $clean_name = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-\/]/'), array('_', '.', ''), $clean_name);
        if ($lowercase) {
            $clean_name = strtolower($clean_name);
        }
        return utf8_encode($clean_name);
    }

    static function endsWith($check, $endStr)
    {
        if (!is_string($check) || !is_string($endStr) || strlen($check)<strlen($endStr)) {
            return false;
        }

        return substr($check, strlen($check)-strlen($endStr), strlen($endStr)) === $endStr;
    }

    static function isExternalLink($link)
    {
        return preg_match('#^(/|\w+://)#', $link);
    }
}
