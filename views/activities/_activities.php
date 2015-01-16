<?
use Studip\Mobile\Helper;
$show_filter = sizeof($activities) > 4;
?>

<? if ($show_filter) : ?>
<form class="ui-filterable">
    <input id="filter-input" data-type="search" placeholder="Filtern">
</form>
<? endif ?>

<ul id="activities"
    data-role="listview"
    <? if ($show_filter) : ?>
    data-filter="true" data-input="#filter-input"
    <? endif ?>
    >

  <?$last_date = null; ?>
  <? foreach ($activities as $activity) { ?>

    <? $atime = Helper::getLastMidnight($activity['updated']); ?>

    <? if ($last_date != $atime) : ?>
      <? $last_date = $atime; ?>
      <li data-role="list-divider"><?= Helper::beautifyDate($last_date)?></li>
    <? endif ?>

    <li class="activity" data-activity="<?= $activity['id'] ?>">
      <?= $this->render_partial('activities/_activity', compact('activity')) ?>
    </li>
  <? } ?>
</ul>

<? if (is_finite($days)) : ?>
  <a class="ui-btn more-activities"
     href="<?= $controller->url_for('activities', array('days' => is_finite($nextInterval) ? $nextInterval : -1)) ?>">
    Mehr
  </a>
<? endif ?>
