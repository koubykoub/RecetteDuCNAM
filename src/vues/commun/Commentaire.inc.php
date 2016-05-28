<!-- titre -->
<h2>Commentaires</h2>

<!-- creation d'un commentaire -->
<?php if ($dVueCommentaire['identifie'] && !$dVueCommentaire['utilisateur_recette']) { ?>
<form method="post" name="creer_commentaire" action="">
	<!-- page -->
	<input type="hidden" id="page" name="page" value="afficher_recette" />
	
	<!-- note -->
	<fieldset>
		<legend>Note</legend>
		<?php if ($dVueCommentaire['remplissage']) { ?>
			<?php for ($i = 0 ; $i <= COMM_NOTE_MAX ; ++$i) { ?>
			<input type="radio" name="commentaire_note" id="commentaire_note" value="<?php echo $i; ?>"<?php if ($dVueCommentaire['commentaire_utilisateur']['commentaire']['valeur_note'] == $i) echo 'checked="checked"'; ?> />
			<?php } ?>
		<?php } else { ?>
			<?php for ($i = 0 ; $i <= COMM_NOTE_MAX ; ++$i) { ?>
			<input type="radio" name="commentaire_note" id="commentaire_note" value="<?php echo $i; ?>"<?php if ($i == 3) echo 'checked="checked"'; ?> />
			<?php } ?>
		<?php } ?>
	</fieldset>
	
	<!-- commentaire -->
	<fieldset>
		<legend>Commentaire</legend>
		<textarea rows="4" cols="80" name="commentaire_texte" id="commentaire_texte"><?php if ($dVueCommentaire['remplissage']) echo $dVueCommentaire['commentaire_utilisateur']['commentaire']['texte_commentaire']; ?></textarea>
	</fieldset>
	
	<!-- creer commentaire -->
	<a href="javascript:document.creer_commentaire.submit()"><?php if (!$dVueCommentaire['detruire_commentaire'] && $dVueCommentaire['commentaire_utilisateur']['existe']) echo 'Modifier le commentaire'; else echo 'Commenter la recette'; ?></a>
</form>
<?php } ?>

<!-- detruire commentaire -->
<?php if ($dVueCommentaire['identifie'] && !$dVueCommentaire['detruire_commentaire'] && $dVueCommentaire['commentaire_utilisateur']['existe']) { ?>
<form method="post" name="detruire_commentaire" action="">
	<input type="hidden" id="page" name="page" value="afficher_recette" />
	<input type="hidden" id="detruire_commentaire" name="detruire_commentaire" value="true" />
	<a href="javascript:document.detruire_commentaire.submit()">Effacer le commentaire</a>
</form>
<?php } ?>

<!-- affichage des commentaires -->
<?php if (count($dVueCommentaire['commentaires']) == 0) { ?>
<p>Il n'y a pas de commentaires pour cette recette</p>
<?php } else { ?>
<!-- statistique -->
<p>
	<label>nombre de commentaires : </label><span><?php echo $dVueCommentaire['statistique_recette']['nb_note']; ?></span><br />
	<label>Moyenne des notes : </label><span><?php echo $dVueCommentaire['statistique_recette']['moyenne_note']; ?> / 5</span>
</p>

<!-- commentaires -->
<ul>
	<?php foreach ($dVueCommentaire['commentaires'] as $comm) { ?>
	<li>
	<label>auteur : </label><span><?php echo $comm['utilisateur']['login']; ?></span><br />
	<label>note : </label><span><?php echo $comm['valeur_note']; ?></span><br />
	<p><?php echo $comm['texte_commentaire']; ?></p>
	</li>
	<?php } ?>
</ul>
<?php } ?>
