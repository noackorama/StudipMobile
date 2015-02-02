<?
if (!isset($_dataAttributes)) {
    $_dataAttributes = array();
}
$_dataAttributes['theme'] = $_dataAttributes['theme'] ?: 'c';
?>
<div data-role="page" id="<?= $page_id ?: '' ?>"
     <?
     foreach ($_dataAttributes as $key => $value) {
         if ($value !== false) {
             printf(' data-%s="%s"', $key,
                    $this->out($value));
         }
     }
     ?>
     >

  <div data-role="header" data-theme="a">
    <? if (!$no_side_menu) echo $this->render_partial("layouts/_side_menu_link") ?>
    <h1><?= $page_title ?: 'Stud.IP' ?></h1>

    <?= isset($additional_header) ? $additional_header : "" ?>
  </div><!-- /header -->

  <div class="ui-content" data-theme="c" role="main">
    <? if (isset($flash['notice'])) { echo $this->render_partial('layouts/_flash_notice'); } ?>

    <?= $content_for_layout ?>
  </div><!-- /content -->

  <?= isset($additional_footer) ? $additional_footer : '' ?>

  <?= isset($additional_panel) ? $additional_panel : '' ?>

</div>
