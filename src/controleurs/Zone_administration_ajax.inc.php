<?php
try
{
	// controleur
	$donneesControleur['type'] = $_REQUEST['type'];
	if (isset($_REQUEST['data']))
		$donneesControleur['data'] = $_REQUEST['data'];
	
	
	// modele
	switch ($donneesControleur['type'])
	{
		// categories
		case 'categorie_list' :
		case 'sous_categorie_list' :
		case 'categorie_diff_list' :
		case 'categorie_prix_list' :
			include_once (dirname(__FILE__) . '/../modeles/za/Za_categorie_list.inc.php');
			break;
			
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
