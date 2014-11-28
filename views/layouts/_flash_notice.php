<? if (isset($flash['notice'])) { ?>

  <div id="popup-flash-notice" data-role="popup" data-history="false" data-theme=b>
    <p><?= Studip\Mobile\Helper::out($flash['notice']) ?></p>
  </div>

  <script>
   $(document).one("pagecontainershow", function() {
     var notice = $("#popup-flash-notice");
     if (!notice.length) return;
     setTimeout(function () {
       notice.popup("open").on("popupafterclose", function () {
         $(this).remove();
       });
     }, 100);
   });
  </script>
<? } ?>
