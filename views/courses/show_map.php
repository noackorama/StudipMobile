<?
$this->set_layout("layouts/base");

// orte ohne geoinfo nicht anzeigen
$resources_locations = array();
foreach ($resources AS $reso) {
    if (is_numeric($reso['latitude']) && is_numeric($reso['longitude'])) {
        //wenn keine geoinfos: aus array kicken
        $resources_locations[] = $reso;
    }
}
?>


<div data-role="page" id="courses-show_map">
  <?= $this->render_partial('layouts/_side_menu') ?>

  <div data-role="header"  data-theme="<?=TOOLBAR_THEME ?>">
    <?= $this->render_partial('layouts/_side_menu_link') ?>
    <h1>Karte</h1>
    <a href="javascript:history.back()" class="externallink"
       data-ajax="false" data-icon="delete"
       data-iconpos="notext" data-theme="d"></a>
  </div><!-- /header -->

  <div class="ui-content" role="main">


    <?
       if (empty($resources_locations)) {
         echo "<center><h3>Leider sind für diesen Kurs keine Geoinformationen vorhanden</h3></center>";
       } else {
           $first_resource = array_shift($resources);
           array_unshift($resources,$first_resource);
    ?>


    <script type="text/javascript">
      $(function() {
        // Also works with: var yourStartLatLng = '59.3426606750, 18.0736160278';
        var yourStartLatLng = new google.maps.LatLng(<?=$first_resource['latitude'] ?> ,<?=$first_resource['longitude'] ?>);
        $('#map_canvas').gmap({
          'center': yourStartLatLng,
          zoom: 14,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          navigationControl: true
        });

        $('#map_canvas').gmap().bind('init', function() {

          <? foreach ($resources_locations AS $resource) { ?>
            $('#map_canvas').gmap('addMarker', {
              'position':  '<?=$resource['latitude'] ?> ,<?=$resource['longitude'] ?>',
              'bounds': false
            }).click(function() {
              $('#map_canvas').gmap('openInfoWindow', {
                'content': '<span style="font-weight:bold"><?=Studip\Mobile\Helper::out($resource[name]) ?></span><br><span style="font-weight:normal;"><?=Studip\Mobile\Helper::out($resource[description]) ?></span'
              }, this);
            });
            <? } ?>

        });
      });

    </script>

    <div class="ui-bar-c ui-corner-all ui-shadow" style="margin-top:0em;">
      <div id="map_canvas" style="height:335px;"></div>
    </div>

    <script type="text/javascript">
    // stellt sicher, dass immer 80% der höhe von der karte gefüllt sind
        $("#map_canvas").height( $(window).height() - (0.1 * $(window).height()));
        $(window).resize(function(){
                $("#map_canvas").height( $(window).height() - (0.2 * $(window).height()));
        });
    </script>

    <? } ?>
  </div><!-- /content -->

</div>
