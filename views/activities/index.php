<?
use Studip\Mobile\Helper;

$this->set_layout("layouts/single_page");
$page_id = "activities-index";


if ($days > 0) {
  $page_title = sprintf(
    ngettext("Aktivitäten der letzten 24h" , "Aktivitäten der letzten %d Tage", $days),
    $days);
} else {
  $page_title = _("Alle Aktivitäten");
}

?>

<?= $this->render_partial('activities/_activities') ?>
