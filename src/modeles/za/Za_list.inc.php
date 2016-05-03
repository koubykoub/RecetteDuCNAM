<?php
	// include
	include_once (dirname(__FILE__) . '/../../librairies/dao/Connexion.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOCategorie.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOSous_categorie.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOCategorie_difficulte.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOCategorie_prix.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOUtilisateur.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAORecette.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOCommentaire.class.php');

	// base de donnees
	$conn = new Connexion(SERVEUR, USER, PWD);
	
	switch ($donneesControleur['type'])
	{
		// categorie
		case 'categorie_list' :
			$daoCat = new DAOCategorie($conn);
			$donneesModele = $daoCat->RetrieveAll();
			break;
		
		// sous categorie
		case 'sous_categorie_list' :
			$daoCat = new DAOSous_Categorie($conn);
			if (isset($donneesControleur['data']['id_categorie']))
				$donneesModele = $daoCat->RetrieveAllByCategorie($donneesControleur['data']['id_categorie']);
			elseif (isset($donneesControleur['data']['empty']))
				$donneesModele = $daoCat->RetrieveAll();
			else
				$donneesModele = array();
			break;
			
		// categorie diff
		case 'categorie_diff_list' :
			$daoCat = new DAOCategorie_difficulte($conn);
			$donneesModele = $daoCat->RetrieveAll();
			break;
			
		// categorie prix
		case 'categorie_prix_list' :
			$daoCat = new DAOCategorie_prix($conn);
			$donneesModele = $daoCat->RetrieveAll();
			break;
			
		// utilisateur
		case 'utilisateur_list' :
			$daoUt = new DAOUtilisateur($conn);
			$donneesModele = $daoUt->RetrieveAll();
			break;
			
		// recette
		case 'recette_list' :
			$daoRec = new DAORecette($conn);
			$donneesModele = $daoRec->RetrieveAll();
			break;
			
		// commentaire
		case 'commentaire_list' :
			$daoCom = new DAOCommentaire($conn);
			$donneesModele = $daoCom->RetrieveAll();
			break;
			
		// ERREUR
		default :
			break;
	}
	