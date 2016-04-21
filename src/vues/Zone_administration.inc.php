<?php
	include_once (dirname(__FILE__) . '/../librairies/html/HtmlStruct.class.php');
	
	// html
	HtmlStruct::DebutHtml('Zone d\'administration', array('css/styles.css'), array('js/script.js'));
	
	
		// header
		HtmlStruct::DebutHeader();
			// logo
			HtmlStruct::DebutNav('section_logo');
				include (dirname(__FILE__) . '/commun/Logo.inc.php');
			HtmlStruct::FinNav();
				
			// en tete
			HtmlStruct::DebutSection('section_header');
				// titre
				HtmlStruct::Titre(1, 'ZONE D\'ADMINISTRATION');
			HtmlStruct::FinSection(true);
		HtmlStruct::FinHeader();
		
		
		// section
		HtmlStruct::DebutSection();
			// zone d'administration
			HtmlStruct::DebutSection('section_principale_large');
				include (dirname(__FILE__) . '/commun/ZoneAdministration.inc.php');
			HtmlStruct::FinSection();
		HtmlStruct::FinSection();
		
		
		// footer
		HtmlStruct::DebutFooter();
			// lien accueil
			HtmlStruct::DebutNav('footer_nav');
				include (dirname(__FILE__) . '/commun/LienRetourAccueil.inc.php');
			HtmlStruct::FinNav(true);
		HtmlStruct::FinFooter();
	
	
	// fin html
	HtmlStruct::FinHtml();
