<div id="container3">
	<div id="centered_block">
		<div id="onglet_container">
			<div id="tabs">
				<div class="onglet<?php isActive(1) ?>"><a href="?page=ressources_manager&onglet=1">Emprunts</a></div>
				<div class="onglet<?php isActive(2) ?>"><a href="?page=ressources_manager&onglet=2">Utilisateurs</a></div>
				<div class="onglet<?php isActive(3) ?>"><a href="?page=ressources_manager&onglet=3">Fournisseurs</a></div>
				<div class="onglet<?php isActive(4) ?>"><a href="?page=ressources_manager&onglet=4">Clés</a></div>
				<div class="onglet<?php isActive(5) ?>"><a href="?page=ressources_manager&onglet=5">Portes</a></div>
				<div class="onglet<?php isActive(6) ?>"><a href="?page=ressources_manager&onglet=6">Serrures</a></div>
				<div class="onglet<?php isActive(7) ?>"><a href="?page=ressources_manager&onglet=7">Salles</a></div>
			</div>
			<div id="tabcontent">
				<div class="tabpanel<?php showContent(1); ?>">
					<?php getForm1(); ?>
				</div>
				<div class="tabpanel<?php showContent(2); ?>">
						<?php getForm2(); ?>
				</div>
				<div class="tabpanel<?php showContent(3); ?>">
					<?php getForm3(); ?>
				</div>
				<div class="tabpanel<?php showContent(4); ?>">
					<?php getForm4(); ?>
				</div>
				<div class="tabpanel<?php showContent(5); ?>">
					<?php getForm5(); ?>
				</div>
				<div class="tabpanel<?php showContent(6); ?>">
					<?php getForm6(); ?>
				</div>
				<div class="tabpanel<?php showContent(7); ?>">
					<?php getForm7(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<a id="back_to_home" href="?page=main_page"></a>
