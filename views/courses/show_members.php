<?
$this->setCoursePageHeader('courses-show_members', _("Teilnehmer in %s"), $course);

$status = '';
?>

<? if (isset($members)) : ?>

<ul id="courses" data-role="listview" data-filter="<?= sizeof($members) > 4 ? 'true' : '' ?>" data-filter-placeholder="Filtern" data-divider-theme="d" >
    <? foreach ($members AS $member) {
        if ($status != $member['status']) {
          $status=$member['status'];
    ?>
        <li data-role="list-divider">
          <?= ucfirst($this->out($member['status'])) ?>
        </li>
    <? } ?>

    <li>
      <a href=" <?= $controller->url_for("profiles/show", $member['user_id']) ?>" class="externallink" data-ajax="false">

        <?= Avatar::getAvatar($member['user_id'])->getImageTag(Avatar::MEDIUM, array('class' => 'ui-li-thumb')) ?>

        <h3>
          <?=$this->out($member["title_front"]) ?>
          <?=$this->out($member['Vorname']) ?>
          <?=$this->out($member['Nachname'])?>
        </h3>
      </a>
    </li>

    <? } ?>
</ul>

<? else : ?>
    <h3>Diese Veranstaltung hat sehr viele Teilnehmer!</h3>
    <p>Das Laden dieser Seite kann unter Umständen sehr lange dauern.</p>

    <a data-role="button" data-icon="alert" data-inline="true" data-iconpos="right"
       href="<?= $controller->url_for("courses/show_members", $course->id) ?>?deep">Trotzdem laden</a>

<? endif ?>
