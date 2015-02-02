<?
$this->setPageOptions('mail-compose', 'Nachricht schreiben');
echo $this->render_partial('mails/_add_contact');

$this->addFooter('mails/_index_footer', array('selected' => 'compose'));
?>

<script>
STUDIP.Mobile.bootstraps.mail     = <?= $mail     ? json_encode($mail) : 'null' ?>;
STUDIP.Mobile.bootstraps.contacts = <?= $contacts ? json_encode($contacts) : 'null' ?>;
</script>

<script src="<?= $plugin_path?>/public/javascripts/bundle/page_mails_compose.js"></script>

<form action="<?= $controller->url_for("mails/send") ?>" method="POST">

<ul id="composer" data-role="listview" data-theme=d>

  <li class=recipients>

      <? if (sizeof($contacts)) : ?>
          <div id=show-contacts>
              <a href="#mail-show-contacts"
                 class="ui-btn ui-icon-plus ui-mini ui-btn-icon-notext ui-corner-all"
                 role=button
                 data-rel=popup
                 data-transition=slideup
                 data-shadow="false">Ihre Kontakte</a>
          </div>
      <? endif ?>

    <div class="ui-field-contain">
      <label for=rec-list>
        Empfänger: <span class=required>*</span>
      </label>

      <ul id=rec-list class=selected data-role=listview data-inset=false data-icon=minus></ul>
    </div>

    <input id=rec-search type=search data-clear-btn=true
           placeholder="Empfängersuche">
  </li>

  <li class=subject>
    <div class="ui-field-contain">
      <label for=rec-subject> Betreff: <span class=required>*</span> </label>
      <input id=rec-subject name=subject type=text required
             value="<?= isset($mail['subject']) ? $this->out($mail['subject']) : '' ?>">
    </div>
  </li>


  <li class=message>
    <div class="ui-field-contain">
      <label for=rec-message> Nachricht: </label>
      <textarea id=rec-message name=message></textarea>
    </div>
  </li>

  <li>
    <input type=submit id=send value=Abschicken>
  </li>
</ul>

</form>
