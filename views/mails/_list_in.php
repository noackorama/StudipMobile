<?
$page_title = "Nachrichten";
$page_id    = "mails-index";
$body_class = "mails";

$additional_header = $this->render_partial('mails/_popup_menu');
?>

<?= $this->render_partial('mails/_flash_notice') ?>

<ul id="swipeMe" data-role="listview" data-filter="true" -data-filter-placeholder="Suchen" data-inset="false" data-divider-theme="d">

  <? if (empty($inbox)) { ?>
    <li data-theme="e" data-role="list-divider" data-swipeurl=""><center>Keine Nachrichten vorhanden</center></li>
  <? } else { ?>


  <? foreach ($inbox as $mail) { ?>

    <? if (!$day || date("j.m.Y", $mail['mkdate']) != $dayCount) { ?>

      <?
      $wochentag = \Studip\Mobile\Helper::get_weekday(date("N", $mail['mkdate']));
      $monat     = \Studip\Mobile\Helper::get_month(date("m", $mail['mkdate']));
      $day       =  $wochentag.date(", j. ",$mail['mkdate']).$monat.date(", Y",$mail['mkdate']);
      $dayCount  = date("j.m.Y", $mail['mkdate']);
      ?>

      <li data-role="list-divider"><?= $wochentag.date(", j. ",$mail['mkdate']).$monat.date(", Y",$mail['mkdate']) ?></li>
    <? } ?>

    <? $time = date("H:i",$mail['mkdate']); ?>

    <li
      data-swipeurl="<?= $controller->url_for("mails/index", $intervall ,$mail['id']) ?>"
      data-theme="<?= $mail['readed'] ? 'c' : 'b' ?>" >

      <a href="<?= $controller->url_for("mails/show_msg", $mail['id']) ?>" data-transition="slideup">

        <h3>
          <?= Studip\Mobile\Helper::out($mail['title']) ?>
        </h3>

        <p class=message-author>
          von <?= $mail['author_id'] != '____%system%____' ? Studip\Mobile\Helper::out($mail['author']) : 'Stud.IP-System' ?>
        </p>

        <!--
        <span class=message-time>
        <?= Studip\Mobile\Helper::out($time) ?>
        </span>
        -->

        <p>
          <?= mila(Studip\Mobile\Helper::out($mail['message'])) ?>
        </p>
      </a>
    </li>

    <? } ?>
    <? } ?>
</ul>
