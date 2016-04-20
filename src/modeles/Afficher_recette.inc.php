<?php
	// include
	include_once (dirname(__FILE__) . '/../librairies/dao/Connexion.class.php');
	include_once (dirname(__FILE__) . '/commun/LoginModele.class.php');
	include_once (dirname(__FILE__) . '/commun/CritereModele.class.php');
	include_once (dirname(__FILE__) . '/commun/RecetteModele.class.php');
	include_once (dirname(__FILE__) . '/commun/CommentaireModele.class.php');
	
	
	// connexion a la base de donnee
	$conn = new Connexion(SERVEUR, USER, PWD);
	ModeleBase::SetConnexion($conn);
	
	
	// donnees du modele
	// login
	if ($donneesControleur['deconnexion']) $donneesModele['identification'] = LoginModele::Deconnexion();
	else $donneesModele['identification'] = LoginModele::Identification($donneesControleur['identification']);
	// categories / sous categories
	$donneesModele['categories'] = CritereModele::Categories();
	// recette
	$donneesModele['creation_recette'] = FALSE;
	if ($donneesControleur['recette']['creation_recette'])
	{
		$donneesModele['creation_recette'] = TRUE;
		$donneesModele['modification_recette'] = FALSE;
		// modification recette
		if (RecetteModele::IsPrevModifierRecette())
		{
			$recette = RecetteModele::RecetteSession();
			$donneesModele['recette'] = RecetteModele::ModificationRecette($donneesControleur['recette'], $recette['id']);
			$donneesModele['modification_recette'] = TRUE;
		}
		// creation recette
		else $donneesModele['recette'] = RecetteModele::CreationRecette($donneesControleur['recette']);
	}
	elseif($donneesControleur['id_recette'] != 0) $donneesModele['recette'] = RecetteModele::Recette($donneesControleur['id_recette']);
	else $donneesModele['recette'] = RecetteModele::RecetteSession();
	// commentaires
	if ($donneesModele['identification']['identifie'])
	{
		$donneesModele['detruire_commentaire'] = FALSE;
		if ($donneesControleur['detruire_commentaire'])
		{
			CommentaireModele::DetruireCommentaire($donneesModele['identification']['utilisateur']['id'], $donneesModele['recette']['id']);
			$donneesModele['detruire_commentaire'] = TRUE;
		}
		else
		{
			if ($donneesControleur['commentaire']['creer_commentaire']) CommentaireModele::CreerCommentaire($donneesControleur['commentaire'], $donneesModele['identification']['utilisateur']['id'], $donneesModele['recette']['id']);
			$donneesModele['commentaire_utilisateur'] = CommentaireModele::SessionCommentaireCreation($donneesModele['identification']['utilisateur']['id'], $donneesModele['recette']['id']);
			if (!$donneesModele['commentaire_utilisateur']['existe'])
				$donneesModele['commentaire_utilisateur'] = CommentaireModele::CommentaireUtilisateur($donneesModele['identification']['utilisateur']['id'], $donneesModele['recette']['id']);
		}
	}
	$donneesModele['commentaires'] = CommentaireModele::CommentaireRecette($donneesModele['recette']['id']);
	if (count($donneesModele['commentaires']) != 0) $donneesModele['statistique_recette'] = CommentaireModele::StatistiqueRecette($donneesModele['recette']['id']);
