<form method="post" action="" name="modifier_compte" enctype="multipart/form-data">
	<input type="hidden" name="page" id="page" value="<?php echo ($dVueCreerCompte['mise_a_jour'] ? 'afficher_compte' : 'creer_recette'); ?>" />
	<fieldset>
	<legend>Compte</legend>
	<ul>
		<!-- identifiant -->
		<li><label for="login">Indentifiant &nbsp;</label><input type="text" name="login" id="login" <?php if ($dVueCreerCompte['remplissage']){ echo 'value="'.$dVueCreerCompte['utilisateur']['login'].'"';} ?> /></li>
		
		<!-- mot de passe -->
		<?php if ($dVueCreerCompte['mise_a_jour']) { ?>
		<li><label for="mdp">Ancien mot de passe &nbsp;</label><input type="password" name="ancien_mdp" id="ancien_mdp" /></li>
		<li><label for="mdp">Nouveau mot de passe &nbsp;</label><input type="password" name="mdp" id="mdp" /></li>
		<li><label for="mdp2">Répéter le nouveau mot de passe &nbsp;</label><input type="password" name="mdp2" id="mdp2" /></li>
		<?php } else { ?>
		<li><label for="mdp">Mot de passe &nbsp;</label><input type="password" name="mdp" id="mdp" /></li>
		<li><label for="mdp2">Répéter le mot de passe &nbsp;</label><input type="password" name="mdp2" id="mdp2" /></li>
		<?php } ?>
		
		<!-- nom / prenom -->
		<li><label for="nom">Nom &nbsp;</label><input type="text" name="nom" id="nom" <?php if ($dVueCreerCompte['remplissage']){ echo 'value="'.$dVueCreerCompte['utilisateur']['nom'].'"';} ?> /></li>
		<li><label for="prenom">Prénom &nbsp;</label><input type="text" name="prenom" id="prenom" <?php if ($dVueCreerCompte['remplissage']){ echo 'value="'.$dVueCreerCompte['utilisateur']['prenom'].'"';} ?> /></li>
		
		<!-- email -->
		<li><label for="email_left">Email &nbsp;</label><input type="text" name="email_left" id="email_left" <?php if ($dVueCreerCompte['remplissage']){ echo 'value="'.$dVueCreerCompte['utilisateur']['email_left'].'"';} ?> /> @ <input type="text" name="email_right" id="email_right" <?php if ($dVueCreerCompte['remplissage']){ echo 'value="'.$dVueCreerCompte['utilisateur']['email_right'].'"';} ?> />
		
		<!-- photo -->
		<li>
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo IMAGE_UTILISATEUR_SIZE_MAX; ?>" />
			<label for="photo">Image &nbsp;</label><input type="file" name="photo" id="photo" accept="image/*" />
		</li>
		<?php if ($dVueCreerCompte['mise_a_jour'] && isset($dVueCreerCompte['utilisateur']['photo'])) { ?>
		<li><label for="effacer_image">Effacer l'image actuelle &nbsp;</label><input type="checkbox" name="effacer_image" id="effacer_image" value="true" /></li>
		<?php } ?>
		
	</ul>
	</fieldset>
	
	<?php if ($dVueCreerCompte['mise_a_jour']) { ?>
	<a href="javascript:document.modifier_compte.submit()">Modifier le compte</a>
	<?php } else { ?>
	<a href="javascript:document.modifier_compte.submit()">Créer le compte</a>
	<?php } ?>
</form>

<!-- annuler mise a jour -->
<form method="post" action="" name="annuler_mise_a_jour">
<?php if ($dVueCreerCompte['mise_a_jour']) { ?>
	<input type="hidden" name="page" id="page" value="afficher_compte" />
	<a href="javascript:document.annuler_mise_a_jour.submit()">Annuler la mise à jour</a>
<?php } else { ?>
	<input type="hidden" name="page" id="page" value="accueil" />
	<a href="javascript:document.annuler_mise_a_jour.submit()">Retour à l'accueil</a>
<?php } ?>
</form>
