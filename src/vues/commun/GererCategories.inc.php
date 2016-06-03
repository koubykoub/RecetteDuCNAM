<!-- categorie -->
<?php foreach ($dVueGererCategories['categories'] as $cat) { ?>
	
	<!-- inputs categorie -->
	<?php echo $cat['intitule']; ?> <br />
	
	<!-- sous categorie -->
	<?php foreach ($cat['sous_categories'] as $scat) { ?>
	
		<!-- inputs sous categori -->
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $scat['intitule']; ?> <br />
		
	<?php } ?>
<?php } ?>
<br /><br />

<!-- categorie prix -->
<?php foreach ($dVueGererCategories['categories_prix'] as $cat) { ?>
	
	<!-- inputs categorie -->
	<?php echo $cat['intitule']; ?> <br />
	
<?php } ?>
<br /><br />

<!-- categorie difficulte -->
<?php foreach ($dVueGererCategories['categories_difficulte'] as $cat) { ?>
	
	<!-- inputs categorie -->
	<?php echo $cat['intitule']; ?> <br />
	
<?php } ?>
<br /><br />
