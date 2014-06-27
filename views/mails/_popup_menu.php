<a href="#popupMenu" data-rel="popup" data-role="button" data-inline="true">Eingang</a>

<div data-role="popup" id="popupMenu" data-theme="a">
  <ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="d">
    <li data-role="divider" data-theme="a">Eingang</li>
    <li><a href="<?= $controller->url_for("mails/list_outbox") ?>">Ausgang</a></li>
    <li><a href="<?= $controller->url_for("mails/write") ?>">Neue Nachricht</a></li>
  </ul>
</div>
