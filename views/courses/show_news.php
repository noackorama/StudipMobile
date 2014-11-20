<?
$this->setCoursePageHeader('courses-show_news', _("Ankündigungen in %s"), $course);
?>

<? if (isset($news)) : ?>

<ul id="news" data-role="listview" data-filter="<?= sizeof($news) > 4 ? 'true' : '' ?>" data-filter-placeholder="Filtern" data-divider-theme="d" >
    <? foreach ($news as $news_item) { ?>
        <li>
            <a href="<?= $controller->url_for("news/show", $news_item->id) ?>">
                <?= Avatar::getAvatar($news_item->author)->getImageTag(Avatar::MEDIUM, array('class' => 'ui-li-thumb')) ?>
                <h3>
                    <?=$this->out($news_item->topic) ?>
                </h3>
            </a>
    </li>

    <? } ?>
</ul>

<? else : ?>
    <h3>Keine Ankündigungen</h3>
    <p>Für diese Veranstaltung gibt es derzeit keine Ankündigungen.</p>
<? endif ?>
