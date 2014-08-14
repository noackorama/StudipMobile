<?

namespace Studip\Mobile;

class FormatHelper {

    function out($template, $text)
    {
        return mb_convert_encoding(htmlReady($text), 'UTF-8', 'WINDOWS-1252');
    }

    function fout($template, $text)
    {
        return mb_convert_encoding(formatReady($text), 'UTF-8', 'WINDOWS-1252');
    }

    function formatDate($template, $date, $with_time = true)
    {
        return Helper::get_weekday(date("N", $date)) . date(" j. ", $date) . Helper::get_month(date("m", $date)) . ($with_time ? date(" Y H:i", $date) : '');
    }
}
