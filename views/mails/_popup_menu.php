<a href="#popupMenu" data-rel="popup" data-role="button" data-inline="true">
  <?= $type === 'inbox' ? 'Eingang' : 'Ausgang' ?>
</a>

<div data-role="popup" id="popupMenu" data-theme="a">
  <ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="d">

    <? if ($type === 'inbox') : ?>
      <li data-role="divider" data-theme="a">Eingang</li>
    <? else : ?>
      <li><a href="<?= $controller->url_for("mails/index") ?>">Eingang</a></li>
    <? endif ?>

    <? if ($type === 'outbox') : ?>
      <li data-role="divider" data-theme="a">Ausgang</li>
    <? else : ?>
      <li><a href="<?= $controller->url_for("mails/list_outbox") ?>">Ausgang</a></li>
    <? endif ?>

    <li><a href="<?= $controller->url_for("mails/write") ?>">Neue Nachricht</a></li>
  </ul>
</div>
