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

<ul data-role="listview">
  <li data-role="fieldcontain">
    <h3><?= $this->out($news->topic) ?></h3>
  </li>

  <li data-role="fieldcontain">
    <p style="padding-top:12px;">
      <strong>Von:</strong> <?= $this->out($news->author) ?>
    </p>
    <span class="ui-li-count"><?= $this->out(date("j.m.y h:i", $news->chdate)) ?></span>
  </li>

  <? if (!$single_course): ?>
      <li class=collapsible-listitem>
          <div data-role="collapsible" data-inset=false data-mini="true">
              <h6>in <?= sizeof($ranges) ?> Bereichen</h6>
              <div>
                  <?= $this->render_partial('news/_ranges') ?>
              </div>
          </div>
      </li>
  </li>
  <? endif ?>

</ul>
<p style="font-family: Helvetica,Arial,sans-serif;font-size: 12px;font-weight: normal;white-space:wrap;">
  <br />
  <?= $this->fout($news->body) ?>
</p>
