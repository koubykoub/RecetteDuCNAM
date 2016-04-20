<?php
	// donnees de la vue
	// titre
	$dVueTitre['head'] = 'Liste des recettes';
	$dVueTitre['body'] = 'LISTE DES RECETTES DE '.$donneesModele['identification']['utilisateur']['prenom'].' '.$donneesModele['identification']['utilisateur']['nom'].' ('.$donneesModele['identification']['utilisateur']['login'].')';
	// menu critere
	$dVueMenuCritere['lister_recette_utilisateur'] = TRUE;
	$dVueMenuCritere['categories'] = $donneesModele['categories'];
	// login
	$dVueLogin['identifie'] = TRUE;
	$dVueLogin['utilisateur'] = $donneesModele['identification']['utilisateur'];
	$dVueLogin['lister_recette_utilisateur'] = TRUE;
	$dVueLogin['afficher_compte'] = FALSE;
	$dVueLogin['page'] = $donneesControleur['page'];
	// critere
	$dVueCritere = $donneesModele['critere'];
	// liste de recettes
	$dVueListerRecette['liste_recettes'] = $donneesModele['liste_recettes']['liste_recettes'];
	$dVueListerRecette['liste_recettes_page'] = $donneesModele['recette_page'];
	$dVueListerRecette['liste_recettes_last_page'] = $donneesModele['liste_recettes']['liste_recettes_last_page'];
	$dVueListerRecette['lister_recette_utilisateur'] = TRUE;
	$dVueListerRecette['utilisateur'] = $donneesModele['identification']['utilisateur'];
	$dVueListerRecette['page'] = $donneesControleur['page'];
	// random recette
	$dVueRandomRecette['recette_random'] = $donneesModele['recette_random'];
	
	// include
	include (dirname(__FILE__) . '/Lister_recette_base.inc.php');

?>
