<? $this->set_layout("layouts/base"); ?>

<div data-role="page" id="<?= $page_id ?: '' ?>">
    <div data-role="header">
        <h1><?= $page_title ?: 'Stud.IP' ?></h1>
    </div><!-- /header -->

    <div class="ui-content" role="main">
        <?= $content_for_layout ?>
    </div><!-- /content -->
</div>


