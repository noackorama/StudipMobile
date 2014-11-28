<li class="course" data-course="<?= $course['Seminar_id'] ?>">
  <a href="<?= $controller->url_for("courses/show", $course['Seminar_id']) ?>">
    <img class="ui-li-icon ui-corner-none" src="<?= $plugin_path ?>/public/images/quickdial/seminar.png">
    <h3>
        <?= $this->out($course['Name']) ?>

        <? if ($course['sem_nr']) : ?>
            <small class="sem_nr">(<?= $course['sem_nr'] ?>)</small>
        <? endif ?>
    </h3>
    <? if ($course['Untertitel']) : ?>
        <p class="untertitel"><?= $course['Untertitel'] ?></p>
    <? endif ?>
  </a>
</li>
