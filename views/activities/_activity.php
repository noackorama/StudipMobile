<?
use Studip\Mobile\Helper;

$categories = array(
  'files'   => _("Neue Datei"),
  'forum'   => _("Neuer Beitrag"),
  'info'    => _("Neue Info"),
  'news'    => _("Neue Ankündigung"),
  'surveys' => _("Neue Evaluation"),
  'votings' => _("Neue Umfrage"),
  'wiki'    => _("Neue Wikiseite")
);
?>

<? if (!empty($activity["link"])) { ?>

  <? if (Helper::isExternalLink($activity['link'])) : ?>
    <a href="<?= $activity['link'] ?>"
       class="externallink"
       data-ajax="false">

  <? else : ?>
    <a href="<?= $controller->url_for($activity['link']) ?>">
  <? endif ?>

<? } ?>

<img src="<?= $plugin_path ?>/public/images/activities/<?= $activity['category'] ?>.png"
     alt="<?= $categories[$activity['category']] ?>"
     class="ui-li-icon">

<p class=author>
    <?= Avatar::getAvatar($activity['author_id'])
              ->getImageTag(Avatar::SMALL,
                            array("class" => "ui-li-icon activity-avatar")) ?>

  <?= _("von") ?> <?= $this->out($activity['author']) ?>
</p>

<h3><?= $this->out($activity['title']) ?></h3>

<p class=summary>
  <?= $this->out(strip_tags($activity['content'])) ?>
</p>

<? if (!empty($activity["link"])){ ?>
  </a>
<? } ?>
