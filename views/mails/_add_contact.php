<div data-role="popup" id=mail-show-contacts data-theme="c" style="max-width:400px;">

  <div data-role="header" data-theme="e">
    <h1>Kontakte auswählen?</h1>
  </div>

  <div class="ui-content">

    <div class="buttons" data-role=controlgroup data-type=horizontal>
      <button class="ui-btn ui-btn-b select ui-mini">Auswählen</button>
      <a class="ui-btn ui-mini" role=button href="#mail-compose" data-rel=back>Abbrechen</a>
    </div>

    <form class="ui-filterable">
        <input id="filter-input" data-type="search" placeholder="Filtern">
    </form>

    <ul data-role=listview
        data-filter="true" data-input="#filter-input"
        >
      <? if (false) foreach ($contacts as $contact): ?>
        <li class=contact>

          <input type=checkbox id=checkbox-<?= $contact['id'] ?> data-id=<?= $contact['id'] ?>>
          <label for=checkbox-<?= $contact['id'] ?>>
            <img src="<?= $contact['img'] ?>">
            <?= $this->out($contact['name']) ?>
          </label>

        </li>
      <? endforeach ?>
    </ul>
  </div>
</div>
