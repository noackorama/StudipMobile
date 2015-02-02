<?
use Studip\Mobile\Helper;

$page_id = 'news-show';
$single_course = false;

// is this news attached to a single course only?
if (sizeof($ranges) === 1 &&
    $ranges->first()->getType() === 'sem') {

    $single_course = true;
    $course = Course::find($ranges->first()->range_id);
    $this->setCoursePageHeader($page_id, _("Ankündigung in %s"), $course);
}

else {
    $this->setPageOptions($page_id, 'Ankündigung');
}
?>

<ul class="news" data-role="listview">
  <li>
    <h3><?= $this->out($news->topic) ?></h3>
  </li>

  <li>
      <p class="news-author">
          <strong>Von:</strong> <?= $this->out($news->author) ?>
      </p>
      <span class="news-chdate">
          am <?= $this->out(date("j.m.y H:i", $news->chdate)) ?>
      </span>
  </li>


  <? if (!$single_course): ?>
      <li class="ui-mini" data-role="collapsible" data-iconpos="right" data-inset="false">
          <h6>in <?= sizeof($ranges) ?> Bereichen</h6>
          <div>
              <?= $this->render_partial('news/_ranges') ?>
          </div>
      </li>
  </li>
  <? endif ?>

</ul>
<p class="news-body">
  <?= $this->fout($news->body) ?>
</p>
