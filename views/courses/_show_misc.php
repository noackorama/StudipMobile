<?
// Nummer
if ($course->seminar_number){
?>
  <div class="ui-grid-a a_bit_smaller_text">
    <div class="ui-block-a"><strong>Nummer:</strong></div>
    <div class="ui-block-b"><?=Studip\Mobile\Helper::out($course->seminar_number) ?></div>
  </div><!-- /grid-a -->
<?
}
// teilnehmer
if ($course->participants){
?>
  <div class="ui-grid-a a_bit_smaller_text">
    <div class="ui-block-a"><strong>Teilnehmer:</strong></div>
    <div class="ui-block-b"><?=Studip\Mobile\Helper::out($course->participants) ?></div>
  </div><!-- /grid-a -->
<?
}
// Voraussetzungen
if ($course->requirements){
?>
  <div class="ui-grid-a a_bit_smaller_text">
    <div class="ui-block-a"><strong>Voraussetzungen:</strong></div>
    <div class="ui-block-b"><?=Studip\Mobile\Helper::out($course->requirements) ?></div>
  </div><!-- /grid-a -->
<?
}
//Leistungsnachweis
if ($course->leistungsnachweis){
?>
  <div class="ui-grid-a a_bit_smaller_text">
    <div class="ui-block-a"><strong>L. Nachweis:</strong></div>
    <div class="ui-block-b"><?=Studip\Mobile\Helper::out($course->leistungsnachweis) ?></div>
  </div><!-- /grid-a -->
<?
}
// ects
if ($course->ects){
?>
  <div class="ui-grid-a a_bit_smaller_text">
    <div class="ui-block-a"><strong>ECTS-Punkte:</strong></div>
    <div class="ui-block-b"><?=Studip\Mobile\Helper::out($course->ects) ?> LP</div>
  </div><!-- /grid-a -->
<?
}
// Lernorganisation
if ($course->orga){
?>
  <div class="ui-grid-a a_bit_smaller_text">
    <div class="ui-block-a"><strong>Lernorganisation:</strong></div>
    <div class="ui-block-b"><?=Studip\Mobile\Helper::out($course->orga) ?></div>
  </div><!-- /grid-a -->
<?
}
// Sonstiges
if ($course->Sonstiges){
?>
  <div class="ui-grid-a a_bit_smaller_text">
    <div class="ui-block-a"><strong>Sonstiges:</strong></div>
    <div class="ui-block-b"><?=Studip\Mobile\Helper::out($course->Sonstiges) ?></div>
  </div><!-- /grid-a -->
<?
}
?>
