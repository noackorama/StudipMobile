<?
$this->set_layout("layouts/single_page");

$page_title = "Nachricht";
$page_id = "mail-show";

$additional_header = $this->render_partial('mails/_message_header');
$additional_footer = $this->render_partial('mails/_message_footer');
?>

<? if (sizeof($mail)) {
     $time      = date("H:i",$mail[0]['mkdate']);
     $wochentag = \Studip\Mobile\Helper::get_weekday(date("N", $mail[0]['mkdate']));
     $monat     = \Studip\Mobile\Helper::get_month(date("m", $mail[0]['mkdate']));
     $day       = $wochentag.date(", j. ",$mail[0]['mkdate']).$monat.date(", Y",$mail[0]['mkdate']);
?>
  <ul data-role="listview">

    <li data-role="fieldcontain">
      <h3 style="white-space:normal;"><?= Studip\Mobile\Helper::out($mail[0]['title']) ?></h3>
      <p><strong><?=$day ?> </strong></p>
    </li>

    <li data-role="fieldcontain">
      <p style="padding-top:12px;">
        <strong>Von:</strong> <?= $mail[0]['author_id'] != '____%system%____' ? Studip\Mobile\Helper::out($mail[0]['author']) : 'Stud.IP-System' ?>
      </p>
      <p style="padding-top:12px;">
        <strong>An:</strong> <?= Studip\Mobile\Helper::out($mail[0]['receiver']) ?>
      </p>
      <span class="ui-li-count"> <?=$time ?> Uhr</span>
    </li>
  </ul>

  <p style="font-family: Helvetica,Arial,sans-serif;font-size: 12px;font-weight: normal;white-space:normal;">
    <br />
    <?= Studip\Mobile\Helper::fout($mail[0]['message'],TRUE, TRUE); ?>
  </p>


<? } else { ?>
  <p>Beim Laden der Nachricht ist ein Fehler aufgetreten.</p>
<? } ?>
