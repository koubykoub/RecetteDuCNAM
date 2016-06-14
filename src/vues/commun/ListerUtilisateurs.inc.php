<h2>Lister les utilisateurs</h2>

<?php foreach ($dVueListeUtilisateurs as $ut) { ?>
	<form method="post" action="" name="compte_<?php echo $ut['login']; ?>">
		<input type="hidden" name="page" id="page" value="afficher_compte" />
		<input type="hidden" name="lister_utilisateur" id="lister_utilisateur" value="true" />
		<input type="hidden" name="id_utilisateur" id="id_utilisateur" value="<?php echo $ut['id']; ?>" />
		<a href="javascript:document.compte_<?php echo $ut['login']; ?>.submit()"><?php echo $ut['nom'].' '.$ut['prenom'].'('.$ut['login'].')'; ?></a>
	</form>
<?php } ?>