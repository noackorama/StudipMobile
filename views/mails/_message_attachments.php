<? $num = sizeof($mail['attachments']); ?>

<? if ($num == 0) { ?>

<? } else if ($num <= 2) { ?>


  <li class="message-few-attachments">
    <span>
      <? foreach ($mail['attachments'] as $attachment) { ?>
        <?= $this->render_partial('mails/_attachment_btn', array(
              'attachment_id' => $attachment['dokument_id'],
              'filename' => $attachment['name'],
              'as_button' => true)) ?>
      <? } ?>
    </span>
  </li>

<? } else { ?>

  <li class=collapsible-listitem>
    <div class="message-many-attachments" data-role="collapsible" data-theme="c" data-content-theme="d">
      <h4>
        <? printf(ngettext("1 angehängte Datei", "%d angehängte Dateien", $num), $num) ?>
      </h4>

      <ul data-role="listview" data-inset="false">
        <? foreach ($mail['attachments'] as $attachment) { ?>
          <li>
            <?= $this->render_partial('mails/_attachment_btn',
                                      array(
                  'attachment_id' => $attachment['dokument_id'],
                  'filename' => $attachment['name'])) ?>
          </li>
        <? } ?>
      </ul>
    </div>

  </li>
<? } ?>
