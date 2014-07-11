<? if ($mail['num_attachments'] == 0) { ?>

<? } else if ($mail['num_attachments'] <= 2) { ?>

  <li>
    <span>
      <? foreach ($mail['attachments'] as $attachment_id => $filename) { ?>
        <?= $this->render_partial('mails/_attachment_btn',
                                  compact('attachment_id', 'filename')) ?>
      <? } ?>
    </span>
  </li>

<? } else { ?>

  <li data-rel="inline">
    <a href="#inline-attachments">
      <?= sizeof($mail['attachments']) ?> <?= _("angehängte Dateien") ?>
    </a>
  </li>

    <li id=inline-attachments>
      <span>
      <? foreach ($mail['attachments'] as $attachment_id => $filename) { ?>
        <?= $this->render_partial('mails/_attachment_btn',
                                  compact('attachment_id', 'filename')) ?>
      <? } ?>
      </span>
    </li>

<? } ?>
