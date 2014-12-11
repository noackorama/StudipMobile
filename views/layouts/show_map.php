<!DOCTYPE html>
<html>
    <?
    require "head_normal.php";
  ?>
  <body>
    <div data-role="page" id="<?= $page_id ?: '' ?>" >
      <?= $this->render_partial('layouts/side_menu') ?>
      <div data-role="header"  data-theme="a">
        <?= $this->render_partial('layouts/side_menu_link') ?>

        <h1><?= $page_title ?: 'Stud.IP' ?></h1>
        <a href="javascript:history.back()" class="externallink" data-ajax="false" data-icon="delete" data-iconpos="notext" data-theme="d"></a>
      </div><!-- /header -->
      
      <div class="ui-content" role="main">
        <?= $content_for_layout ?>
      </div><!-- /content -->
  </body>
</html>

