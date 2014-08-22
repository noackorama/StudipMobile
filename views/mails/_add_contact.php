<div data-role="popup" id=mail-show-contacts style="max-width:400px;">
  <div data-role="header" data-theme="e" class="ui-corner-top">
    <h1>Kontakte auswählen?</h1>
  </div>

  <div role="main" class="ui-corner-bottom ui-content">

    <div data-role=controlgroup data-type=horizontal>
      <button class=select data-theme=a>Auswählen</button>
      <a data-role=button href="#mail-compose" data-rel=back>Abbrechen</a>
    </div>

    <ul data-role=listview data-filter=<?= sizeof($contacts) > 3 ? 'true' : 'false' ?>>
      <? foreach ($contacts as $contact): ?>
        <li class=contact>

          <form>
            <fieldset data-role=controlgroup data-iconpos=left>
              <input type=checkbox id=checkbox-<?= $contact['id'] ?> data-id=<?= $contact['id'] ?>>
              <label for=checkbox-<?= $contact['id'] ?>>
                <img src="<?= $contact['avatar'] ?>">
                <?= $this->out($contact['name']) ?>
              </label>
            </fieldset>
          </form>

        </li>
      <? endforeach ?>
    </ul>
  </div>
</div>
