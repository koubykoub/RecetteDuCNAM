<?php if (!is_null($dVueRandomRecette['recette_random'])) { ?>

<!-- recette au hazard -->
<form method="post" action="" name="afficher_recette">
	<input type="hidden" name="page" id="page" value="afficher_recette" />
	<input type="hidden" name="id_recette" id="id_recette" value="<?php echo $dVueRandomRecette['recette_random']['id']; ?>" />
	<h2>Recette au hasard : <a href="javascript:document.afficher_recette.submit()"><?php echo $dVueRandomRecette['recette_random']['titre']; ?></a></h2>
</form>

<!-- ingredients -->
<h3>Ingédients</h3>
<ul>
<?php foreach ($dVueRandomRecette['recette_random']['ingredients'] as $ingredient) { ?>
	<li><p><?php echo $ingredient['texte_ingredient']; ?></p></li>
<?php } ?>
</ul>

<!-- preparation -->
<h3>Préparation</h3>
<ul>
<?php foreach ($dVueRandomRecette['recette_random']['etape_preparations'] as $ingredient) { ?>
	<li><p><?php echo $ingredient['texte_etape']; break; ?></p></li>
<?php } ?>
	<li>...</li>
</ul>

<?php } else { ?>
	<h2>Recette au hasard : </h2>
	<h4>Aucune recette ne correspond aux critères de recherche</h4>
<?php } ?>
