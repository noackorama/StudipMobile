<?
$selected = 'inbox';
$this->setPageOptions('Posteingang (' . intval(sizeof($messages)) . ')', 'mails-index');
$this->addFooter('mails/_index_footer', compact('selected'));
$this->setPageData(array('cache' => 'never'));
?>

<?= $this->render_partial('mails/_message_list', compact('selected')) ?>
