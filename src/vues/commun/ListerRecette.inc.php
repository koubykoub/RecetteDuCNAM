<h2>Liste des recettes</h2>

<!-- liste des recettes -->
<?php if (count($dVueListerRecette['liste_recettes']) == 0) { ?>
<h4>Aucune recette ne correspond aux critères de recherche</h4>
<?php } else { ?>
<ul>
	<?php foreach ($dVueListerRecette['liste_recettes'] as $recette) { ?>
		<li>
			<form method="post" action="" name="afficher_recette_<?php echo $recette['id']; ?>">
				<input type="hidden" name="page" id="page" value="afficher_recette" />
				<input type="hidden" name="id_recette" id="id_recette" value="<?php echo $recette['id']; ?>" />
				<a href="javascript:document.afficher_recette_<?php echo $recette['id']; ?>.submit()"><?php echo $recette['titre']; ?></a>
			</form>
		</li>
	<?php } ?>
</ul>

<!-- liens suivant / precedent -->
<?php if ($dVueListerRecette['liste_recettes_page'] > 0) { ?>
<form method="post" action="" name="lister_page_precedent">
	<input type="hidden" name="page" id="page" value="<?php echo $dVueListerRecette['page']; ?>" />
	<input type="hidden" name="lister_page_action" id="lister_page_action" value="precedent" />
	<a href="javascript:document.lister_page_precedent.submit()">Précédentes</a>
</form>
<?php } ?>

<?php if (!$dVueListerRecette['liste_recettes_last_page']) { ?>
<form method="post" action="" name="lister_page_suivant">
	<input type="hidden" name="page" id="page" value="<?php echo $dVueListerRecette['page']; ?>" />
	<input type="hidden" name="lister_page_action" id="lister_page_action" value="suivant" />
	<a href="javascript:document.lister_page_suivant.submit()">Suivantes</a>
</form>
<?php } ?>
	
<?php } ?>

<!-- revenir a la liste global -->
<?php if ($dVueListerRecette['lister_recette_utilisateur']) { ?>
<form method="post" action="" name="lister_recette_globale">
	<input type="hidden" name="page" id="page" value="lister_recette" />
	<a href="javascript:document.lister_recette_globale.submit()">Voir les recettes de tout le monde</a>
</form>
<?php } ?>
