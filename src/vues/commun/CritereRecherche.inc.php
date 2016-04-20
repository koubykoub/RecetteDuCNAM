
<h2>Critère de recherche</h2>
<ul>
	<?php if (isset($dVueCritere['toutes']) && $dVueCritere['toutes']) {?>
	<li>Toutes</li>
	<?php } else { ?>
	<?php if (isset($dVueCritere['categorie'])) {?>
	<li>catégorie : <span><?php echo $dVueCritere['categorie']['intitule']; ?></span></li>
	<?php } ?>
	<?php if (isset($dVueCritere['sous_categorie'])) {?>
	<li>Sous catégorie : <span><?php echo $dVueCritere['sous_categorie']['intitule']; ?></span></li>
	<?php } ?>
	<?php } ?>
</ul>
