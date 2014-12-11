<?
$this->setCoursePageHeader('courses-show_news', _("Ankündigungen in %s"), $course);

$show_filter = sizeof($news) > 4;
?>

<? if (isset($news)) : ?>

    <? if ($show_filter) : ?>
        <form class="ui-filterable">
            <input id="filter-input" data-type="search" placeholder="Filtern">
        </form>
    <? endif ?>

    <ul id="news" data-role="listview" data-divider-theme="d"
        <? if ($show_filter) : ?>
        data-filter="true" data-input="#filter-input"
        <? endif ?>
        >
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
