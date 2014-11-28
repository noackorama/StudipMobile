<div data-role="panel"
     id="mail-panel"
     data-display="reveal"
     data-theme="b"
     data-position=right>

  <div class=actions data-role="controlgroup">

    <? if (!$is_outbox) : ?>
      <div class="read-only">
          <input type="button" data-action=markasunread value="Als ungelesen markieren">
      </div>
      <div class="unread-only">
          <input type="button" data-action=markasread value="Als gelesen markieren">
      </div>

      <? if ($mail['author_id'] == '____%system%____') : ?>
        <button disabled>Antworten</button>
      <? else : ?>
        <a class="ui-btn" role=button
           href="<?= $controller->url_for("mails/compose") ?>?in_reply_to=<?= $mail['message_id'] ?>">
          Antworten
        </a>
      <? endif ?>

    <? endif?>

    <input type="button" data-action=delete value="Löschen">
  </div>


  <div data-role="popup" id="popup-message-delete" data-overlay-theme="a" data-theme="c">
    <div data-role="header" data-theme="a" class="ui-corner-top">
      <h1>Nachricht löschen?</h1>
    </div>
    <div data-theme="d" class="ui-corner-bottom ui-content">
      <h3 class="ui-title">Möchten Sie diese Nachricht löschen?</h3>

      <div data-role="controlgroup" data-type="horizontal">
        <a href="#" class="ui-btn ui-btn-c" role="button" data-inline="true" data-rel="back" data-corners=false>Abbrechen</a>
        <a href="#" class="ui-btn ui-btn-b confirm" role="button" data-inline="true" data-corners=false>Löschen</a>
      </div>
    </div>
  </div>

</div>
