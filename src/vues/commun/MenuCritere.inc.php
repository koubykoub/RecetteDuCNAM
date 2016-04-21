<!-- selection des categorie / sous categories -->
<form method="post" action="" name="menu_critere">
	<input type="hidden" name="page" id="page" value="<?php echo ($dVueMenuCritere['lister_recette_utilisateur'] ? 'lister_recette_utilisateur' : 'lister_recette'); ?>" />
	
	<!-- liens categories -->
	<ul>
	<!-- toute les recettes -->
		<li>
	        <a href="javascript:document.menu_critere.submit()" onClick="javascript:MenuCritere_Toutes()">Toutes... </a>
	 	</li>
	
	<!-- categories / sous categories -->
	<?php foreach ($dVueMenuCritere['categories'] as & $cat) { ?>
	    <li>
	        <a href="javascript:document.menu_critere.submit()" onClick="javascript:MenuCritere_Categorie(<?php echo $cat['id']; ?>)"><?php echo $cat['intitule']; ?></a>
	        
	        <ul>
	        <!-- liens sous categories -->
	        <?php foreach ($cat['sous_categories'] as & $scat) { ?>
	        	<li><a href="javascript:document.menu_critere.submit()" onClick="javascript:MenuCritere_SousCategorie(<?php echo $scat['id']; ?>, <?php echo $cat['id']; ?>)"><?php echo $scat['intitule']; ?></a></li>
	        <?php } ?>
	        </ul>
	    </li>
	<?php } ?>
	</ul>
</form>
