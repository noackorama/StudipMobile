<?
$this->set_layout('layouts/_page');
$page_id = 'quickdial-activities';
$page_title = $title;
?>

<?= $this->render_partial('activities/_activities',
                          array('activities' => $activities)) ?>

<? if (is_finite($days)) : ?>
  <a class="ui-btn quickdial-more-activities"
     href="<?= $controller->url_for('activities', array('days' => is_finite($nextInterval) ? $nextInterval : -1)) ?>">
    Mehr
  </a>
<? endif ?>
