<?

namespace Studip\Mobile;

class JQMHelper {

    function setPageOptions($template, $id, $title = null, $options = array())
    {
        $template->set_layout("layouts/single_page");
        $template->page_title = $title;
        $template->page_id    = $id;
        $template->set_attributes($options);
    }

    function setCoursePageHeader($template, $id, $format_string, $course, $options = array())
    {
        $course_type = studip_utf8encode($GLOBALS['SEM_TYPE'][$course->status]['name']);
        $page_title = sprintf($format_string, $course_type);
        self::setPageOptions($template, $id, $page_title, $options);
        self::addHeader($template, "layouts/_header_course", compact('course'));
    }

    function setPageData($template, $data)
    {
        $template->_dataAttributes = $data;
    }

    function addPage($template, $page, $options = array())
    {
        $template->additional_pages .= $template->render_partial($page, $options);
    }

    function addHeader($template, $page, $options = array())
    {
        $template->additional_header .= $template->render_partial($page, $options);
    }

    function addFooter($template, $page, $options = array())
    {
        $template->additional_footer .= $template->render_partial($page, $options);
    }

    function debug($template, $variable)
    {
?>
    <div data-role="collapsible" data-inset="false">
        <h3>Debug:</h3>
        <textarea>
            <?= $this->out(var_dump($variable)) ?>
        </textarea>
    </div>
<?
    }
}
