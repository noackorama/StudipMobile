<div data-role="panel"
     id="mail-panel"
     data-display="reveal"
     data-theme="b"
     data-position=right>

  <div class=actions data-role="controlgroup">

    <? if (!$is_outbox) : ?>
      <div class=read-only>
        <button data-action=markasunread>Als ungelesen markieren</button>
      </div>

      <div class=unread-only>
        <button data-action=markasread>Als gelesen markieren</button>
      </div>

      <? if ($mail['author_id'] == '____%system%____') : ?>
        <button disabled>Antworten</button>
      <? else : ?>
        <a data-role=button
           href="<?= $controller->url_for("mails/compose") ?>?in_reply_to=<?= $mail['message_id'] ?>">
          Antworten
        </a>
      <? endif ?>

    <? endif?>

    <button data-action=delete>Löschen</button>
  </div>


  <div data-role="popup" id="popup-message-delete" data-overlay-theme="a" data-theme="c">
    <div data-role="header" data-theme="a" class="ui-corner-top">
      <h1>Nachricht löschen?</h1>
    </div>
    <div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
      <h3 class="ui-title">Möchten Sie diese Nachricht löschen?</h3>

      <div data-role="controlgroup" data-type="horizontal">
        <a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c" data-corners=false>Abbrechen</a>
        <a href="#" data-role="button" data-inline="true" data-theme="b" data-corners=false class=confirm>Löschen</a>
      </div>
    </div>
  </div>

</div>
