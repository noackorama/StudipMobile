<?
$this->setPageOptions('courses-index', 'Veranstaltungen');
?>

<? if (sizeof($courses)) : ?>

  <?= $this->render_partial('courses/_list.php') ?>

<? else : ?>

  <p>
    Sie haben zur Zeit keine Veranstaltungen abonniert, an denen Sie
    teilnehmen können. Bitte nutzen Sie <a href="#">Veranstaltung suchen
    / hinzufügen</a> um neue Veranstaltungen aufzunehmen
  </p>

<? endif ?>
