<?

use \Studip\Mobile\Helper;

$this->set_layout("layouts/single_page");

$page_title = "Nachrichtenausgang";
$page_id    = "mail-outbox";

$additional_header = $this->render_partial('mails/_popup_menu', array('type' => 'outbox'));
?>

<ul id="swipeMe" data-role="listview" data-filter="true" data-filter-placeholder="Suchen" data-divider-theme="d" >

  <? if (empty($outbox)) { ?>

    <li data-theme="e" data-role="list-divider" data-swipeurl=""><center>Keine Nachrichten vorhanden</center></li>

  <? } else { ?>


  <? foreach ($outbox as $mail) { ?>

    <? if (!$day || date("j.m.Y", $mail['mkdate']) != $dayCount) { ?>

      <?
      $wochentag = Helper::get_weekday(date("N", $mail['mkdate']));
      $monat     = Helper::get_month(date("m", $mail['mkdate']));
      $day       = $wochentag . date(", j. ",$mail['mkdate']) . $monat . date(" Y", $mail['mkdate']);
      $dayCount  = date("j.m.Y",$mail['mkdate']);
      ?>

      <li data-role="list-divider"><?= Helper::out($day) ?></li>

    <? } ?>

    <li data-swipeurl="<?= $controller->url_for("mails/list_outbox", $mail['id']) ?>">

      <a href="<?= $controller->url_for("mails/show_msg", $mail['id']) ?>" data-transition="slideup">

        <h3>
          <?= Helper::out($mail['title']) ?>
          <? if ($mail['num_attachments'] > 0) { ?>
            <?= Assets::img("icons/16/grey/staple", array('class' => 'mail-attachment')) ?>
          <? } ?>
        </h3>

        <p class=message-receivers>
          an
          <? if ($mail['num_rec'] > 1) : ?>
            <?= $mail['num_rec'] ?> <?= _("Empfänger") ?>
          <? else : ?>
            <?= $mail['rec_vorname'] ?> <?= $mail['rec_nachname'] ?>
          <? endif ?>
        </p>

      </a>
    </li>

  <? } ?>
  <? } ?>
</ul>

  </div><!-- Content -->
  </div><!-- /page -->
