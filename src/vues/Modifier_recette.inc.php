<?php
	include_once (dirname(__FILE__) . '/../librairies/html/HtmlStruct.class.php');
	include_once (dirname(__FILE__) . '/commun/VueUtil.php');
	
	// donnees de la vue
	// titre
	$dVueTitre['head'] = "Mofifier une recette";
	$dVueTitre['body'] = "MODIFICATION D'UNE RECETTE DE ".$donneesModele['identification']['utilisateur']['login'];
	// message
	$dVueMessage['creation_compte'] = FALSE;
	// creer recette
	// categories
	$dVueCreerRecette['categories'] = $donneesModele['categories'];
	$dVueCreerRecette['categories_difficulte'] = $donneesModele['categories_difficulte'];
	$dVueCreerRecette['categories_prix'] = $donneesModele['categories_prix'];
	// utilisateur
	$dVueCreerRecette['utilisateur'] = $donneesModele['identification']['utilisateur'];
	// donnees dans la vue
	$dVueCreerRecette['modifier_recette'] = TRUE;
	$dVueCreerRecette['mise_a_jour'] = TRUE;
	$dVueCreerRecette['recette'] = $donneesModele['recette'];
	// selection des categories
	$tmpCats = BindGoodCategories($donneesModele['categories'], $donneesModele['categories_difficulte'], $donneesModele['categories_prix'], $donneesModele['recette']);
	$dVueCreerRecette['categorie_select'] = $tmpCats['categorie_select'];
	$dVueCreerRecette['sous_categorie_select'] = $tmpCats['sous_categorie_select'];
	$dVueCreerRecette['categorie_difficulte_select'] = $tmpCats['categorie_difficulte_select'];
	$dVueCreerRecette['categorie_prix_select'] = $tmpCats['categorie_prix_select'];
	
	// include
	include (dirname(__FILE__) . '/Creer_recette_base.inc.php');
