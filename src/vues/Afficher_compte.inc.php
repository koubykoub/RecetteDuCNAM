<?php
	include_once (dirname(__FILE__) . '/../librairies/html/HtmlStruct.class.php');
	
	// donnees de la vue
	// menu critere
	$dVueMenuCritere['lister_recette_utilisateur'] = FALSE;
	$dVueMenuCritere['categories'] = $donneesModele['categories'];
	// login
	$dVueLogin['identifie'] = TRUE;
	$dVueLogin['utilisateur'] = $donneesModele['identification']['utilisateur'];
	$dVueLogin['lister_recette_utilisateur'] = FALSE;
	$dVueLogin['afficher_compte'] = TRUE;
	$dVueLogin['page'] = $donneesControleur['page'];
	// message
	$dVueMessage['creation_compte'] = $donneesModele['creation_compte'];
	// compte
	$dVueAfficherCompte = $donneesModele['identification']['utilisateur'];
	
	// html
	HtmlStruct::DebutHtml('Afficher compte', array('css/styles.css'), array('js/script.js'));
	
	
		// header
		HtmlStruct::DebutHeader();
			// logo
			HtmlStruct::DebutNav('section_logo');
				include (dirname(__FILE__) . '/commun/Logo.inc.php');
			HtmlStruct::FinNav();
				
			// en tete
			HtmlStruct::DebutSection('section_header');
				// titre
				HtmlStruct::Titre(1, 'AFFICHER MON COMPTE');
	
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
				if ($dVueMessage['creation_compte'])
				{
					HtmlStruct::DebutArticle('section_message');
						include (dirname(__FILE__) . '/commun/MessageModificationCompte.inc.php');
					HtmlStruct::FinArticle();
				}
			
				// afficher compte
				HtmlStruct::DebutArticle('afficher_compte');
					include (dirname(__FILE__) . '/commun/AfficherCompte.inc.php');
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
	
?>
