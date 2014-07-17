<?
$this->set_layout('layouts/_page');
$page_id = 'quickdial-activities';
$page_title = sprintf(
  ngettext("Aktivitäten der letzten 24h" , "Aktivitäten der letzten %d Tage", $activities_days),
  $activities_days);

?>

<?= $this->render_partial('activities/_activities',
                          array('activities' => $activities)) ?>

<a class=quickdial-more-activities data-role="button" href="<?= $controller->url_for('activities') ?>">Mehr</a>
