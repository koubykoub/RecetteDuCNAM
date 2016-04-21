<?php if ($dVueLogin['identifie']) { ?>

<!-- titre -->
<h3>Bienvenue<br /><span><?php echo $dVueLogin['utilisateur']['prenom'].' '.$dVueLogin['utilisateur']['nom']; ?></span></h3>

<!-- liens utilisateurs -->
<!-- deconnexion -->
<form method="post" action="" name="deconnexion">
	<?php if ($dVueLogin['lister_recette_utilisateur']) { ?>
	<input type="hidden" name="page" id="page" value="lister_recette" />
	<?php } elseif ($dVueLogin['afficher_compte']) { ?>
	<input type="hidden" name="page" id="page" value="accueil" />
	<?php } else { ?>
	<input type="hidden" name="page" id="page" value="<?php echo $dVueLogin['page']; ?>" />
	<?php } ?>
	<input type="hidden" name="deconnexion" id="deconnexion" value="true" />
	<a href="javascript:document.deconnexion.submit()">Déconnexion</a>
</form>

<!-- compte -->
<form method="post" action="" name="afficher_compte">
	<input type="hidden" name="page" id="page" value="afficher_compte" />
	<a href="javascript:document.afficher_compte.submit()">Mon compte</a>
</form>

<!-- creer une recette -->
<form method="post" action="" name="creer_recette">
	<input type="hidden" name="page" id="page" value="creer_recette" />
	<a href="javascript:document.creer_recette.submit()">Créer une recette</a>
</form>

<!-- lister les recettes -->
<form method="post" action="" name="lister_recette_utilisateur">
	<input type="hidden" name="page" id="page" value="lister_recette_utilisateur" />
	<a href="javascript:document.lister_recette_utilisateur.submit()">Lister mes recettes</a>
</form>

<!-- zone administrateur -->
<?php if ($dVueLogin['utilisateur']['admin'] != 0) { ?>
<form method="post" action="" name="zone_administration">
	<input type="hidden" name="page" id="page" value="zone_administration" />
	<a href="javascript:document.zone_administration.submit()">Zone d'administration</a>
</form>
<?php } ?>

<?php } else { ?>

<!-- menu de login -->
<form method="post" action="" name="identifier_login">
	<input type="hidden" name="page" id="page" value="<?php echo $dVueLogin['page']; ?>" />
	<label for="login">Identifiant &nbsp;</label><input type="text" name="login" id="login" /><br />
	<label for="mdp">Mot de passe &nbsp;</label><input type="password" name="mdp" id="mdp" /><br />
	<a href="javascript:document.identifier_login.submit()">Identifiez vous</a>
</form>

<!-- creer compte -->
<form method="post" action="" name="creer_compte">
	<input type="hidden" name="page" id="page" value="creer_compte" />
	<a href="javascript:document.creer_compte.submit();">Créer un compte</a>
</form>

<?php } ?>
