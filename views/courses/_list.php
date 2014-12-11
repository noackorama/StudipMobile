<?php
$groups = array();
foreach ($courses as $course) {
  if (!isset($groups[$course['sem_number']])) {
    $groups[$course['sem_number']] = array();
  }
  $groups[$course['sem_number']][] = $course;
}

krsort($groups);

$show_filter = sizeof($courses) > 4;
?>

<? if ($show_filter) : ?>
<form class="ui-filterable">
    <input id="filter-input" data-type="search" placeholder="Filtern">
</form>
<? endif ?>

<ul id="courses" data-role="listview" data-divider-theme="b"
    <? if ($show_filter) : ?>
    data-filter="true" data-input="#filter-input"
    <? endif ?>
    >

  <? foreach ($groups as $sem_key => $group) { ?>
    <li data-role="list-divider">
      <?= $this->out($semester[$sem_key]['name']) ?>
    </li>
    <? foreach ($group as $course) { ?>
      <?= $this->render_partial("courses/_list_item", compact("course")) ?>
    <? } ?>
  <? } ?>
</ul>
