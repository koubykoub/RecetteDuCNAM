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
	// random recette
	$dVueRandomRecette['recette_random'] = $donneesModele['recette_random'];
	// message
	$dVueMessage['destruction_recette'] = $donneesModele['detruire_recette'];
	if ($donneesModele['detruire_recette']) $dVueMessage['destruction_recette_succes'] = $donneesModele['detruire_recette_succes'];
	$dVueMessage['destruction_compte'] = $donneesModele['detruire_compte'];
	if ($donneesModele['detruire_compte']) $dVueMessage['destruction_compte_succes'] = $donneesModele['detruire_compte_succes'];
	
	// html
	HtmlStruct::DebutHtml('Accueil', array('css/styles.css'), array('js/script.js'));
	
	
		// header
		HtmlStruct::DebutHeader();
			// logo
			HtmlStruct::DebutNav('section_logo');
				include (dirname(__FILE__) . '/commun/Logo.inc.php');
			HtmlStruct::FinNav();
				
			// en tete
			HtmlStruct::DebutSection('section_header');
				// titre
				HtmlStruct::Titre(1, 'ACCUEIL', 'accueil_titre');
	
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
				// message de destruction de recette
				if ($dVueMessage['destruction_recette'])
				{
					HtmlStruct::DebutArticle('section_message');
						include (dirname(__FILE__) . '/commun/MessageDestructionRecette.inc.php');
					HtmlStruct::FinArticle();
				}
				
				// message de destruction de compte
				if ($dVueMessage['destruction_compte'])
				{
					HtmlStruct::DebutArticle('section_message');
						include (dirname(__FILE__) . '/commun/MessageDestructionCompte.inc.php');
					HtmlStruct::FinArticle();
				}
			
				// recette au hasard
				HtmlStruct::DebutArticle('random_recette');
					include (dirname(__FILE__) . '/commun/RandomRecette.inc.php');
				HtmlStruct::FinArticle();
			HtmlStruct::FinSection(true);
		HtmlStruct::FinSection();
		
		
		// footer
		HtmlStruct::DebutFooter();
			// lien recette
			HtmlStruct::DebutNav('footer_nav');
				include (dirname(__FILE__) . '/commun/LienRandomRecette.inc.php');
			HtmlStruct::FinNav(true);
		HtmlStruct::FinFooter();
	
	
	// fin html
	HtmlStruct::FinHtml();
