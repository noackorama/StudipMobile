<? foreach ($dates as $key => $value) : ?>
  <div data-role="page" id="day<?= $key ?>" data-add-back-btn="true">

    <div data-role="header" data-theme="a">
      <a href="#calendar" data-icon="arrow-l" data-iconpos="notext" data-theme="c">
        <?=_("back")?>
      </a>

      <h1><?= $key ?>.<?= date("n", $stamp) ?>.<?= date("Y", $stamp) ?></h1>
    </div>

    <div class="ui-content content" role="main">
      <? if ($value != NULL) :?>
        <? foreach ($value as $key2 => $value2) { ?>
          <div class="calendar_time"><?= $value2["start"] ?> - <?= $value2["end"] ?>:</div>
          <div class="calendar_bubble">
            <b><?=Studip\Mobile\Helper::out($value2["title"]) ?></b>
            <br>
            <?= $value2["description"] ?
                Studip\Mobile\Helper::out($value2["description"])
                . "<br>" : "" ?>
            <?= $value2["location"] ? "Ort: "
                . Studip\Mobile\Helper::out($value2["location"]) : "" ?>
          </div>
        <? } ?>
      <? else : ?>
        <div class="calendar_bubble">
          <b>Keine Einträge</b>
        </div>
      <? endif ?>

    </div>
</div>
<? endforeach ?>
