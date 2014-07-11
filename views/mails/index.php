<?

use \Studip\Mobile\Helper;

$this->set_layout("layouts/single_page");

$page_title = "Posteingang (" . intval(sizeof($inbox)) . ")";
$page_id    = "mails-index";

$additional_header = $this->render_partial('mails/_popup_menu', array('type' => 'inbox'));
?>

<? /* TODO */ $this->render_partial('mails/_flash_notice') ?>

<ul id="swipeMe" data-role="listview" data-filter="true" data-filter-placeholder="Suchen" data-divider-theme="d">

  <? if (empty($inbox)) { ?>

    <li data-theme="e" data-role="list-divider" data-swipeurl=""><center>Keine Nachrichten vorhanden</center></li>

  <? } else { ?>


  <? foreach ($inbox as $mail) { ?>

    <? if (date("j.m.Y", $mail['mkdate']) != $dayCount) { ?>
      <? $dayCount = date("j.m.Y", $mail['mkdate']); ?>

      <li data-role="list-divider"><?= Helper::formatDate($mail['mkdate'], false) ?></li>

    <? } ?>

    <li data-swipeurl="<?= $controller->url_for("mails/index", $intervall, $mail['id']) ?>" data-theme="<?= $mail['readed'] ? 'c' : 'e' ?>">

      <a href="<?= $controller->url_for("mails/show_msg", $mail['id']) ?>" data-transition="slideup">

        <h3>
          <?= Helper::out($mail['title']) ?>
          <? if ($mail['num_attachments'] > 0) { ?>
            <?= Assets::img("icons/16/grey/staple", array('class' => 'mail-attachment')) ?>
          <? } ?>
        </h3>

        <p class=message-author>
          von <?= $mail['author_id'] != '____%system%____' ? Helper::out($mail['author']) : 'Stud.IP-System' ?>
        </p>

      </a>
    </li>
  <? } ?>

  <? } ?>
</ul>
