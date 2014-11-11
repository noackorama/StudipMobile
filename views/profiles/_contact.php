    <? ob_start(); ?>

    <? if ($data["user_inst"]["Telefon"]) { ?>
      <div class="ui-grid-a">
        <div class="ui-block-a">Telefon</div>
        <div class="ui-block-b"><?= $this->out( $data["user_inst"]["Telefon"]) ?></div>
      </div>
    <? } ?>

    <? if ($data["user_inst"]["Fax"]) { ?>
      <div class="ui-grid-a">
        <div class="ui-block-a">Fax</div>
        <div class="ui-block-b"><?= $this->out( $data["user_inst"]["Fax"]) ?></div>
      </div>
    <? } ?>

    <? if ($data["user_inst"]["raum"]) { ?>
      <div class="ui-grid-a">
        <div class="ui-block-a">Raum</div>
        <div class="ui-block-b"><?= $this->out( $data["user_inst"]["raum"]) ?></div>
      </div>
    <? } ?>
    <? if ($data["user_inst"]["sprechzeiten"]) { ?>
      <div class="ui-grid-a">
        <div class="ui-block-a">Sprechzeiten</div>
        <div class="ui-block-b">
          <?= \Studip\Mobile\Helper::correctText(htmlReady( $data["user_inst"]["sprechzeiten"])) ?>
        </div>
      </div>
    <? } ?>

    <? if ($data["user_data"]["privatnr"] && is_element_visible_for_user($cuid, $user_id, $visibilities['private_phone'])) { ?>
      <div class="ui-grid-a">
        <div class="ui-block-a">Telefon(privat)</div>
        <div class="ui-block-b"><?= $this->out( $data["user_data"]["privatnr"]) ?></div>
      </div>
    <? } ?>

    <? if ($data["user_data"]["privatcell"] && is_element_visible_for_user($cuid, $user_id, $visibilities['private_cell'])) { ?>
      <div class="ui-grid-a">
        <div class="ui-block-a">Mobiltelefon(privat)</div>
        <div class="ui-block-b"><?= $this->out( $data["user_data"]["privatcell"]) ?></div>
      </div>
    <? } ?>

    <? if ($data["user_data"]["privadr"] && is_element_visible_for_user($cuid, $user_id, $visibilities['privadr'])) { ?>
      <div class="ui-grid-a">
        <div class="ui-block-a">Adresse (privat)</div>
        <div class="ui-block-b"><?= $this->out( $data["user_data"]["privadr"]) ?></div>
      </div>
    <? } ?>

    <? if ($data["user_data"]["home"] && is_element_visible_for_user($cuid, $user_id, $visibilities['homepage'])) { ?>
      <div class="ui-grid-a">
        <div class="ui-block-a">Homepage (privat)</div>
        <div class="ui-block-b"><?=\Studip\Mobile\Helper::fout( $data["user_data"]["home"]) ?>
        </div>
      </div>
    <? } ?>

    <? if ($data["user_data"]["hobby"] && is_element_visible_for_user($cuid, $user_id, $visibilities['hobby'])) { ?>
      <div class="ui-grid-a">
        <div class="ui-block-a">Hobbys</div>
        <div class="ui-block-b"><?= \Studip\Mobile\Helper::fout($data["user_data"]["hobby"]) ?></div>
      </div>
    <? } ?>

    <? if ($data["user_data"]["lebenslauf"] && is_element_visible_for_user($cuid, $user_id, $visibilities['lebenslauf'])) { ?>
      <div class="ui-grid-a">
        <div class="ui-block-a">Lebenslauf</div>
        <div class="ui-block-b"><?=Studip\Mobile\Helper::fout($data["user_data"]["lebenslauf"]) ?></div>
      </div>
    <? } ?>

  <? if (strlen($contact_string = trim(ob_get_clean()))) { ?>
    <div data-role="collapsible" data-content-theme="d" data-collapsed="false">
      <h3>Kontakt</h3>
      <div>
        <?= $contact_string ?>
      </div>
    </div>
  <? } ?>
