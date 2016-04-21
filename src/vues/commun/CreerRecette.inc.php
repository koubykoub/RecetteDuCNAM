<!-- les sous categories -->
<?php
	foreach ($dVueCreerRecette['categories'] as $i => $cat)
		foreach ($cat['sous_categories'] as $j => $scat)
		{
?>
			<input type="hidden" id="<?php echo $cat['id']; ?>" value="<?php echo $scat['id']; ?>" name="<?php echo $scat['intitule']; ?>" />
<?php } ?>

<!-- titre -->
<?php if ($dVueCreerRecette['modifier_recette']) { ?>
<h2>Modifier une recette</h2>
<?php } else { ?>
<h2>Créer une recette</h2>
<?php } ?>

<!-- formulaire d'enregistrement de la recette -->
<form method="post" action="" name="modifier_recette" enctype="multipart/form-data">
	<!-- page -->
	<input type="hidden" id="page" name="page" value="afficher_recette" />
	
	<!-- recette -->
	<!-- titre -->
	<fieldset>
		<legend>Titre</legend>
		<input type="text" name="titre" id="titre" <?php if ($dVueCreerRecette['modifier_recette']) echo 'value="'.$dVueCreerRecette['recette']['titre'].'"'; ?> />
	</fieldset>
	
	<!-- photo -->
	<fieldset>
		<legend>Photo</legend>
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo IMAGE_RECETTE_SIZE_MAX; ?>" />
		<label for="photo">Image &nbsp;</label><input type="file" name="photo" id="photo" accept="image/*" />
		<?php if ($dVueCreerRecette['mise_a_jour'] && isset($dVueCreerRecette['recette']['photo'])) { ?>
		<br /><label for="effacer_image">Effacer l'image actuelle &nbsp;</label><input type="checkbox" name="effacer_image" id="effacer_image" value="true" />
		<?php } ?>
	</fieldset>
	
	<!-- commentaire -->
	<fieldset>
		<legend>Commentaires</legend>
		<textarea rows="4" cols="80" name="commentaire" id="commentaire"><?php if ($dVueCreerRecette['modifier_recette'] && isset($dVueCreerRecette['recette']['commentaire'])) echo $dVueCreerRecette['recette']['commentaire']; ?></textarea>
	</fieldset>
	
	<!-- details -->
	<fieldset class="recette_detail">
		<legend>Détails</legend>
		<ul>
			<li>
				<ul>
					<li>Auteur : <span><?php echo $dVueCreerRecette['utilisateur']['login'].' ('.$dVueCreerRecette['utilisateur']['prenom'].' '.$dVueCreerRecette['utilisateur']['nom'].')'; ?></span></li>
					<li>Nombre de personnes : <input type="number" value="<?php echo ($dVueCreerRecette['modifier_recette']) ? $dVueCreerRecette['recette']['nb_personne'] : '1'; ?>" id="nb_personne" name="nb_personne" /></li>
					<li>Temps de préparation : <input type="number" value="<?php echo ($dVueCreerRecette['modifier_recette'] && isset($dVueCreerRecette['recette']['temps_preparation'])) ? $dVueCreerRecette['recette']['temps_preparation'] : '0'; ?>" id="temps_preparation" name="temps_preparation" /> mn</li>
					<li>Temps de cuisson : <input type="number" value="<?php echo ($dVueCreerRecette['modifier_recette'] && isset($dVueCreerRecette['recette']['temps_cuisson'])) ? $dVueCreerRecette['recette']['temps_cuisson'] : '0'; ?>" id="temps_cuisson" name="temps_cuisson" /> mn</li>
				</ul>
			</li>
			
			<li>
				<ul>
					<li>
						Catégorie :
						<select id="categorie" name="categorie">
							<?php foreach ($dVueCreerRecette['categories'] as $i => $cat) { ?>
							<option <?php echo 'value="'.$cat['id'].'"'.(($i == $dVueCreerRecette['categorie_select']) ? ' selected="selected"' : ''); ?>><?php echo $cat['intitule']; ?></option>
							<?php }?>
						</select>
					</li>
					<li>
						Sous catégorie :
						<select id="sous_categorie" name="sous_categorie">
							<?php foreach ($dVueCreerRecette['categories'][$dVueCreerRecette['categorie_select']]['sous_categories'] as $i => $scat) { ?>
							<option <?php echo 'value="'.$scat['id'].'"'.(($i == $dVueCreerRecette['sous_categorie_select']) ? ' selected="selected"' : ''); ?>><?php echo $scat['intitule']; ?></option>
							<?php }?>
						</select>
					</li>
					<li>
						Difficulté :
						<select id="categorie_difficulte" name="categorie_difficulte">
							<?php foreach ($dVueCreerRecette['categories_difficulte'] as $i => $cat) { ?>
							<option <?php echo 'value="'.$cat['id'].'"'.(($i == $dVueCreerRecette['categorie_difficulte_select']) ? ' selected="selected"' : ''); ?>><?php echo $cat['intitule']; ?></option>
							<?php }?>
						</select>
					</li>
					<li>
						Prix :
						<select id="categorie_prix" name="categorie_prix">
							<?php foreach ($dVueCreerRecette['categories_prix'] as $i => $cat) { ?>
							<option <?php echo 'value="'.$cat['id'].'"'.(($i == $dVueCreerRecette['categorie_prix_select']) ? ' selected="selected"' : ''); ?>><?php echo $cat['intitule']; ?></option>
							<?php }?>
						</select>
					</li>
				</ul>
				<br clear="all" />
			</li>
		</ul>
	</fieldset>
	
	<!-- ingredients -->
	<fieldset>
		<legend>Ingrédient</legend>
		<ul id="ingredient">
			<?php if (!$dVueCreerRecette['modifier_recette']) { ?>
			<li><textarea rows="1" cols="75" name="ingredient_0" id="ingredient_0"></textarea></li>
			<?php } else { foreach ($dVueCreerRecette['recette']['ingredients'] as $i => $ingr) { ?>
			<li><textarea rows="1" cols="75" name="ingredient_<?php echo $i; ?>" id="ingredient_<?php echo $i; ?>"><?php echo $ingr['texte_ingredient']; ?></textarea></li>
			<?php }} ?>
			<li id="last_ingredient"><input type="button" value="+" /></li>
		</ul>
	</fieldset>
	
	<!-- preparation -->
	<fieldset>
		<legend>Préparation</legend>
		<ul id="etape_preparation">
			<?php if (!$dVueCreerRecette['modifier_recette']) { ?>
			<li><textarea rows="2" cols="75" name="etape_preparation_0" id="etape_preparation_0"></textarea></li>
			<?php } else { foreach ($dVueCreerRecette['recette']['etape_preparations'] as $i => $etape) { ?>
			<li><textarea rows="2" cols="75" name="etape_preparation_<?php echo $i; ?>" id="etape_preparation_<?php echo $i; ?>"><?php echo $etape['texte_etape']; ?></textarea></li>
			<?php }} ?>
			<li id="last_etape_preparation"><input type="button" value="+" /></li>
		</ul>
	</fieldset>
	
	<!-- conseils -->
	<fieldset>
		<legend>Conseils</legend>
		<textarea rows="4" cols="80" name="conseil" id="conseil"><?php if ($dVueCreerRecette['modifier_recette'] && isset($dVueCreerRecette['recette']['conseil'])) echo $dVueCreerRecette['recette']['conseil']; ?></textarea>
	</fieldset>
	
	<!-- submit -->
	<?php if ($dVueCreerRecette['mise_a_jour']) { ?>
	<a href="javascript:document.modifier_recette.submit()">Modifier la recette</a>
	<?php } else { ?>
	<a href="javascript:document.modifier_recette.submit()">Enregistrer la recette</a>
	<?php } ?>
</form>

<!-- annuler la mise a jour -->

<form method="post" action="" name="annuler_mise_a_jour">
<?php if ($dVueCreerRecette['mise_a_jour']) { ?>
	<input type="hidden" name="page" id="page" value="afficher_recette" />
	<a href="javascript:document.annuler_mise_a_jour.submit()">Annuler la mise à jour</a>
<?php } else { ?>
	<input type="hidden" name="page" id="page" value="accueil" />
	<a href="javascript:document.annuler_mise_a_jour.submit()">Revenir à l'accueil</a>
<?php } ?>
</form>
