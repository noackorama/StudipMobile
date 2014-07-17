<? use Studip\Mobile\Helper; ?>

<ul id="activities" data-role="listview" data-filter="true" data-filter-placeholder="Suchen">

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
