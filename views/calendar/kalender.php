<?
$additional_footer = $this->render_partial('calendar/_navbar_footer', array('active' => 'kalender'));
$this->setPageOptions('calendar-show', 'Terminkalender');
?>

<div id=calendar></div>


<script src="<?= $plugin_path ?>/public/vendor/jqm-calendar/jw-jqm-cal.js"></script>

<script>
STUDIP.Mobile.bootstraps.events = <?= json_encode($controller->filter_utf8($events)) ?>;
STUDIP.Mobile.bootstraps.date   = <?= json_encode($controller->filter_utf8(date('r', $stamp))) ?>;
</script>

<script src="<?= $plugin_path?>/public/javascripts/bundle/page_calendar.js"></script>
