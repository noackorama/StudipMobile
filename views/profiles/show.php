<?
$page_title = $this->out($data["user_data"]["title_front"]." ". $data["user_data"]["vorname"]." ".$data["user_data"]["nachname"]?:"Profil");
$page_id = "profile-index";
$this->set_layout("layouts/single_page");

require_once('lib/user_visible.inc.php');
$user_id = $data['user_data']['user_id'];
$visibilities = get_local_visibility_by_id($user_id, 'homepage');
?>

<div class="ui-grid-a ui-responsive" >

  <div class="ui-block-a">
    <?= Avatar::getAvatar($user_id)->getImageTag(Avatar::NORMAL, array('style' => 'width:90%;', 'alt' => 'Profil-Bild')) ?>
  </div>

  <div class="ui-block-b">
    <ul data-role="listview" data-inset="true">

      <? if (isset($data["user_data"]["email"]) && get_visible_email($user_id) != '') { ?>
        <li>
          <a href="mailto:<?= htmlReady( $data["user_data"]["email"] ) ?>">
            <?=htmlReady( $data["user_data"]["email"] ) ?>
          </a>
        </li>
      <? } ?>

      <li>
        <a href="<?= $controller->url_for("mails/compose") ?>?to=<?= htmlReady($user_id) ?>">
          Nachricht senden
        </a>
      </li>
    </ul>
  </div>

</div>

<?
   if ($data["user_data"]["lebenslauf"] !== ""
       || $data["user_data"]["hobby"] !== ""
       || $data["user_data"]["home"] !== ""
       || $data["user_data"]["privatnr"] !== ""
       || $data["user_data"]["privatcell"] !== ""
       || $data["user_data"]["privadr"] !== ""
       || $data["user_data"]["motto"] !== ""
       || $data["user_inst"]["Telefon"] !== ""
       || $data["user_inst"]["Fax"] !== ""
       || $data["user_inst"]["raum"] !== ""
       || $data["user_inst"]["sprechzeiten"] !== "") {
?>

  <div data-role="collapsible" data-content-theme="d" data-collapsed="false">

    <h3>Kontakt</h3>

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

    <br>

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
  </div>
<? } ?>

<? if ($data["user_data"]["publi"] && is_element_visible_for_user($cuid, $user_id, $visibilities['publi'])) { ?>
  <div data-role="collapsible" data-theme="c" data-content-theme="d" data-collapsed="true">
    <h3>Publikationen</h3>
    <p>
      <?= $this->fout($data["user_data"]["publi"]) ?>
    </p>
  </div>
<? } ?>

<? if ($data["user_data"]["schwerp"] && is_element_visible_for_user($cuid, $user_id, $visibilities['schwerp'])) { ?>
  <div data-role="collapsible" data-theme="c" data-content-theme="d" data-collapsed="true">
    <h3>Schwerpunkte</h3>
    <p>
      <?= $this->fout($data["user_data"]["schwerp"]) ?>
    </p>
  </div>
<? } ?>

<? if ($data["inst_info"]) { ?>
  <div data-role="collapsible" data-theme="c" data-content-theme="d" data-collapsed="true">
    <h3>Einrichtungsdaten</h3>
    <? if ($data["inst_info"]["inst_name"]) { ?>
      <div class="ui-grid-a">
        <div class="ui-block-a">Name</div>
        <div class="ui-block-b"><?= $this->out( $data["inst_info"]["inst_name"] ) ?></div>
      </div>
    <? } ?>

    <? if ($data["inst_info"]["inst_strasse"]) { ?>
      <div class="ui-grid-a">
        <div class="ui-block-a">Anschrift</div>
        <div class="ui-block-b">
          <?= $this->out( $data["inst_info"]["inst_strasse"] ) ?><br>
          <?= $this->out( $data["inst_info"]["inst_plz"] ) ?>
        </div>
      </div>
    <? } ?>

    <? if ($data["inst_info"]["inst_telefon"]) { ?>
      <div class="ui-grid-a">
        <div class="ui-block-a">Telefon</div>
        <div class="ui-block-b"><?= $this->out($data["inst_info"]["inst_telefon"]) ?></div>
      </div>
    <? } ?>

    <? if ($data["inst_info"]["inst_fax"]) { ?>
      <div class="ui-grid-a">
        <div class="ui-block-a">Fax</div>
        <div class="ui-block-b"><?= $this->out( $data["inst_info"]["inst_fax"] ) ?></div>
      </div>
    <? } ?>

    <? if ($data["inst_info"]["inst_email"]) { ?>
      <div class="ui-grid-a">
        <div class="ui-block-a">E-Mail</div>
        <div class="ui-block-b"><?= $this->out( $data["inst_info"]["inst_email"] ) ?></div>
      </div>
    <? } ?>

    <? if ($data["inst_info"]["inst_url"]) { ?>
      <div class="ui-grid-a">
        <div class="ui-block-a">Homepage</div>
        <div class="ui-block-b"><?= \Studip\Mobile\Helper::correctText(htmlReady($data["inst_info"]["inst_url"])) ?></div>
      </div>
    <? } ?>

  </div>
<? } ?>
