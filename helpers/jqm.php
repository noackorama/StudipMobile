<?

namespace Studip\Mobile;

class JQMHelper {

    function setPageOptions($template, $title, $id, $options = array())
    {
        $template->set_layout("layouts/single_page");
        $template->page_title = $title;
        $template->page_id    = $id;
        $template->set_attributes($options);
    }

    function setPageData($template, $data)
    {
        $template->_dataAttributes = $data;
    }

    function addPage($template, $page, $options = array())
    {
        $template->additional_pages .= $template->render_partial($page, $options);
    }

    function addFooter($template, $page, $options = array())
    {
        $template->additional_footer .= $template->render_partial($page, $options);
    }
}
