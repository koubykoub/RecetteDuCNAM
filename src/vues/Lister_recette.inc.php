<?php
	// donnees de la vue
	// titre
	$dVueTitre['head'] = 'Liste des recettes';
	$dVueTitre['body'] = 'LISTE DES RECETTES';
	// menu critere
	$dVueMenuCritere['lister_recette_utilisateur'] = FALSE;
	$dVueMenuCritere['categories'] = $donneesModele['categories'];
	// login
	$dVueLogin['identifie'] = $donneesModele['identification']['identifie'];
	if ($dVueLogin['identifie']) $dVueLogin['utilisateur'] = $donneesModele['identification']['utilisateur'];
	$dVueLogin['lister_recette_utilisateur'] = FALSE;
	$dVueLogin['afficher_compte'] = FALSE;
	$dVueLogin['page'] = $donneesControleur['page'];
	// critere
	$dVueCritere = $donneesModele['critere'];
	// liste de recettes
	$dVueListerRecette['liste_recettes'] = $donneesModele['liste_recettes']['liste_recettes'];
	$dVueListerRecette['liste_recettes_page'] = $donneesModele['recette_page'];
	$dVueListerRecette['liste_recettes_last_page'] = $donneesModele['liste_recettes']['liste_recettes_last_page'];
	$dVueListerRecette['lister_recette_utilisateur'] = FALSE;
	$dVueListerRecette['page'] = $donneesControleur['page'];
	// random recette
	$dVueRandomRecette['recette_random'] = $donneesModele['recette_random'];
	
	// include
	include (dirname(__FILE__) . '/Lister_recette_base.inc.php');

?>
