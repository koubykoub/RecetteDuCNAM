<!-- categorie -->
<h2>Catégories et sous catégories</h2>
<?php foreach ($dVueGererCategories['categories'] as $nCat => $cat) { ?>
	
	<!-- inputs categorie -->
	<form method="post" action="">
		<input type="hidden" name="page" id="page" value="gerer_categorie" />
		<input type="hidden" name="action" id="action" value="modifier" />
		<input type="hidden" name="type_categorie" id="type_categorie" value="categorie" />
		<input type="hidden" name="id_categorie" id="id_categorie" value="<?php echo $cat['id']; ?>" />
		<input type="text" name="intitule" id="intitule" value="<?php echo $cat['intitule']; ?>" />
		<input type="submit" value="Modifier" />
	</form>
	<?php if ($nCat > 0) { ?>
	<form method="post" action="">
		<input type="hidden" name="page" id="page" value="gerer_categorie" />
		<input type="hidden" name="action" id="action" value="supprimer" />
		<input type="hidden" name="type_categorie" id="type_categorie" value="categorie" />
		<input type="hidden" name="id_categorie" id="id_categorie" value="<?php echo $cat['id']; ?>" />
		<input type="submit" value="Supprimer" />
	</form>
	<?php } ?>
	<br />
	
	<!-- sous categorie -->
	<?php foreach ($cat['sous_categories'] as $nScat => $scat) { ?>
	
		<!-- inputs sous categorie -->
		<form method="post" action="">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="hidden" name="page" id="page" value="gerer_categorie" />
			<input type="hidden" name="action" id="action" value="modifier" />
			<input type="hidden" name="type_categorie" id="type_categorie" value="sous_categorie" />
			<input type="hidden" name="id_categorie" id="id_categorie" value="<?php echo $cat['id']; ?>" />
			<input type="hidden" name="id_sous_categorie" id="id_sous_categorie" value="<?php echo $scat['id']; ?>" />
			<input type="text" name="intitule" id="intitule" value="<?php echo $scat['intitule']; ?>" />
			<input type="submit" value="Modifier" />
		</form>
		<?php if ($nScat > 0) { ?>
		<form method="post" action="">
			<input type="hidden" name="page" id="page" value="gerer_categorie" />
			<input type="hidden" name="action" id="action" value="supprimer" />
			<input type="hidden" name="type_categorie" id="type_categorie" value="sous_categorie" />
			<input type="hidden" name="id_categorie" id="id_categorie" value="<?php echo $cat['id']; ?>" />
			<input type="hidden" name="id_sous_categorie" id="id_sous_categorie" value="<?php echo $scat['id']; ?>" />
			<input type="submit" value="Supprimer" />
		</form>
		<?php } ?>
		<br />
		
	<?php } ?>
	
	<form method="post" action="">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="hidden" name="page" id="page" value="gerer_categorie" />
		<input type="hidden" name="action" id="action" value="ajouter" />
		<input type="hidden" name="type_categorie" id="type_categorie" value="sous_categorie" />
		<input type="hidden" name="id_categorie" id="id_categorie" value="<?php echo $cat['id']; ?>" />
		<input type="text" name="intitule" id="intitule" />
		<input type="submit" value="Ajouter" />
	</form>
	<br />
<?php } ?>
<form method="post" action="">
	<input type="hidden" name="page" id="page" value="gerer_categorie" />
	<input type="hidden" name="action" id="action" value="ajouter" />
	<input type="hidden" name="type_categorie" id="type_categorie" value="categorie" />
	<input type="text" name="intitule" id="intitule" />
	<input type="submit" value="Ajouter" />
</form>
<br /><br />

<!-- categorie prix -->
<h2>Catégories de prix</h2>
<?php foreach ($dVueGererCategories['categories_prix'] as $nCat => $cat) { ?>
	
	<!-- inputs categorie -->
	<form method="post" action="">
		<input type="hidden" name="page" id="page" value="gerer_categorie" />
		<input type="hidden" name="action" id="action" value="modifier" />
		<input type="hidden" name="type_categorie" id="type_categorie" value="categorie_prix" />
		<input type="hidden" name="id_categorie" id="id_categorie" value="<?php echo $cat['id']; ?>" />
		<input type="text" name="intitule" id="intitule" value="<?php echo $cat['intitule']; ?>" />
		<input type="submit" value="Modifier" />
	</form>
	<?php if ($nCat > 0) { ?>
	<form method="post" action="">
		<input type="hidden" name="page" id="page" value="gerer_categorie" />
		<input type="hidden" name="action" id="action" value="supprimer" />
		<input type="hidden" name="type_categorie" id="type_categorie" value="categorie_prix" />
		<input type="hidden" name="id_categorie" id="id_categorie" value="<?php echo $cat['id']; ?>" />
		<input type="submit" value="Supprimer" />
	</form>
	<?php } ?>
	<br />
	
<?php } ?>
<form method="post" action="">
	<input type="hidden" name="page" id="page" value="gerer_categorie" />
	<input type="hidden" name="action" id="action" value="ajouter" />
	<input type="hidden" name="type_categorie" id="type_categorie" value="categorie_prix" />
	<input type="text" name="intitule" id="intitule" />
	<input type="submit" value="Ajouter" />
</form>
<br /><br />

<!-- categorie difficulte -->
<h2>Catégories de difficulté</h2>
<?php foreach ($dVueGererCategories['categories_difficulte'] as $nCat => $cat) { ?>
	
	<!-- inputs categorie -->
	<form method="post" action="">
		<input type="hidden" name="page" id="page" value="gerer_categorie" />
		<input type="hidden" name="action" id="action" value="modifier" />
		<input type="hidden" name="type_categorie" id="type_categorie" value="categorie_difficulte" />
		<input type="hidden" name="id_categorie" id="id_categorie" value="<?php echo $cat['id']; ?>" />
		<input type="text" name="intitule" id="intitule" value="<?php echo $cat['intitule']; ?>" />
		<input type="submit" value="Modifier" />
	</form>
	<?php if ($nCat > 0) { ?>
	<form method="post" action="">
		<input type="hidden" name="page" id="page" value="gerer_categorie" />
		<input type="hidden" name="action" id="action" value="supprimer" />
		<input type="hidden" name="type_categorie" id="type_categorie" value="categorie_difficulte" />
		<input type="hidden" name="id_categorie" id="id_categorie" value="<?php echo $cat['id']; ?>" />
		<input type="submit" value="Supprimer" />
	</form>
	<?php } ?>
	<br />
	
<?php } ?>
<form method="post" action="">
	<input type="hidden" name="page" id="page" value="gerer_categorie" />
	<input type="hidden" name="action" id="action" value="ajouter" />
	<input type="hidden" name="type_categorie" id="type_categorie" value="categorie_difficulte" />
	<input type="text" name="intitule" id="intitule" />
	<input type="submit" value="Ajouter" />
</form>
<br /><br />
