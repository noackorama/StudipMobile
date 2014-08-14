<?
use Studip\Mobile\Helper;

$this->set_layout("layouts/single_page");

$page_title = "Nachricht";
$page_id = "mail-show";

$additional_header = $this->render_partial('mails/_message_header');
$additional_footer = $this->render_partial('mails/_message_footer');
?>

<? if ($mail) { ?>
  <ul data-role="inlinelistview">

    <li>
      <h3 style="white-space:normal;"><?= Helper::out($mail['title']) ?></h3>
      <p><strong><?= Helper::formatDate($mail['mkdate']) ?></strong></p>
      <p class=message-author>

        <strong>Von:</strong>
        <?= $mail['author_id'] != '____%system%____' ? Helper::out($mail['author']) : _('Stud.IP-System') ?>

      </p>
    </li>

    <?= $this->render_partial('mails/_message_attachments') ?>

  </ul>

  <p class=message-body>
    <? if ($messageBody = trim(Helper::fout($mail['message'],TRUE, TRUE))) { ?>
      <?= $messageBody ?>
    <? } else {  ?>
      <span class=empty>kein Inhalt</span>
    <? } ?>
  </p>


<? } else { ?>
  <p><?= _("Beim Laden der Nachricht ist ein Fehler aufgetreten.") ?></p>
<? } ?>
