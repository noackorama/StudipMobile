<ul data-role="listview" data-filter="<?= sizeof($messages) > 4 ? 'true' : '' ?>" data-filter-placeholder="Suchen" data-divider-theme="d">

  <? if (empty($messages)) { ?>

    <li data-theme="e" data-role="list-divider"><center>Keine Nachrichten vorhanden</center></li>

  <? } else { ?>


    <? foreach ($messages as $mail) { ?>

      <? if (date("j.m.Y", $mail['mkdate']) != $dayCount) { ?>
        <? $dayCount = date("j.m.Y", $mail['mkdate']); ?>

        <li data-role="list-divider"><?= $this->formatDate($mail['mkdate'], false) ?></li>

      <? } ?>

      <li data-theme="<?= ($selected === 'inbox' && $mail['unread']) ? 'e' : 'c' ?>">

        <a href="<?= $controller->url_for("mails", $selected, $mail['message_id']) ?>" data-transition="slideup">

          <h3>
            <?= $this->out($mail['subject']) ?>
            <? if (sizeof($mail['attachments']) > 0) { ?>
              <?= Assets::img("icons/16/grey/staple", array('class' => 'mail-attachment')) ?>
            <? } ?>
          </h3>

          <? if ($selected === 'inbox') : ?>
            <p class=message-author>
              von <?= $mail['sender_id'] != '____%system%____' ? $this->out(get_fullname($mail['sender_id'])) : 'Stud.IP-System' ?>
            </p>
          <? else : ?>
            <p class=message-recipients>
              <? if (sizeof($mail['receivers']) > 1) : ?>
                an <?= sizeof($mail['receivers']) ?> Empfänger
              <? else: ?>
                an <?= $this->out(get_fullname(key($mail['receivers']))) ?>
                <? endif ?>
            </p>
          <? endif ?>

        </a>
      </li>
    <? } ?>

  <? } ?>
</ul>
