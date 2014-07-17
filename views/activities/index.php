<?
use Studip\Mobile\Helper;

$this->set_layout("layouts/single_page");
$page_title = sprintf(
  ngettext("Aktivitäten der letzten 24h" , "Aktivitäten der letzten %d Tage", $days),
  $days);
$page_id = "activities-index";
?>

<?= $this->render_partial('activities/_activities') ?>
