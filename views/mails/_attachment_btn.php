<a href="<?= GetDownloadLink($attachment_id, $filename, 0,'force_download') ?>"
   class=externallink
   data-ajax=false
   data-role=button
   data-mini=true
   data-inline=true
   data-icon=arrow-r
   data-iconpos=left>

  <?= \Studip\Mobile\Helper::out($filename) ?>
</a>
