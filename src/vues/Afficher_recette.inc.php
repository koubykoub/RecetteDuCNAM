<?php
	include_once (dirname(__FILE__) . '/../librairies/html/HtmlStruct.class.php');
	
	// donnees de la vue
	// menu critere
	$dVueMenuCritere['lister_recette_utilisateur'] = FALSE;
	$dVueMenuCritere['categories'] = $donneesModele['categories'];
	// login
	$dVueLogin['identifie'] = $donneesModele['identification']['identifie'];
	if ($dVueLogin['identifie']) $dVueLogin['utilisateur'] = $donneesModele['identification']['utilisateur'];
	$dVueLogin['lister_recette_utilisateur'] = FALSE;
	$dVueLogin['afficher_compte'] = FALSE;
	$dVueLogin['page'] = $donneesControleur['page'];
	// message
	$dVueMessage['creation_recette'] = FALSE;
	if ($donneesModele['creation_recette'])
	{
		$dVueMessage['creation_recette'] = TRUE;
		$dVueMessage['modification_recette'] = $donneesModele['modification_recette'];
		$dVueMessage['utilisateur'] = $donneesModele['identification']['utilisateur'];
		$dVueMessage['recette'] = $donneesModele['recette'];
	};
	// recette
	$dVueAfficherRecette['recette'] = $donneesModele['recette'];
	$dVueAfficherRecette['identifie'] = $donneesModele['identification']['identifie'];
	if ($dVueAfficherRecette['identifie']) $dVueAfficherRecette['utilisateur'] = $donneesModele['identification']['utilisateur'];
	// commentaires
	$dVueCommentaire['identifie'] = $donneesModele['identification']['identifie'];
	$dVueCommentaire['commentaires'] = $donneesModele['commentaires'];
	if (count($donneesModele['commentaires']) != 0) $dVueCommentaire['statistique_recette'] = $donneesModele['statistique_recette'];
	$dVueCommentaire['utilisateur_recette'] = FALSE;
	if ($donneesModele['identification']['identifie'])
	{
		$dVueCommentaire['detruire_commentaire'] = $donneesModele['detruire_commentaire'];
		$dVueCommentaire['utilisateur_recette'] = ($donneesModele['identification']['utilisateur']['id'] == $donneesModele['recette']['id_utilisateur']);
		if (!$donneesModele['detruire_commentaire'])	
			$dVueCommentaire['commentaire_utilisateur'] = $donneesModele['commentaire_utilisateur'];
	}
	$dVueCommentaire['remplissage'] = $donneesModele['identification']['identifie'] && !$donneesModele['detruire_commentaire'] && $donneesModele['commentaire_utilisateur']['existe'];
	
	// html
	HtmlStruct::DebutHtml('Afficher une recette', array('css/styles.css'), array('js/script.js'));
	
	
		// header
		HtmlStruct::DebutHeader();
			// logo
			HtmlStruct::DebutNav('section_logo');
				include (dirname(__FILE__) . '/commun/Logo.inc.php');
			HtmlStruct::FinNav();
				
			// en tete
			HtmlStruct::DebutSection('section_header');
				// titre
				HtmlStruct::Titre(1, 'RECETTE');
	
				// menu
				HtmlStruct::DebutNav('menu_critere');
					include (dirname(__FILE__) . '/commun/MenuCritere.inc.php');
				HtmlStruct::FinNav();
			HtmlStruct::FinSection(true);
		HtmlStruct::FinHeader();
		
		
		// section
		HtmlStruct::DebutSection();
			// login
			HtmlStruct::DebutSection('section_login');
				include (dirname(__FILE__) . '/commun/Login.inc.php'); 
			HtmlStruct::FinSection();
		
			// section
			HtmlStruct::DebutSection('section_principale');
				// message de creation de recette
				if ($dVueMessage['creation_recette'])
				{
					HtmlStruct::DebutArticle('section_message');
						include (dirname(__FILE__) . '/commun/MessageCreationRecette.inc.php');
					HtmlStruct::FinArticle();
				}
			
				// afficher recette
				HtmlStruct::DebutArticle('random_recette');
					include (dirname(__FILE__) . '/commun/AfficherRecette.inc.php');
				HtmlStruct::FinArticle();
				
				// afficher commentaires
				HtmlStruct::DebutArticle('random_recette');
					include (dirname(__FILE__) . '/commun/Commentaire.inc.php');
				HtmlStruct::FinArticle();
			HtmlStruct::FinSection(true);
		HtmlStruct::FinSection();
		
		
		// footer
		HtmlStruct::DebutFooter();
			// copyright
			HtmlStruct::DebutArticle('footer_copyright');
				include (dirname(__FILE__) . '/commun/Copyright.inc.php');
			HtmlStruct::FinArticle();
			
			// lien recette
			HtmlStruct::DebutNav('footer_nav');
				include (dirname(__FILE__) . '/commun/LienRetourAccueil.inc.php');
			HtmlStruct::FinNav(true);
		HtmlStruct::FinFooter();
	
	
	// fin html
	HtmlStruct::FinHtml();
