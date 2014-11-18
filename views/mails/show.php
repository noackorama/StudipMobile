<?
$this->setPageOptions('mail-show', $is_outbox ? 'Gesendete Nachricht' : 'Empfangene Nachricht');
$this->setPageData(array('message-read' => $mail['unread'] ? 0 : 1));
$this->addFooter('mails/_index_footer');
$additional_panel = $this->render_partial('mails/_mail_panel');

$system_mail = $mail['sender_id'] === '____%system%____';
?>

<div class="message-menu">
  <a data-role=button data-mini="true" data-iconpos=notext data-icon=gear href="#mail-panel">Menu</a>
</div>

<ul class="message-details" data-role="listview">

  <li>
    <div class="ui-grid-a ui-responsive">
      <div class="ui-block-a">
        <h3 class="message-title"><?= $this->out($mail['subject']) ?></h3>
      </div>
      <div class="ui-block-b message-date">
        <?= $this->formatDate($mail['mkdate']) ?>
      </div>
    </div>
  </li>

  <? if (!$is_outbox) echo $this->render_partial('mails/_message_sender') ?>

  <? if ($is_outbox) echo $this->render_partial('mails/_message_recipients') ?>
  <?= $this->render_partial('mails/_message_attachments') ?>
</ul>

<?= $this->render_partial('mails/_message_body') ?>

<? if (!$system_mail && !$is_outbox) echo $this->render_partial('mails/_message_fast_reply') ?>

<?
$uid = $controller->currentUser()->id;
$json = array(
  'message_id' => $mail['message_id'],
  'sender_id'  => $mail['sender_id'],
  'subject'    => $mail['subject'],
  'message'    => $mail['message'],
  'unread'     => $mail['unread'],
  'recipients' => $mail['sender_id'] === $uid ? $mail['receivers'] : array($uid => $mail['receivers'][$uid])
);
?>

<script>
STUDIP.Mobile.bootstraps.mail = <?= json_encode($controller->filter_utf8($json)) ?>;
</script>

<script src="<?= $plugin_path?>/public/javascripts/bundle/page_mails_show.js"></script>
