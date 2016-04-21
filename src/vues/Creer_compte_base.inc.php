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
				HtmlStruct::Titre(1, $dVueTitre['body']);
			HtmlStruct::FinSection(true);
		HtmlStruct::FinHeader();
		
		
		// section
		HtmlStruct::DebutSection();
			// creer compte
			HtmlStruct::DebutSection('section_principale_large');
				include (dirname(__FILE__) . '/commun/CreerCompte.inc.php');
			HtmlStruct::FinSection();
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
