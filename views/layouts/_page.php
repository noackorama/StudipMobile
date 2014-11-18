<div data-role="page"
     id="<?= $page_id ?: '' ?>"
     <?
     if (isset($_dataAttributes)) {
       foreach ($_dataAttributes as $key => $value) {
         if ($value !== false) {
           printf(' data-%s="%s"', $key,
                  Studip\Mobile\Helper::out($value));
         }
       }
     }
     ?>
     <?= $back_button ? 'data-add-back-btn="true"' : '' ?>>

  <?= $this->render_partial("layouts/_side_menu") ?>

  <div data-role="header" data-theme="<?= TOOLBAR_THEME ?>">
    <? if (!$no_side_menu) echo $this->render_partial("layouts/_side_menu_link") ?>
    <h1><?= $page_title ?: 'Stud.IP' ?></h1>

    <?= isset($additional_header) ? $additional_header : "" ?>
  </div><!-- /header -->

  <div data-role="content" data-theme="c">
    <? if (isset($flash['notice'])) { echo $this->render_partial('layouts/_flash_notice'); } ?>

    <?= $content_for_layout ?>
  </div><!-- /content -->

  <?= isset($additional_footer) ? $additional_footer : '' ?>

  <?= isset($additional_panel) ? $additional_panel : '' ?>

</div>
