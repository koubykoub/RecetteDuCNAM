<?php
	// include
	include_once (dirname(__FILE__) . '/../../librairies/dao/Connexion.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOCategorie.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOSous_categorie.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOCategorie_difficulte.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOCategorie_prix.class.php');

	// base de donnees
	$conn = new Connexion(SERVEUR, USER, PWD);
	$daoCat = new DAOCategorie($conn);
	
	switch ($donneesControleur['type'])
	{
	
		case 'categorie_list' :
			$daoCat = new DAOCategorie($conn);
			$donneesModele = $daoCat->RetrieveAll();
			break;
		case 'sous_categorie_list' :
			if (isset($donneesControleur['data']) && isset($donneesControleur['data']['id_categorie']))
			{
				$daoCat = new DAOSous_Categorie($conn);
				if ($donneesControleur['data']['id_categorie'] != 0)
					$donneesModele = $daoCat->RetrieveAllByCategorie($donneesControleur['data']['id_categorie']);
				else
					$donneesModele = $daoCat->RetrieveAll();
			}
			else
				$donneesModele = array();
			break;
		case 'categorie_diff_list' :
			$daoCat = new DAOCategorie_difficulte($conn);
			$donneesModele = $daoCat->RetrieveAll();
			break;
		case 'categorie_prix_list' :
			$daoCat = new DAOCategorie_prix($conn);
			$donneesModele = $daoCat->RetrieveAll();
			break;
		default :
			break;
	}
	