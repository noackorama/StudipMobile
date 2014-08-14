<div data-role="footer" data-id="footer" data-position="fixed" data-theme="c">
  <div data-role="navbar" data-iconspos="top">
    <ul class="ui-grid-a">
      <li class="ui-block-a"><a id="marikieren" href="<?= $controller->url_for("mails/show_msg",$mail[0]['id'], true) ?>" data-theme="c" data-icon="star" data-transition="flip">Markieren</a></li>
      <? if ($mail[0]['author_id'] == '____%system%____') : ?>
        <li class="ui-block-b"><a id="antworten"  data-theme="c" data-icon="check" data-transition="slideup" class='ui-disabled'>Antworten</a></li>
      <? else: ?>
        <li class="ui-block-b"><a id="antworten" href="<?= $controller->url_for("mails/write",$mail[0]['author_id']) ?>" data-theme="c" data-icon="check" data-transition="slideup">Antworten</a></li>
      <? endif;?>
    </ul>
  </div>
</div>
