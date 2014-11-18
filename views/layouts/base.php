<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $page_title ?: "Stud.IP Mobile" ?></title>

    <link rel="apple-touch-icon" href="<?= $plugin_path ?>/public/images/quickdial/ios.png" type="image/gif" />

    <link rel="stylesheet"  href="<?= $plugin_path ?>/public/vendor/jquery.mobile.1.4.5/jquery.mobile-1.4.5.min.css" />
    <link rel="stylesheet"  href="<?= $plugin_path ?>/public/vendor/jqmthemes/studip/studip.css" />

    <link rel="stylesheet"  href="<?= $plugin_path ?>/public/stylesheets/mobile.css" />

    <script src="<?= $plugin_path ?>/public/vendor/underscore/underscore-min.js"></script>
    <script src="<?= $plugin_path ?>/public/vendor/jquery/jquery-1.9.1.min.js"></script>
    <script src="<?= $plugin_path ?>/public/vendor/jquery.mobile.1.4.5/jquery.mobile-1.4.5.min.js"></script>

    <script src="//maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
    <script src="<?= $plugin_path ?>/public/vendor/map/jquery.ui.map.full.min.js" type="text/javascript"></script>

    <script src="<?= $plugin_path ?>/public/vendor/date/date.js"></script>

    <script>
    var STUDIP = {
        ABSOLUTE_URI_STUDIP: '<?= $GLOBALS['ABSOLUTE_URI_STUDIP'] ?>',
        Mobile: {bootstraps: {}}
    };
    </script>

    <script src="<?= $plugin_path ?>/public/javascripts/custom.js"></script>

  </head>

  <body class="<?= $body_class ?>">

    <?= $content_for_layout ?>

  </body>
</html>
