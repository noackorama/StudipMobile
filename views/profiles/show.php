<?
$profile_name = $this->out(join(' ', array(
    $data['user_data']['title_front'],
    $data['user_data']['vorname'],
    $data['user_data']['nachname']
)));
$this->setPageOptions('profile-index', $profile_name ?: 'Profil');

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

<?= $this->render_partial('profiles/_contact') ?>

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
  <div class="profile-institute" data-role="collapsible" data-theme="c" data-content-theme="d" data-collapsed="true">
    <h3>Einrichtungsdaten</h3>
    <div class="ui-grid-a ui-responsive">
        <? if ($data["inst_info"]["inst_name"]) { ?>
            <div class="ui-block-a">Name</div>
            <div class="ui-block-b"><?= $this->out( $data["inst_info"]["inst_name"] ) ?></div>
        <? } ?>

        <? if ($data["inst_info"]["inst_strasse"]) { ?>
            <div class="ui-block-a">Anschrift</div>
            <div class="ui-block-b">
                <?= $this->out( $data["inst_info"]["inst_strasse"] ) ?><br>
                <?= $this->out( $data["inst_info"]["inst_plz"] ) ?>
            </div>
        <? } ?>

        <? if ($data["inst_info"]["inst_telefon"]) { ?>
            <div class="ui-block-a">Telefon</div>
            <div class="ui-block-b"><?= $this->out($data["inst_info"]["inst_telefon"]) ?></div>
        <? } ?>

        <? if ($data["inst_info"]["inst_fax"]) { ?>
            <div class="ui-block-a">Fax</div>
            <div class="ui-block-b"><?= $this->out( $data["inst_info"]["inst_fax"] ) ?></div>
        <? } ?>

        <? if ($data["inst_info"]["inst_email"]) { ?>
            <div class="ui-block-a">E-Mail</div>
            <div class="ui-block-b"><?= $this->out( $data["inst_info"]["inst_email"] ) ?></div>
        <? } ?>

        <? if ($data["inst_info"]["inst_url"]) { ?>
            <div class="ui-block-a">Homepage</div>
            <div class="ui-block-b"><?= \Studip\Mobile\Helper::correctText(htmlReady($data["inst_info"]["inst_url"])) ?></div>
        <? } ?>
  </div>
<? } ?>
