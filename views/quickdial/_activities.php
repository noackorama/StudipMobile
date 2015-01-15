<?
$this->set_layout('layouts/_page');
$page_id = 'quickdial-activities';
$page_title = $title;
?>

<?= $this->render_partial('activities/_activities',
                          array('activities' => $activities)) ?>
