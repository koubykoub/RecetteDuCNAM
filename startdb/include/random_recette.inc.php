<?php
	// include
	include_once (dirname(__FILE__) . '/define.inc.php');
	include_once (dirname(__FILE__) . '/../../src/librairies/dao/DAOCategorie.class.php');
	include_once (dirname(__FILE__) . '/../../src/librairies/dao/DAOCategorie_prix.class.php');
	include_once (dirname(__FILE__) . '/../../src/librairies/dao/DAOCategorie_difficulte.class.php');
	include_once (dirname(__FILE__) . '/../../src/librairies/dao/DAOUtilisateur.class.php');
	include_once (dirname(__FILE__) . '/../../src/librairies/dao/DAORecette.class.php');
	include_once (dirname(__FILE__) . '/../../src/librairies/dao/DAOCommentaire.class.php');
	

	echo '<h1>Création de la base de donnée...</h1>';
	
	{
	
	// creation des categories
	// categories / sous categories
	$categories = array();
	// aperitif
	/*$categorie['intitule'] = 'Apéritifs';
	$categorie['sous_categorie'] = array();
	$categorie['sous_categorie'][] = 'Bouchées';
	$categorie['sous_categorie'][] = 'Feuilletés';
	$categorie['sous_categorie'][] = 'Mufins salés';
	$categories[] = $categorie;*/
	// entree
	$categorie['intitule'] = 'Entrées';
	$categorie['sous_categorie'] = array();
	$categorie['sous_categorie'][] = 'Cakes';
	$categorie['sous_categorie'][] = 'Entrées chaudes';
	$categorie['sous_categorie'][] = 'Entrées froides';
	$categorie['sous_categorie'][] = 'Pizzas';
	$categories[] = $categorie;
	// viande
	$categorie['intitule'] = 'Viandes';
	$categorie['sous_categorie'] = array();
	$categorie['sous_categorie'][] = 'Agneau';
	$categorie['sous_categorie'][] = 'Boeuf';
	$categorie['sous_categorie'][] = 'Canard';
	$categorie['sous_categorie'][] = 'Gibier';
	$categories[] = $categorie;
	// poisson
	$categorie['intitule'] = 'Poissons';
	$categorie['sous_categorie'] = array();
	$categorie['sous_categorie'][] = 'Cabillaud';
	$categorie['sous_categorie'][] = 'Coquillages';
	$categorie['sous_categorie'][] = 'Crevettes';
	$categories[] = $categorie;
	// autre plat
	$categorie['intitule'] = 'Autres plats';
	$categorie['sous_categorie'] = array();
	$categorie['sous_categorie'][] = 'Légumes';
	$categorie['sous_categorie'][] = 'Oeufs';
	$categorie['sous_categorie'][] = 'Pâtes';
	$categories[] = $categorie;
	// dessert
	$categorie['intitule'] = 'Desserts';
	$categorie['sous_categorie'] = array();
	$categorie['sous_categorie'][] = 'Biscuits';
	$categorie['sous_categorie'][] = 'Cakes sucrés';
	$categorie['sous_categorie'][] = 'Confitures et Gelées';
	$categories[] = $categorie;
	// sauce
	$categorie['intitule'] = 'Sauces';
	$categorie['sous_categorie'] = array();
	$categorie['sous_categorie'][] = 'Beurre composé';
	$categorie['sous_categorie'][] = 'Comdiments';
	$categorie['sous_categorie'][] = 'Marinade';
	$categories[] = $categorie;
	// pain
	/*$categorie['intitule'] = 'Pains';
	$categorie['sous_categorie'] = array();
	$categorie['sous_categorie'][] = 'Brioches et Viennoiseries';
	$categorie['sous_categorie'][] = 'Pains salés';
	$categories[] = $categorie;*/
	// boisson
	$categorie['intitule'] = 'Boissons';
	$categorie['sous_categorie'] = array();
	$categorie['sous_categorie'][] = 'Boissons sans alcool';
	$categorie['sous_categorie'][] = 'Coktails avec alcool';
	$categorie['sous_categorie'][] = 'Smoothie';
	$categories[] = $categorie;
	// creation
	$daoCat = new DAOCategorie($conn);
	$daoSousCat = new DAOSous_categorie($conn);
	foreach ($categories as $cat)
	{
		$catTmp['intitule'] = $cat['intitule'];
		$id = $daoCat->Create($catTmp);
		foreach ($cat['sous_categorie'] as $scat)
		{
			$scatTmp['intitule'] = $scat;
			$scatTmp['id_categorie'] = $id;
			$daoSousCat->Create($scatTmp);
		}
	}
	
	// categorie difficulte
	$categoriesDif = array();
	$categoriesDif[] = 'Facile';
	$categoriesDif[] = 'Moyenne';
	$categoriesDif[] = 'Difficile';
	// creation
	$daoCat = new DAOCategorie_difficulte($conn);
	foreach ($categoriesDif as $cat)
	{
		$catTmp['intitule'] = $cat;
		$daoCat->Create($catTmp);
	}

	// categorie prix
	$categoriesPrix= array();
	$categoriesPrix[] = 'Bon marché (inférieur à 10 €)';
	$categoriesPrix[] = 'Abordable (entre 10 et 50 €)';
	$categoriesPrix[] = 'Cher (supérieur à 50 €)';
	// creation
	$daoCat = new DAOCategorie_prix($conn);
	foreach ($categoriesPrix as $cat)
	{
		$catTmp['intitule'] = $cat;
		$daoCat->Create($catTmp);
	}
	
	
	// creation des utilisateurs
	function CreateUtilisateur($utStr)
	{
		$ut['login'] = str_repeat($utStr, UT_LOGIN_LONGUEUR_MIN);
		$ut['mdp'] = str_repeat($utStr, UT_LOGIN_LONGUEUR_MIN);
		$ut['nom'] = $utStr;
		$ut['prenom'] = $utStr;
		$ut['email'] = $utStr.'@'.$utStr;
		$dt = new DateTime();
		$ut['date_inscription'] = $dt->format('Y-m-d H:i:s');
		return $ut;
	}
	$daoUt = new DAOUtilisateur($conn);
	$utilisateurs = array();
	for ($i = 0 ; $i < NB_UTILISATEUR ; ++$i)
		$utilisateurs[] = $daoUt->RetrieveById($daoUt->Create(CreateUtilisateur(strval($i))));
	
	
	// creation des recettes
	$chpsLexical = array('pain', 'porc', 'fromage', 'fruit', 'bouchée', 'volaille', 'riz', 'soja', 'bouillie', 'charcuterie', 'chips',
						 'pâte', 'moule', 'jus', 'crudité', 'salaison', 'bouilli', 'carotte', 'coulis', 'croquette', 'papillote',
						 'pierrade', 'poché', 'gril', 'maïs', 'céréale', 'semoule', 'risotto', 'banane', 'sushi', 'haricot', 'blé',
						 'légume', 'piment', 'mangue', 'curry', 'sésame', 'volaille', 'ananas', 'quenelle', 'nem', 'pilaf', 'agneau',
						 'sucre', 'noix', 'amande', 'citron', 'confiture', 'cerise', 'figue', 'salade', 'raisin', 'courge', 'agrume',
						 'pomme', 'orange', 'myrtille', 'melon', 'abricot', 'tomate', 'vanille', 'coco', 'poire', 'aubergine', 'boeuf',
					     'ragoût', 'rôti', 'saucisse', 'veau', 'bouillon', 'couscous', 'mouton', 'tourte', 'tarte', 'oeuf', 'poulet',
						 'lapin', 'gibier', 'grillade', 'salade', 'brochette', 'lard', 'ravioli', 'carpaccio', 'sandwich', 'rillettes',
						 'friand', 'ail', 'oignon', 'magret', 'poivron', 'potage', 'courgette', 'poivron', 'vin', 'carpe', 'saumon',
						 'morue', 'sardine', 'brochet');
	function GetRandomTitre($size, &$chpsLexical)
	{
		$titre = '';
		for ($i = 0 ; $i < $size ; ++$i)
			$titre .= (($i == 0) ? '' : ' ').$chpsLexical[rand(0, count($chpsLexical) - 1)];
		return $titre;
	}
	$loremipsum = 'Quisque massa vestibulum sapien lobortïs venesatis luctus volutpat torquenté molestie class nullä torquenté gravida sét, potentié lacinia blandît alèquam potentié adipiscing scéléréo neque donéc lorém ût sét porta, quisque çurcus donéc placérat torquenté auctor quisque variûs gravida eu phaséllœs. Imperdiet iaculis laoreet ullamcorpér sollicitudin fringilla. Masse lacinia sit quîs sociosqu ipsum eleifend pulvîar diam justo sém donéc luctus at venesatis sagittis arcu gravida cubilia in èst ligula tempès, fermentum ùrci egestas ùrci 12 336€ elementum lacus viverra dapibus vivamùs tortor pérès pulvîar. Habitasse curàé mié id du intègèr curàé Frînglilia alèquam.';
	function GetRandomText($size, &$loremipsum)
	{
		$sizeLorem = mb_strlen($loremipsum,'UTF-8');
		$size = ($size > $sizeLorem) ? $sizeLorem : $size;
		$offset = rand(0, $sizeLorem - $size);
		return mb_substr($loremipsum, $offset, $size, 'UTF-8');
	}
	$daoRec = new DAORecette($conn);
	$daoCat = new DAOCategorie($conn);
	$daoSCat = new DAOSous_categorie($conn);
	$daoCatDiff = new DAOCategorie_difficulte($conn);
	$daoCatPrix = new DAOCategorie_prix($conn);
	$recettes = array();
	foreach ($utilisateurs as $ut)
	{
		// 10 recettes par utilisateur
		for ($i = 0 ; $i < NB_RECETTE ; ++$i)
		{
			// creation d'une recette
			$recette['titre'] = GetRandomTitre(rand(1, 5), $chpsLexical);
			$recette['commentaire'] = GetRandomText(rand(200, 400), $loremipsum);
			$recette['conseil'] = GetRandomText(rand(200, 400), $loremipsum);
			$recette['nb_personne'] = rand(2, 10);
			$dt = new DateTime();
			$recette['date_creation'] = $dt->format('Y-m-d H:i:s');
			$recette['date_maj'] = $dt->format('Y-m-d H:i:s');
			$recette['temps_cuisson'] = 10 * rand(1, 12);
			$recette['temps_preparation'] = 10 * rand(1, 6);
			$recette['id_utilisateur'] = $ut['id'];
			$cat = $daoCat->RetrieveRandom();
			$recette['id_categorie'] = $cat['id'];
			$scat = $daoSCat->RetrieveRandom($cat['id']);
			$recette['id_sous_categorie'] = $scat['id'];
			$cat = $daoCatDiff->RetrieveRandom();
			$recette['id_categorie_difficulte'] = $cat['id'];
			$cat = $daoCatPrix->RetrieveRandom();
			$recette['id_categorie_prix'] = $cat['id'];
			
			// creation des ingredients
			$recette['ingredients'] = array();
			$size = rand(2, 10);
			for ($j = 0 ; $j < $size ; ++$j)
			{
				$ing['id'] = $j;
				$ing['texte_ingredient'] = GetRandomText(rand(40, 80), $loremipsum);
				$recette['ingredients'][] = $ing;
			}
			
			// creation des etapes de preparations
			$recette['etape_preparations'] = array();
			$size = rand(2, 10);
			for ($j = 0 ; $j < $size ; ++$j)
			{
				$etape['id'] = $j;
				$etape['texte_etape'] = GetRandomText(rand(100, 250), $loremipsum);
				$recette['etape_preparations'][] = $etape;
			}
			
			// enregistrement de la recette
			$id = $daoRec->Create($recette);
			$recettes[] = $daoRec->RetrieveById($id);
		}
	}
	
	
	// commentaires
	$daoComm = new DAOCommentaire($conn);
	$limit = round(100000.0 * TAUX_COMMENTAIRE);
	foreach ($utilisateurs as $ut)
	{
		$idUt = $ut['id'];
		foreach ($recettes as $rec)
		{
			if ($rec['id_utilisateur'] == $idUt)
				continue;
			
			$isComment = rand(0, 99999) < $limit;
			if ($isComment)
			{
				// creation commentaire
				$idRec = $rec['id'];
				$comm['id_utilisateur'] = $idUt;
				$comm['id_recette'] = $idRec;
				$comm['texte_commentaire'] = GetRandomText(rand(100, 400), $loremipsum);
				$comm['valeur_note'] = rand(0, 5);
				$dt = new DateTime();
				$comm['date_commentaire'] = $dt->format('Y-m-d H:i:s');
				
				// enregistrement du commentaire
				$daoComm->Create($comm);
			}
		}
	}
	
	}
	
	echo '<h1>Base de donnée créée !</h1>';
	
?>
