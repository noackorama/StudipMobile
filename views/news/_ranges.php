<?
$readable_types = array(
    'global' => _('Stud.IP'),
    'sem'    => _('Veranstaltung'),
    'inst'   => _('Institut'),
    'fak'    => _('Fakultät'),
    'user'   => _('bei Nutzer'));
?>

<ul id="news_ranges" data-role="listview">
<? foreach($ranges as $range) :

   if (!\Studip\Mobile\News::haveRangePermission('view', $range->range_id,
                                                 $controller->currentUser()->id)) {
     continue;
   }

   $type = $range->getType();
   $readable_type = $readable_types[$type];
?>
    <li>
        <? if ($type === 'sem') { ?>
            <a href="<?= $controller->url_for('courses/show', $range->range_id) ?>">
                <?= $this->out($readable_type) ?>:
                <?= $this->out($range->getName()) ?>
            </a>

        <? } else if ($type === 'user') { ?>
            <a href="<?= $controller->url_for('profiles/show', $range->range_id) ?>">
                <?= $this->out($readable_type) ?>:
                <?= $this->out($range->getName()) ?>
            </a>

        <? } else { ?>
            <?= $this->out($readable_type) ?>: <?= $this->out($range->getName()) ?>
        <? } ?>
    </li>
<? endforeach ?>
</ul>
