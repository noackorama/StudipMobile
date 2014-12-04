<div data-role="footer" data-id="calendar-footer"
     data-position="fixed">

    <div data-role="navbar">
        <ul>
            <li>
                <a class="<?= $active === 'index' ? 'ui-btn-active' : '' ?>" href="<?= $controller->url_for("calendar/index") ?>" data-ajax="false">
                    Stundenplan
                </a>
            </li>

            <li>
                <a class="<?= $active === 'kalender' ? 'ui-btn-active' : '' ?>" href="<?= $controller->url_for("calendar/kalender") ?>" data-ajax="false">
                    Kalender
                </a>
            </li>
        </ul>
    </div>

</div>
