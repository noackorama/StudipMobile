<li class="message-author" data-icon=info>
  <a href="<?= $controller->url_for('profiles/show/', $mail['sender_id']) ?>">
    von
    <? if ($mail['sender_id'] === $controller->currentUser()->id) : ?>
      Ihnen selbst
    <? else: ?>
      <?= $this->out($system_mail ? _('Stud.IP-System') : get_fullname($mail['sender_id'])) ?>
    <? endif ?>

    <span>
      <?= Avatar::getAvatar($mail['sender_id'])->getImageTag(Avatar::SMALL) ?>
    </span>
  </a>
</li>
