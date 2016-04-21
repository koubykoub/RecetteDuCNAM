<!-- titre de la recette -->
<h2><?php echo $dVueAfficherRecette['recette']['titre']; ?></h2>

<!-- photo -->
<?php if (isset($dVueAfficherRecette['recette']['photo'])) { ?>
<div>
	<h3>Photo</h3>
  	<img alt="" src="?page=image&image=<?php echo $dVueAfficherRecette['recette']['photo']; ?>" />
</div>
<?php } ?>

<!-- commentaire -->
<div class="recette_comment">
	<?php if (isset($dVueAfficherRecette['recette']['commentaire'])) {?>
	<h3>Commentaires</h3>
	<p><?php echo $dVueAfficherRecette['recette']['commentaire']; ?></p>
	<?php } else { ?>
	<h3>Pas de commentaires</h3>
	<?php } ?>
</div>

<!-- details -->
<div class="recette_detail">
	<H3>Détails</H3>
	<ul>
		<li>
			<ul>
				<li>Auteur : <span><?php echo $dVueAfficherRecette['recette']['utilisateur']['login'].' ('.$dVueAfficherRecette['recette']['utilisateur']['prenom'].' '.$dVueAfficherRecette['recette']['utilisateur']['nom'].')'; ?></span></li>
				<li>Nombre de personnes : <span><?php echo $dVueAfficherRecette['recette']['nb_personne']; ?></span></li>
				<li>Temps de préparation : <span><?php echo isset($dVueAfficherRecette['recette']['temps_preparation']) ? $dVueAfficherRecette['recette']['temps_preparation'].' mn' : '-'; ?></span></li>
				<li>Temps de cuisson : <span><?php echo isset($dVueAfficherRecette['recette']['temps_cuisson']) ? $dVueAfficherRecette['recette']['temps_cuisson'].' mn' : '-'; ?></span></li>
			</ul>
		</li>
		
		<li>
			<ul>
				<li>Catégorie : <span><?php echo $dVueAfficherRecette['recette']['categorie']['intitule']; ?></span></li>
				<li>Sous catégorie : <span><?php echo $dVueAfficherRecette['recette']['sous_categorie']['intitule']; ?></span></li>
				<li>Difficulté : <span><?php echo $dVueAfficherRecette['recette']['categorie_difficulte']['intitule']; ?></span></li>
				<li>Prix : <span><?php echo $dVueAfficherRecette['recette']['categorie_prix']['intitule']; ?></span></li>
			</ul>
			<br clear="all" />
		</li>
	</ul>
</div>

<!-- ingredients -->
<div class="liste_recette">
	<H3>Ingrédient</H3>
	<ul>
		<?php foreach ($dVueAfficherRecette['recette']['ingredients'] as $ingr) { ?>
		<li><p><?php echo $ingr['texte_ingredient']; ?></p></li>
		<?php } ?>
	</ul>
</div>

<!-- preparation -->
<div class="liste_recette">
	<H3>Préparation</H3>
	<ul>
		<?php foreach ($dVueAfficherRecette['recette']['etape_preparations'] as $etape) { ?>
		<li><p><?php echo $etape['texte_etape']; ?></p></li>
		<?php } ?>
	</ul>
</div>

<!-- conseils -->
<div class="recette_comment">
	<?php if (isset($dVueAfficherRecette['recette']['conseil'])) {?>
	<h3>Conseils</h3>
	<p><?php echo $dVueAfficherRecette['recette']['conseil']; ?></p>
	<?php } else {?>
	<h3>Pas de conseils</h3>
	<?php } ?>
</div>

<!-- modifier recette -->
<?php if ($dVueAfficherRecette['identifie'] && ($dVueAfficherRecette['utilisateur']['id'] == $dVueAfficherRecette['recette']['utilisateur']['id'])) { ?>
<form method="post" action="" name="modifier_recette">
	<input type="hidden" name="page" id="page" value="modifier_recette" />
	<a href="javascript:document.modifier_recette.submit()">Modifier votre recette</a>
</form>
<?php } ?>
