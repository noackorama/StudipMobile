<div data-role="navbar" data-iconpos=right>
  <ul>
    <li>
      <a href="<?= $controller->url_for("courses/show", $course->id) ?>"
         class="ui-btn-active"
         data-icon=back>
        <?= Studip\Mobile\Helper::out($course->name) ?>
      </a>
    </li>
  </ul>
</div>
