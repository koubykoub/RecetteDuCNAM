<?php
	// includes
	include_once (dirname(__FILE__) . '/commun/LoginControleur.class.php');
	include_once (dirname(__FILE__) . '/commun/RecetteControleur.class.php');
	include_once (dirname(__FILE__) . '/commun/CommentaireControleur.class.php');
	
	
	// donnees du controleur
	// login
	$donneesControleur['identification'] = LoginControleur::Identification();
	$donneesControleur['deconnexion'] = LoginControleur::Deconnexion();
	// recette
	$donneesControleur['recette'] = RecetteControleur::CreationRecette();
	if (!$donneesControleur['recette']['creation_recette']) $donneesControleur['id_recette'] = RecetteControleur::IdRecette();
	// commentaire
	$donneesControleur['commentaire'] = CommentaireControleur::Commentaire();
	$donneesControleur['detruire_commentaire'] = CommentaireControleur::DetruireCommentaire();
	
	
	// modele
	include_once (dirname(__FILE__) . '/../modeles/Afficher_recette.inc.php');
	
	// vue
	include_once (dirname(__FILE__) . '/../vues/Afficher_recette.inc.php');
