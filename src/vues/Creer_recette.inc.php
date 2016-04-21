<?php
	include_once (dirname(__FILE__) . '/../librairies/html/HtmlStruct.class.php');
	include_once (dirname(__FILE__) . '/commun/VueUtil.php');
	
	// donnees de la vue
	// titre
	$dVueTitre['head'] = "Créer une recette";
	$dVueTitre['body'] = "CREATION D'UNE RECETTE";
	// message
	$dVueMessage['creation_compte'] = $donneesModele['creation_compte'];
	if ($dVueMessage['creation_compte']) $dVueMessage['utilisateur'] = $donneesModele['identification']['utilisateur'];
	// creer recette
	// categories
	$dVueCreerRecette['categories'] = $donneesModele['categories'];
	$dVueCreerRecette['categories_difficulte'] = $donneesModele['categories_difficulte'];
	$dVueCreerRecette['categories_prix'] = $donneesModele['categories_prix'];
	// utilisateur
	$dVueCreerRecette['utilisateur'] = $donneesModele['identification']['utilisateur'];
	// donnees dans la vue
	$dVueCreerRecette['modifier_recette'] = FALSE;
	$dVueCreerRecette['mise_a_jour'] = FALSE;
	// recette
	if ($donneesModele['recette_en_creation']['existe'])
	{
		$dVueCreerRecette['recette'] = $donneesModele['recette_en_creation']['recette'];
		FB::log(json_encode($donneesModele['recette_en_creation']['recette']));
		FB::log(json_encode($dVueCreerRecette['recette']));
		$dVueCreerRecette['modifier_recette'] = TRUE;
		// selection des categories
		$tmpCats = BindGoodCategories($donneesModele['categories'], $donneesModele['categories_difficulte'], $donneesModele['categories_prix'], $donneesModele['recette_en_creation']['recette']);
		$dVueCreerRecette['categorie_select'] = $tmpCats['categorie_select'];
		$dVueCreerRecette['sous_categorie_select'] = $tmpCats['sous_categorie_select'];
		$dVueCreerRecette['categorie_difficulte_select'] = $tmpCats['categorie_difficulte_select'];
		$dVueCreerRecette['categorie_prix_select'] = $tmpCats['categorie_prix_select'];
	}
	else
	{
		// selection des categories
		$dVueCreerRecette['categorie_select'] = 0;
		$dVueCreerRecette['sous_categorie_select'] = 0;
		$dVueCreerRecette['categorie_difficulte_select'] = 0;
		$dVueCreerRecette['categorie_prix_select'] = 0;
	}
	
	// include
	include (dirname(__FILE__) . '/Creer_recette_base.inc.php');
