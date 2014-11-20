<?
$page_title = $GLOBALS['SEM_TYPE'][$course->status]['name'] . ': ' . $course->name;
$this->setPageOptions('courses-show', $page_title);

// check if there are Geolocations
$resources_locations = array_filter($resources, function ($resource) {
        return is_numeric($resource['latitude']) && is_numeric($resource['longitude']);
});
?>

<h2><?= Studip\Mobile\Helper::out($course->name) ?></h2>
<? if ($course->subtitle) { ?>
    <h4><?= Studip\Mobile\Helper::out($course->subtitle) ?></h4>
<? } ?>


<?= $this->render_partial('courses/_next_sessions') ?>

<? if ($course->metadate) { ?>


  <? if ($course->description) : ?>
    <div id="course-description" data-role="collapsible" data-theme="c" data-content-theme="d" data-inset="true">
      <h3>Beschreibung</h3>

      <?= \Studip\Mobile\Helper::correctText($course->description) ?>
    </div>
  <? endif ?>

  <? if (strlen($misc = trim($this->render_partial('courses/_show_misc')))) : ?>
      <div id="course-details" data-role="collapsible" data-theme="c" data-content-theme="d" data-inset="true">
          <h3>Details</h3>
          <?= $misc ?>
      </div>
  <? endif ?>

<? } ?>

<br>

<fieldset class="ui-grid-a">

  <div class="ui-block-a">
    <a href="<?= $controller->url_for("courses/show_activities", $course->id) ?>" data-role="button">Aktivitäten</a>
  </div>

  <div class="ui-block-b">
    <a href="<?= $controller->url_for("courses/show_news", $course->id) ?>" data-role="button">News</a>
  </div>

  <div class="ui-block-a">
    <a href="<?= $controller->url_for("courses/list_files", $course->id) ?>" data-role="button">Dateien</a>
  </div>

  <div class="ui-block-b">
    <a href="<?= $controller->url_for("courses/show_members", $course->id) ?>"  class="externallink" data-ajax="false" data-role="button">Teilnehmer</a>
  </div>
</fieldset>
