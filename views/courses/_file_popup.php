<div data-role="popup" id="<?= $popup_id ?>" class="ui-content" data-theme="e" style="max-width:350px;">
  <p>
    <?= _("Dateiname") ?>:
    <?= $this->out($file["filename"]) ?>
  </p>
  <p>
    <?= _("Dateigröße") ?>:
    <?= $filesize ?>
  </p>
  <p>
    <?= _("Von") ?>:
    <?= $this->out($file["author"]) ?>
  </p>
  <p>
    <?= _("Datum") ?>:
    <?= date("d.m.y H:i", $file["chdate"]) ?>
  </p>
  <? if (trim($file["description"]) !== '') : ?>
    <p>
      <?= _("Beschreibung") ?>:
      <?= $this->out($file["description"]) ?>
    </p>
  <? endif ?>
</div>
