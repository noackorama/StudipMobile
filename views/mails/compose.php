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
    <div data-role="fieldcontain">
      <label for=rec-search>
        Empfänger: <span class=required>*</span>
      </label>

      <? if (sizeof($contacts)) : ?>
      <div id=show-contacts>
        <a href="#mail-show-contacts" data-role=button
           data-rel=popup
           data-transition=slideup
           data-shadow="false"
           data-icon=plus data-mini=true data-iconpos=notext>Ihre Kontakte</a>
      </div>
      <? endif ?>

      <ul class=selected data-role=listview data-inset=false data-icon=minus></ul>

      <input id=rec-search type=search data-clear-btn=true
             data-corners=false placeholder="Suchen">
    </div>
  </li>

  <li class=subject>
    <div data-role="fieldcontain">
      <label for=rec-subject> Betreff: <span class=required>*</span> </label>
      <input id=rec-subject name=subject type=text required
             value="<?= isset($mail['subject']) ? $this->out($mail['subject']) : '' ?>">
    </div>
  </li>


  <li class=message>
    <div data-role="fieldcontain">
      <label for=rec-message> Nachricht: </label>
      <textarea id=rec-message name=message></textarea>
    </div>
  </li>

  <li>
    <button id=send>Abschicken</button>
  </li>
</ul>

</form>
