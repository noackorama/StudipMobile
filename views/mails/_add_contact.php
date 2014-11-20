<div data-role="popup" id=mail-show-contacts data-theme="c" style="max-width:400px;">

  <div data-role="header" class="ui-corner-top" data-theme="e">
    <h1>Kontakte auswählen?</h1>
  </div>

  <div class="ui-corner-bottom ui-content">

    <div class="buttons" data-role=controlgroup data-type=horizontal>
      <button class=select data-theme="b">Auswählen</button>
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
