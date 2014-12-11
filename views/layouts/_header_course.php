<div data-role="navbar" data-iconpos=right>
  <ul>
    <li>
      <a href="<?= $controller->url_for("courses/show", $course->id) ?>"
         class="ui-btn-active"
         data-icon=back>
        <?= $this->out($course->name) ?>
      </a>
    </li>
  </ul>
</div>
