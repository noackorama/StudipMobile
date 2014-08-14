<div class=message-body data-theme=d>
  <? if ($messageBody = trim($this->fout($mail['message']))) { ?>
    <?= $messageBody ?>
  <? } else {  ?>
    <span class=empty>kein Inhalt</span>
  <? } ?>
</div>
