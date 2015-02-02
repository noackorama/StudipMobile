<li data-role="list-divider" data-theme="b">Als Nächstes</li>

<? foreach($next_courses as $date) { ?>

  <li>
    <a href="<?= $controller->url_for("courses/show", $date->getRangeId()) ?>" data-ajax="false">

      <h3>
        <? $sem = Seminar::getInstance($date->getRangeId()) ?>
        <?= $this->out($sem->name) ?>
      </h3>

      <p>
        <?= $date->toString() ?>
        <? if ($room = $date->getRoom()) : ?>
          in <?= $this->out($room) ?>
        <? endif ?>
      </p>

    </a>
  </li>

<? } ?>
