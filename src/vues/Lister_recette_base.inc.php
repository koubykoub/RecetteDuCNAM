<?php
	include_once (dirname(__FILE__) . '/../librairies/html/HtmlStruct.class.php');
	
	// html
	HtmlStruct::DebutHtml($dVueTitre['head'], array('css/styles.css'), array('js/script.js'));
	
	
		// header
		HtmlStruct::DebutHeader();
			// logo
			HtmlStruct::DebutNav('section_logo');
				include (dirname(__FILE__) . '/commun/Logo.inc.php');
			HtmlStruct::FinNav();
				
			// en tete
			HtmlStruct::DebutSection('section_header');
				// titre
				HtmlStruct::Titre(1, $dVueTitre['body'], 'lister_recette_titre');
	
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
				// critere de recherche
				HtmlStruct::DebutArticle('critere_recherche');
					include (dirname(__FILE__) . '/commun/CritereRecherche.inc.php');
				HtmlStruct::FinArticle();
			
				// liste des recettes
				HtmlStruct::DebutArticle('lister_recette');
					include (dirname(__FILE__) . '/commun/ListerRecette.inc.php');
				HtmlStruct::FinArticle();
			
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
				include (dirname(__FILE__) . '/commun/LienRetourAccueil.inc.php');
			HtmlStruct::FinNav(true);
		HtmlStruct::FinFooter();
	
	
	// fin html
	HtmlStruct::FinHtml();
