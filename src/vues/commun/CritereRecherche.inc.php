
<h2>Critère de recherche</h2>
<ul>
	<?php if (isset($dVueCritere['toutes']) && $dVueCritere['toutes']) {?>
	<li><label>Toutes les recettes</label></li>
	<?php } else { ?>
	<?php if (isset($dVueCritere['categorie'])) {?>
	<li><label>catégorie : </label><span><?php echo $dVueCritere['categorie']['intitule']; ?></span></li>
	<?php } ?>
	<?php if (isset($dVueCritere['sous_categorie'])) {?>
	<li><label>Sous catégorie : </label><span><?php echo $dVueCritere['sous_categorie']['intitule']; ?></span></li>
	<?php } ?>
	<?php } ?>
</ul>
