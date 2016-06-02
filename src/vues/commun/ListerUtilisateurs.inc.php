<h2>Lister les utilisateurs</h2>

<?php foreach ($dVueListeUtilisateurs as $ut) { ?>
	<form method="post" action="" name="compte_<?php echo $ut['login']; ?>">
		<input type="hidden" name="page" id="page" value="afficher_compte" />
		<a href="javascript:document.compte_<?php echo $ut['login']; ?>.submit()"><?php echo $ut['nom'].' '.$ut['prenom'].'('.$ut['login'].')'; ?></a>
	</form>
<?php } ?>