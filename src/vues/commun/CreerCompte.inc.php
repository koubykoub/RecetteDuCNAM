<form method="post" action="" name="modifier_compte">
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
	</ul>
	</fieldset>
	
	<?php if ($dVueCreerCompte['mise_a_jour']) { ?>
	<a href="javascript:document.modifier_compte.submit()">Modifier le compte</a>
	<?php } else { ?>
	<a href="javascript:document.modifier_compte.submit()">Créer le compte</a>
	<?php } ?>
</form>
