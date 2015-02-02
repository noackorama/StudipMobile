<li class="course" data-course="<?= $course['Seminar_id'] ?>">
  <a href="<?= $controller->url_for("courses/show", $course['Seminar_id']) ?>">
    <img class="ui-li-icon" src="<?= $plugin_path ?>/public/images/quickdial/seminar.png">
    <h3>
        <?= $this->out($course['Name']) ?>

        <? if ($course['sem_nr']) : ?>
            <small class="sem_nr">(<?= $this->out($course['sem_nr']) ?>)</small>
        <? endif ?>
    </h3>
    <? if ($course['Untertitel']) : ?>
        <p class="untertitel"><?= $this->out($course['Untertitel']) ?></p>
    <? endif ?>
  </a>
</li>
