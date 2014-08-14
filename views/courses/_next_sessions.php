<ul data-role="inlinelistview" data-inset="true">
  <? if (count($next_dates)) : ?>


    <li data-role="list-divider" data-theme="c">
      Nächster Termin
    </li>

    <? foreach($next_dates as $next) { ?>
      <li data-theme="<?= ($is_ex = $next->isExTermin()) ? 'e' : ''?>">

        <?= $next->toString() ?>
        <?= Studip\Mobile\Helper::out($next->getRoom())?>
        <? $location = current(array_filter($resources, function ($r) use ($next) { return $r["id"] == $next->resource_id; })) ?>

        <? if ($location) { ?>
          <span class="ui-li-aside">
            <a href="<?= $controller->url_for("courses/show_map", $course->id) ?>" class="externallink" data-ajax="false">
              <?= $location["description"] ?>
            </a>
          </span>
        <? } ?>

        <? if ($is_ex) : ?>
          <i>Fällt aus! (Kommentar: <?= Studip\Mobile\Helper::out($next->getComment())?>)</i>
        <? endif ?>

      </li>
    <? } ?>

    <li data-rel="inline">
      <a href="#inline-dates">Alle Termine</a>
    </li>

    <li id="inline-dates">
      <div>
        <? $sem = Seminar::getInstance($course->id) ?>
        <?= nl2br(Studip\Mobile\Helper::out($sem->getDatesExport())) ?>
      </div>

    </li>

  <? endif ?>
</ul>
