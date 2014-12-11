<a href="<?= GetDownloadLink($attachment_id, $filename, 0,'force_download') ?>"
   class="externallink ui-btn ui-icon-arrow-r ui-btn-icon-left ui-mini"
   data-ajax=false
   <? if ($as_button) : ?>
   role=button
   data-inline=true
   <? endif ?>>
  <?= \Studip\Mobile\Helper::out($filename) ?>
</a>
