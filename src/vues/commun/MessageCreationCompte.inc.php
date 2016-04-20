<!-- titre -->
<h2>Un compte a été créé :</h2>

<!-- donnees -->
<ul>
	<li>Identifiant : <span><?php echo $dVueMessage['utilisateur']['login']; ?></span></li>
	<li>Nom : <span><?php echo $dVueMessage['utilisateur']['nom']; ?></span></li>
	<li>Prenom : <span><?php echo $dVueMessage['utilisateur']['prenom']; ?></span></li>
	<?php if (!is_null($dVueMessage['utilisateur']['email'])) { ?>
		<li>Email : <span><?php echo $dVueMessage['utilisateur']['email']; ?></span></li>
	<?php } ?>
</ul>

<!-- lien compte -->
<form method="post" action="" name="mon_compte">
	<input type="hidden" name="page" id="page" value="afficher_compte" />
	<a href="javascript:document.mon_compte.submit()">Voir le compte en détail</a>
</form>
