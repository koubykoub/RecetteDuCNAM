<?php
try
{
	// controleur
	$donneesControleur['type'] = $_REQUEST['type'];
	if (isset($_REQUEST['data']))
		$donneesControleur['data'] = $_REQUEST['data'];
	else
		$donneesControleur['data'] = array();
	
	// modele
	switch ($donneesControleur['type'])
	{
		// liste en json
		case 'categorie_list' :
		case 'sous_categorie_list' :
		case 'categorie_diff_list' :
		case 'categorie_prix_list' :
		case 'utilisateur_list' :
		case 'recette_list' :
		case 'commentaire_list' :
			include_once (dirname(__FILE__) . '/../modeles/za/Za_list.inc.php');
			break;
			
		// ERREUR
		default :
			throw new Exception('Erreur');
			break;
	}
	
	// vue
	$donneesVue = json_encode($donneesModele);
	include_once (dirname(__FILE__) . '/../vues/commun/za/ZaJson.inc.php');
}

catch (Exception $e)
{
	header("HTTP/1.1 401 Unauthorized" );
	exit;
}
