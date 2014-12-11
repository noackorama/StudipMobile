<?
$this->setCoursePageHeader('courses-list-files', _("Alle Dateien in %s"), $course);

$popups = "";
$show_filter = sizeof($files) > 4;
?>

<? if (!sizeof($files)) { ?>

  <ul data-role="listview" data-inset="true" data-theme="e">
    <li>Zu dieser Veranstaltung sind leider keine Dateien vorhanden.</li>
  </ul>

<? } else { ?>

<? if (StudipMobile::DROPBOX_ENABLED) : ?>
  <a href="<?= $controller->url_for("courses/dropfiles", $course->id) ?>"
     class="ui-btn ui-btn-b externallink" data-ajax="false" role="button">
    Alle Dateien in meine Dropbox
  </a><br>
  <? endif ?>


  <? if ($show_filter) : ?>
      <form class="ui-filterable">
          <input id="filter-input" data-type="search" placeholder="Filtern">
      </form>
  <? endif ?>

  <ul id="files" data-role="listview" data-split-icon="info" data-split-theme="d"
      <? if ($show_filter) : ?>
      data-filter="true" data-input="#filter-input"
      <? endif ?>
      >

    <? foreach($files as $file) { ?>

      <?
      $popup_id = "popup-file-" . $file['id'];
      $filesize = round($file["filesize"] / 1024) . ' kB';
      $new_content = object_get_visit($course->id, "documents", false) < $file['chdate'];
      ?>

      <li>
        <a href="<?= $file["link"] ?>" class="externallink" data-ajax="false">
          <img src="<?=$plugin_path ?><?=$file["icon_link"] ?>" class="ui-li-icon">
            <h2 class="<?= $new_content ? 'new-content' : '' ?>">
              <?= Studip\Mobile\Helper::out($file["name"]) ?>
              <span class=file-size><?= $filesize ?></span>
            </h2>
            <? if (trim($file["description"]) !== '') : ?>
              <p><?= Studip\Mobile\Helper::out($file["description"]) ?></p>
            <? endif ?>
        </a>

        <a href="#<?= $popup_id ?>" class="file-details-switch" data-rel="popup">Info</a>

        <? $popups .= $this->render_partial('courses/_file_popup',
                                           compact("popup_id", "file", "filesize")) ?>

      </li>
    <? } ?>
  </ul>

  <?= $popups ?>

<? } ?>
