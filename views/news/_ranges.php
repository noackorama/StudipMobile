<?
$readable_types = array(
    'global' => _('Stud.IP'),
    'sem'    => _('in der Veranstaltung'),
    'inst'   => _('im Institut'),
    'fak'    => _('in der Fakultät'),
    'user'   => _('bei Nutzer'));
?>

<ul id="news-ranges" data-role="listview" data-theme="d">
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
                <small><?= $this->out($readable_type) ?>:</small>
                <?= $this->out($range->getName()) ?>
            </a>

        <? } else if ($type === 'user') { ?>
            <a href="<?= $controller->url_for('profiles/show', $range->range_id) ?>">
                <small><?= $this->out($readable_type) ?>:</small>
                <?= $this->out($range->getName()) ?>
            </a>

        <? } else { ?>
            <small><?= $this->out($readable_type) ?>:</small>
            <?= $this->out($range->getName()) ?>
        <? } ?>
    </li>
<? endforeach ?>
</ul>
