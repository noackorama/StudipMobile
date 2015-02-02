<div class="message-fast-reply">

  <?=
  Avatar::getAvatar($controller->currentUser()->id)->getImageTag(Avatar::SMALL, array("class" => "ui-li-icon")) ?>

  <form action="<?= $controller->url_for("mails/reply", $mail['message_id']) ?>" method="POST" class="message-compose">

    <div class=message-compose-body-wrapper>
      <label for="message-compose-body" class="ui-hidden-accessible">Deine Antwort:</label>
      <textarea id="message-compose-body"
                name="body"
                placeholder="<?= _('Deine Antwort') ?>"
                required></textarea>
    </div>

    <button type=submit>Absenden</button>

  </form>

</div>
