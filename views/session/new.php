<?
$this->setPageOptions('session-new', 'Stud.IP Login',
                      array('no_side_menu' => true));
$this->setPageData(array('theme' => 'a'));
$desktop_url = URLHelper::getLink($GLOBALS['ABSOLUTE_URI_STUDIP'], array(StudipMobile::REDIRECTION_STOP_WORD => 1));
?>

<? if ($flash['failed_login']) :?>
    <div data-role="collapsible" data-theme="e" data-content-theme="e">
        <h3><?=_("Der Login-Vorgang war nicht erfolgreich.")?></h3>
        <p><?=_("Bitte geben Sie einen korrekten Nutzernamen und Passwort ein.")?></p>
    </div>
<? endif ?>


<div class="logo ui-grid-a ui-responsive">
    <div class="ui-block-a">
        <img src="<?=$plugin_path ?>/public/images/studip-logo.svg">
    </div>
    <div class="ui-block-b">
        <h3>mobile Web-App</h3>
    </div>
</div>

<div class="ui-body ui-body-c">

    <form action="<?= $controller->url_for('session/create') ?>"
          method="post" data-ajax="false" data-theme="c">
        <input type=hidden name=again value=yes>
        <input type=hidden name=cancel_login value=1>

        <div class="ui-field-contain">
            <label for="username">Nutzername:</label>
            <input name="username" id="username" type="text">
        </div>

        <div class="ui-field-contain">
            <label for="password">Passwort:</label>
            <input type="password" name="password" id="password">
        </div>

        <input class="ui-btn" role="button" name="submit" type="submit"
               value="Login" data-corners="false" data-theme="b">
    </form>

</div>


<a href="<?= $desktop_url ?>" class="ui-btn ui-btn-a externallink" data-ajax="false">Zur Webansicht</a>
