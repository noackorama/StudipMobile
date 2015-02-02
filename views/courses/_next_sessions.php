<ul id="course-next-sessions" data-role="listview" data-inset="true">
  <? if (count($next_dates)) : ?>


    <li data-role="list-divider">
      Nächster Termin
    </li>

    <? foreach($next_dates as $next) { ?>
      <li data-theme="<?= ($is_ex = $next->isExTermin()) ? 'e' : ''?>">

        <?= $next->toString() ?>
        <? $location = current(array_filter($resources, function ($r) use ($next) { return $r["id"] == $next->resource_id; })) ?>

        <? if (isset($location['longitude']) && isset($location['lattude'])) { ?>
          <span class="ui-li-aside">
            <a href="<?= $controller->url_for("courses/show_map", $course->id) ?>" class="externallink" data-ajax="false">
                <?= $this->out($next->getRoom())?>
            </a>
          </span>
        <? } else { ?>
            <?= $this->out($next->getRoom())?>
        <? } ?>

        <? if ($is_ex) : ?>
          <i>Fällt aus! (Kommentar: <?= $this->out($next->getComment())?>)</i>
        <? endif ?>

      </li>
    <? } ?>

    <li data-role="collapsible" data-iconpos="right" data-inset="true">
        <h3>Alle Termine</h3>
        <p>
            <? $sem = Seminar::getInstance($course->id) ?>
            <?= nl2br($this->out($sem->getDatesExport())) ?>
        </p>
    </li>

  <? endif ?>
</ul>
