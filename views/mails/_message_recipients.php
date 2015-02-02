<? if ($mail['sender_id'] === $controller->currentUser()->id) : ?>

  <? $num = sizeof($mail['receivers']); ?>

  <? if ($num === 1) : ?>

    <? $rec_id = key($mail['receivers']) ?>

    <li class=message-receiver data-icon=info>
      <a href="<?= $controller->url_for('profiles/show/', $rec_id) ?>">
        an
        <?= $rec_id === $controller->currentUser()->id ? 'Sie' : get_fullname($rec_id, 'no_title') ?>
      </a>
    </li>

  <? else : ?>
    <li class=message-receivers data-role="collapsible" data-iconpos="right" data-inset="true" data-theme="c" data-content-theme="d">
        <h4>an <?= $num ?> Empfänger</h4>
        <ul data-role="listview">
          <? foreach ($mail['receivers'] as $rec_id => $receiver) : ?>
            <li data-icon=info>
              <a href="<?= $controller->url_for('profiles/show/', $rec_id) ?>">
                <?= Avatar::getAvatar($rec_id)->getImageTag(Avatar::SMALL, array('class' => 'ui-li-icon')) ?>
                <?= get_fullname($rec_id, 'no_title') ?>
              </a>
            </li>
          <? endforeach ?>
        </ul>
    </li>
  <? endif ?>
<? endif ?>
