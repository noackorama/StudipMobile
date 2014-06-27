<li data-role="list-divider">Als Nächstes</li>

<? foreach($next_courses as $date) { ?>

  <li>
    <a href="<?= $controller->url_for("courses/show", $date->getRangeId()) ?>" data-ajax="false">

      <h3>
        <? $sem = Seminar::getInstance($date->getRangeId()) ?>
        <?=Studip\Mobile\Helper::out($sem->name) ?>
      </h3>

      <p>
        <?= $date->toString() ?>
        <? if ($room = $date->getRoom()) : ?>
          in <?= Studip\Mobile\Helper::out($room) ?>
        <? endif ?>
      </p>

    </a>
  </li>

<? } ?>
