<?php
	// include
	include_once (dirname(__FILE__) . '/src/librairies/define/Define.inc.php');
	include_once (dirname(__FILE__) . '/src/librairies/exception/RequeteException.class.php');
	include_once (dirname(__FILE__) . '/src/librairies/fb/fb.php');
	

	try
	{
		// php info
		//phpinfo();
		//die();
		
		// destroy session
		//session_start();
		//session_destroy();
		
		
		// choix de la page
		if (isset($_REQUEST['page']))
			$donneesControleur['page'] = $_REQUEST['page'];
		else
			$donneesControleur['page'] = 'accueil';
		//FB::log('page : ' . $donneesControleur['page']);

		
		switch ($donneesControleur['page'])
		{
			// accueil
			case 'accueil' :
				include_once (dirname(__FILE__) .'/src/controleurs/Accueil.inc.php');
				break;
				
			// creer un compte
			case 'creer_compte' :
				include_once (dirname(__FILE__) .'/src/controleurs/Creer_compte.inc.php');
				break;
				
			// afficher un compte
			case 'afficher_compte' :
				include_once (dirname(__FILE__) .'/src/controleurs/Afficher_compte.inc.php');
				break;
				
			// gerer un compte
			case 'modifier_compte' :
				include_once (dirname(__FILE__) .'/src/controleurs/Modifier_compte.inc.php');
				break;
				
			// creer une recette
			case 'creer_recette' :
				include_once (dirname(__FILE__) .'/src/controleurs/Creer_recette.inc.php');
				break;
				
			// afficher une recette
			case 'modifier_recette' :
				include_once (dirname(__FILE__) .'/src/controleurs/Modifier_recette.inc.php');
				break;
				
			// afficher une recette
			case 'afficher_recette' :
				include_once (dirname(__FILE__) .'/src/controleurs/Afficher_recette.inc.php');
				break;
				
			// lister une recette
			case 'lister_recette' :
				include_once (dirname(__FILE__) .'/src/controleurs/Lister_recette.inc.php');
				break;
				
			// lister une recette d'utilisateur
			case 'lister_recette_utilisateur' :
				include_once (dirname(__FILE__) .'/src/controleurs/Lister_recette_utilisateur.inc.php');
				break;
				
			// le nom de la page n'existe pas
			default :
				throw new PageInconnueExcep($donneesControleur['page']);
				break;
		}
	}
	
	
	// exceptions
	catch (PDOException $e)
	{
		//$exc = new P($e->getMessage());
	}
	catch (AppException $e)
	{
		$excepMessage = $e->getMessage();
		include_once (dirname(__FILE__) .'/src/controleurs/Exception.inc.php');
		die();
	}
	
?>
