<?
$page_title = sprintf('Stundenplan im  %s', $this->out($current_semester['name']));
$this->setPageOptions('calendar-planer', $page_title);
$additional_footer = $this->render_partial('calendar/_navbar_footer', array('active' => 'index'));

$current_weekday = date('N') - 1;
?>

<div data-role="tabs" id="tabs" data-active="<?= ($current_weekday) ?>">

    <ul class="weekdays" data-role="listview" data-inset="false">
        <? foreach ($termine as $key => $dates): ?>
            <li class="<?= $key == $current_weekday ? 'ui-tabs-active' : '' ?>">
                <a href="#weekday-<?= $key ?>" data-ajax="false">
                    <?= substr($dates->getTitle(), 0, 2) ?>

                    <? if (array_key_exists('entries', $dates) && sizeof($dates->entries)) : ?>
                        <span>•</span>
                    <? endif ?>
                </a>
            </li>
        <? endforeach ?>
    </ul>


    <? foreach ($termine as $key => $dates): ?>
        <div id="weekday-<?= $key ?>" class="weekday-content ui-content" data-inset="false">

            <? if (array_key_exists('entries', $dates) && sizeof($dates->entries)) : ?>
                <?
                $entries = $dates->sortEntries();
                $sorted = array_reduce(
                    $entries,
                    function ($memo, $col) {
                        return array_merge($memo, $col);
                    },
                    array());

                 usort($sorted, function ($a, $b) {
                    return strcmp($a['start_formatted'], $b['start_formatted']);
                 });
                ?>
                <ul data-role=listview>

                    <? foreach ($sorted as $termin): ?>
                        <? $link = strlen($termin['id']) >=32
                                   ? $controller->url_for("courses/show",
                                                          substr($termin['id'],
                                                                 0, 32))
                                   : false  ?>
                        <li data-theme="d">
                            <? if ($link) : ?>
                                <a href="<?= $link ?>">
                            <? endif ?>

                            <div class="date">
                                <?= $this->out($termin['start_formatted']) ?> - <?= $this->out($termin['end_formatted']) ?>
                            </div>

                            <h2><?= $this->out($termin['title']) ?></h2>
                            <span class=content><?= $this->out($termin['content']) ?></span>

                            <? if ($link) : ?>
                                </a>
                            <? endif ?>

                    <? endforeach ?>
                </ul>
            <? else : ?>

                <!-- TODO -->
                <div class="calendar_bubble">Es sind keine Einträge vorhanden.</div>

            <? endif ?>

        </div>
    <? endforeach ?>

</div>
