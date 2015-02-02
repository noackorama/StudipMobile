<?
if (is_finite($days)) {
  $page_title = sprintf(
    ngettext("Aktivitäten der letzten 24h" , "Aktivitäten der letzten %d Tage", $days),
    $days);
} else {
  $page_title = _("Alle Aktivitäten");
}

$this->setPageOptions('activities-index', $page_title);
?>

<?= $this->render_partial('activities/_activities') ?>
