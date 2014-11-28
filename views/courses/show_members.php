<?
$this->setCoursePageHeader('courses-show_members', _("Teilnehmer in %s"), $course);

$status = '';
$show_filter = sizeof($members) > 4;
?>

<? if (isset($members)) : ?>

    <? if ($show_filter) : ?>
        <form class="ui-filterable">
            <input id="filter-input" data-type="search" placeholder="Filtern">
        </form>
    <? endif ?>

    <ul id="courses" data-role="listview" data-divider-theme="d"
        <? if ($show_filter) : ?>
        data-filter="true" data-input="#filter-input"
        <? endif ?>
        >

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

    <a class="ui-btn ui-icon-alert ui-btn-icon-right" role=button href="<?= $controller->url_for("courses/show_members", $course->id) ?>?deep">Trotzdem laden</a>

<? endif ?>
