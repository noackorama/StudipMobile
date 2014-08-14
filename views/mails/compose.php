<?
$page_title = "Neue Nachricht";
$page_id = "mail-write";

$body_class = "mails";
$this->set_layout("layouts/base");

?>
  
<div data-role="page" id="<?= $page_id ?: '' ?>">
    <?= $this->render_partial('layouts/_side_menu') ?>

	<div data-role="header" data-theme="a">
                <?= $this->render_partial('layouts/_side_menu_link') ?>
        	<h1>Nachrichten</h1>
        	<a href="#popupMenu" data-rel="popup" data-role="button" data-inline="true">Neue</a>
        	<div data-role="popup" id="popupMenu" data-theme="a">
				<ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="d">
					<li><a href="<?= $controller->url_for("mails/index") ?>">Eingang</a></li>
					<li><a href="<?= $controller->url_for("mails/list_outbox") ?>">Ausgang</a></li>
					<li data-role="divider" data-theme="a">Neue Nachricht</li>
				</ul>
			</div>
	</div><!-- /header -->
      <div data-role="content">
      <?
      		if (!empty( $empfData ))
      		{
      			// adressat wurde gewählt
	      		?>
	      			<p>
	      			<form action="<?= $controller->url_for("mails/send", $empfData['username']) ?>" method="POST" data-ajax="false">
	      				<div class="ui-grid-b a_bit_smaller_text" data-theme="c" style="font-size:10pt;">
                        	<div class="ui-block-a">
	                        	<img  src="
	                        		<?= $controller->url_for("avatars/show", $empfData["user_id"], 'medium') ?>" 
	                        		alt="Profil-Bild">
                        	</div>
                        	<div class="ui-block-b">
	                        	<h3>Empfänger: </h3><?=Studip\Mobile\Helper::out($empfData['vorname']. " " . $empfData['nachname']) ?>
                        	</div>
                        </div><!-- /grid-a -->
	      				<hr>
	      				<h3>Betreff</h3>
	      				<input name="mail_title">
	      				<h3>Nachricht</h3>
	      				<textarea style="min-height:200px;" name="mail_message"></textarea>
	      				<button value="submit">Senden</button>
	      				</p>
	      		<?
      		}
      		else
      		{
	      		//kein adressat wurde gewählt, es werden alle teilnehmer alle Kontakte
	      		
	      		?>
				<ul id="courses" data-role="listview" data-filter="true" data-filter-placeholder="Suchen" data-divider-theme="d" >
				<li data-role="divider" data-theme="d">Bitte wählen Sie einen Empfänger:</li>
				<?
				    if($members) {
					    foreach ($members AS $member)   
    					{
    					?>
    				        <li>
    					        <a href="<?= $controller->url_for("mails/write", $member['user_id']) ?>">
    					            <?= Avatar::getAvatar($member['user_id'])->getImageTag(Avatar::MEDIUM, array('class' => 'ui-li-thumb')) ?>
    						        <h3><?=Studip\Mobile\Helper::out($member["title_front"]) ?>
    						            <?=Studip\Mobile\Helper::out($member['Vorname']) ?>
    						            <?=Studip\Mobile\Helper::out($member['Nachname'])?>
    						        </h3>
    						    </a>
    				        </li>
    				    <?
    				    }
    				} else {
    				    ?>
    				    <li>
    				    <h3>Sie haben noch keine Kontake!</h3>
                        <p>Bitte fügen Sie NutzerInnen zu Ihrer Kontaktliste hinzu, um diese als Empfänger auswählen zu können.</p>
                        </li>
                        <?
    				}
				    ?>
				</ul>
				<?
      		}
      
      ?>
	  </div>
</div>