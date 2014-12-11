<? $icon_path = $plugin_path . '/public/images/icons/32/white/'; ?>

<div id="leftpanel" data-role="panel" data-position=left data-display=reveal data-theme=a>

    <h3>Menü</h3>

    <ul data-role="listview" data-theme=a class="nav-search" data-inset="false" id="menu_side">

     <li class="active" data-icon="false">
       <a href="<?= $controller->url_for("quickdial") ?>" class="externallink contentLink" data-ajax="false">
         <img src="<?= $icon_path ?>home.png" class="ui-li-icon ui-corner-none">
<?=_("Start")?>
       </a>
     </li>

      <li data-icon="false">
        <a href="<?= $controller->url_for("courses") ?>" class="externallink contentLink" data-ajax="false">
          <img src="<?= $icon_path ?>seminar.png"   class="ui-li-icon ui-corner-none" />
          <?=_("Veranstaltungen")?>
        </a>
      </li>

      <li data-icon="false">
        <a href="<?= $controller->url_for("calendar") ?>" class="externallink contentLink" data-ajax="false">
          <img src="<?= $icon_path ?>schedule.png" class="ui-li-icon ui-corner-none">
          <?=_("Planer")?>
        </a>
      </li>

      <li data-icon="false">
        <a href="<?= $controller->url_for("mails/inbox") ?>" class="externallink contentLink" data-ajax="false">
          <img src="<?= $icon_path ?>mail.png"   class="ui-li-icon ui-corner-none" />
          <?=_("Nachrichten")?>
        </a>
      </li>

      <li data-icon="false">
        <a href="<?= $controller->url_for("profiles/show") ?>" class="externallink contentLink" data-ajax="false">
          <img src="<?= $icon_path ?>person.png"   class="ui-li-icon ui-corner-none" />
          <?=_("Ich")?>
        </a>
      </li>

      <li data-icon="false">
        <a href="mailto:kursmanager@uos.de?subject=Stud.IP+Mobile+Feedback+<?= urlencode($GLOBALS['UNI_NAME_CLEAN']) ?>" class="externallink contentLink" data-ajax="false">
          <img src="<?= $icon_path ?>info-circle.png"   class="ui-li-icon ui-corner-none" />
          <?=_("Feedback")?>
        </a>
      </li>

      <li data-icon="false">
        <a href="<?= $controller->url_for("session/destroy") ?>" class="externallink contentLink" data-ajax="false">
          <img src="<?= $icon_path ?>door-leave2.png"   class="ui-li-icon ui-corner-none" />
          <?=_("Logout")?>
        </a>
      </li>

      <li data-icon="false">
        <a href="<?= URLHelper::getUrl("index.php") ?>" class="externallink contentLink" data-ajax="false">
          <img src="<?= $icon_path ?>link-intern.png"   class="ui-li-icon ui-corner-none" />
          <?=_("Desktop-Ansicht")?>
        </a>
      </li>

    </ul>

</div><!-- /panel -->
