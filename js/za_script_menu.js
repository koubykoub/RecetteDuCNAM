/* INIT *******************************************************/

// DATA
function za_Data_Construct()
{
	// MENU
	this.menu = [];
	
	// SELECT LINE DETAILS (700 de large)
	this.selectLineDetails_categorie =
	[
		{type:'id', size:50},
		{type:'intitule', size:650}
	 ];
	this.selectLineDetails_sousCategorie =
	[
		{type:'id', size:50},
		{type:'id_categorie', size:100},
		{type:'intitule', size:550}
	 ];
	this.selectLineDetails_utilisateur =
	[
		{type:'id', size:50},
		{type:'date_inscription', size:150},
		{type:'login', size:150},
		{type:'nom', size:200},
		{type:'prenom', size:200},
		{type:'email', size:250}
	 ];
	this.selectLineDetails_recette =
	[
		{type:'id', size:50},
		{type:'titre', size:260},
		{type:'date_creation', size:150},
		{type:'date_maj', size:150},
		{type:'nb_personne', size:130},
		{type:'temps_cuisson', size:130},
		{type:'temps_preparation', size:130}
	 ];
	this.selectLineDetails_commentaire =
	[
		{type:'id_utilisateur', size:50},
		{type:'id_recette', size:50},
		{type:'date_commentaire', size:150},
		{type:'valeur_note', size:50},
		{type:'texte_commentaire', size:400}
	 ];
}
za_data = new za_Data_Construct();


// CALL BACKS
function za_InitCB_Details(element, parent)
{
	element.SetValue(parent.GetSelectedValue());
}

function za_GetInitCB_Select(idParent, idElement, ajax = true)
{
	return function(element, parent)
	{
		element.ParentSelected(parent, idParent, idElement, ajax);
	};
}

function za_InitCBMenuCategorie(cat, scat, catDetails, scatDetails)
{
	// detail categorie
	cat.AddSelectCB('categorie_details_cb', catDetails, za_InitCB_Details);
	catDetails.AddParentCB('categorie_cb', cat, za_InitCB_Details);
	// sous categorie
	cat.AddSelectCB('sous_categorie_cb', scat, za_GetInitCB_Select('id', 'id_categorie'));
	scat.alone = false;
	scat.AddParentCB('categorie_cb', cat, za_GetInitCB_Select('id', 'id_categorie', false));
	// detail sous categorie
	scat.AddSelectCB('sous_categorie_details_cb', scatDetails, za_InitCB_Details);
	scatDetails.AddParentCB('sous_categorie_cb', scat, za_InitCB_Details);
}

function za_InitCBMenuSousCategorie(scat, catFilter, scatDetails, catDetails)
{
	// detail sous categorie
	scat.AddSelectCB('sous_categorie_details_cb', scatDetails, za_InitCB_Details);
	scatDetails.AddParentCB('sous_categorie_cb', scat, za_InitCB_Details);
	// filtre categorie
	catFilter.AddSelectCB('sous_categorie_cb', scat, za_GetInitCB_Select('id', 'id_categorie'));
	scat.AddParentCB('categorie_cb', catFilter, za_GetInitCB_Select('id', 'id_categorie', false));
	// detail categorie
	catFilter.AddSelectCB('sous_categorie_details_cb', catDetails, za_InitCB_Details);
	catDetails.AddParentCB('sous_categorie_cb', catFilter, za_InitCB_Details);
}

function za_InitCBMenuCategorieSpe(cat, catDetails)
{
	// detail categorie
	cat.AddSelectCB('categorie_details_cb', catDetails, za_InitCB_Details);
	catDetails.AddParentCB('categorie_cb', cat, za_InitCB_Details);
}

function za_InitCBMenuUtilisateur(ut, utDetails)
{
	// detail utilisateur
	ut.AddSelectCB('utilisateur_details_cb', utDetails, za_InitCB_Details);
	utDetails.AddParentCB('categorie_cb', ut, za_InitCB_Details);
}


// MENU
function za_CreateMenuCategorie()
{
	// menu categorie
	var menuCategorie = new za_Menu_Construct('menu_categorie', 'Menu des catégories');
		// categorie select list
		var mc_catList = new  za_SelectList_Construct('select_list_categorie', 'Liste des catégories', 7, 700, 'categorie_list', za_data.selectLineDetails_categorie);
		menuCategorie.AddChild(mc_catList);
		// MENU
		// details
		var mc_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
			// details
			var mc_md_details = new za_CategorieDetails_Construct('details_categorie', 'Détails de la catégorie sélectionnée');
			mc_menuDetails.AddChild(mc_md_details);
		menuCategorie.AddChild(mc_menuDetails);
		// sous categories
		var mc_menuSousCategorie = new za_Menu_Construct('menu_sous_categorie', 'Sous catégories');
			// sous categorie select list
			var mc_msc_scatList = new  za_SelectList_Construct('select_list_sous_categorie', 'Liste des sous catégories', 7, 700, 'sous_categorie_list', za_data.selectLineDetails_sousCategorie);
			mc_menuSousCategorie.AddChild(mc_msc_scatList);
			// MENU
			// details
			var mc_msc_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
				// details
				var mc_msc_md_details = new za_SousCategorieDetails_Construct('details_sous_categorie', 'Détails de la catégorie sélectionnée');
				mc_msc_menuDetails.AddChild(mc_msc_md_details);
			mc_menuSousCategorie.AddChild(mc_msc_menuDetails);
		menuCategorie.AddChild(mc_menuSousCategorie);
	za_InitCBMenuCategorie(mc_catList, mc_msc_scatList, mc_md_details, mc_msc_md_details);
	return menuCategorie;
}

function za_CreateMenuSousCategorie()
{
	// menu sous categories
	var menuSousCategorie = new za_Menu_Construct('menu_sous_categorie', 'Menu des sous catégories');
		// sous categorie select list
		var msc_scatList = new  za_SelectList_Construct('select_list_sous_categorie', 'Liste des sous catégories', 7, 700, 'sous_categorie_list', za_data.selectLineDetails_sousCategorie);
		menuSousCategorie.AddChild(msc_scatList);
		// MENU
		// details
		var msc_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
			// details
			var msc_md_details = new za_SousCategorieDetails_Construct('details_sous_categorie', 'Détails de la catégorie sélectionnée');
			msc_menuDetails.AddChild(msc_md_details);
		menuSousCategorie.AddChild(msc_menuDetails);
		// FILTER
		var msc_menuFilter = new za_Menu_Construct('menu_filter', 'Filtrer');
			// MENU
			// categorie
			var msc_mf_menuCategorie = new za_Menu_Construct('menu_categorie', 'Catégories');
				// categorie select list
				var msc_mf_mc_catList = new  za_SelectList_Construct('select_list_categorie', 'Filtrer par catégories', 7, 700, 'categorie_list', za_data.selectLineDetails_categorie);
				msc_mf_menuCategorie.AddChild(msc_mf_mc_catList);
				// MENU
				// details
				var msc_mf_mc_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
					// details
					var msc_mf_mc_md_details = new za_CategorieDetails_Construct('details_categorie', 'Détails de la catégorie sélectionnée');
					msc_mf_mc_menuDetails.AddChild(msc_mf_mc_md_details);
				msc_mf_menuCategorie.AddChild(msc_mf_mc_menuDetails);
			msc_menuFilter.AddChild(msc_mf_menuCategorie);
		menuSousCategorie.AddChild(msc_menuFilter);
	za_InitCBMenuSousCategorie(msc_scatList, msc_mf_mc_catList, msc_md_details, msc_mf_mc_md_details);
	return menuSousCategorie;
}

function za_CreateMenuCategorieDiff()
{
	// menu categorie difficulte
	var menuCategorieDiff = new za_Menu_Construct('menu_categorie_diff', 'Menu des catégories de difficulté');
		// select list
		var mcd_catList = new  za_SelectList_Construct('select_list_categorie', 'Liste des catégories', 7, 700, 'categorie_diff_list', za_data.selectLineDetails_categorie);
		menuCategorieDiff.AddChild(mcd_catList);
		// MENU
		// details
		var mcd_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
			// details
			var mcd_md_details = new za_CategorieDetails_Construct('details_categorie_diff', 'Détails de la catégorie sélectionnée');
			mcd_menuDetails.AddChild(mcd_md_details);
		menuCategorieDiff.AddChild(mcd_menuDetails);
	za_InitCBMenuCategorieSpe(mcd_catList, mcd_md_details);
	return menuCategorieDiff;
}

function za_CreateMenuCategoriePrix()
{
	// menu categorie difficulte
	var menuCategoriePrix = new za_Menu_Construct('menu_categorie_prix', 'Menu des catégories de prix');
		// select list
		var mcp_catList = new  za_SelectList_Construct('select_list_categorie', 'Liste des catégories', 7, 700, 'categorie_prix_list', za_data.selectLineDetails_categorie);
		menuCategoriePrix.AddChild(mcp_catList);
		// MENU
		// details
		var mcp_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
			// details
			var mcp_md_details = new za_CategorieDetails_Construct('details_categorie_prix', 'Détails de la catégorie sélectionnée');
			mcp_menuDetails.AddChild(mcp_md_details);
		menuCategoriePrix.AddChild(mcp_menuDetails);
	za_InitCBMenuCategorieSpe(mcp_catList, mcp_md_details);
	return menuCategoriePrix;
}

function za_CreateMenuUtilisateur()
{
	// menu utilisateur
	var menuUtilisateur = new za_Menu_Construct('menu_utilisateur', 'Menu des utilisateurs');
		// select list
		var mu_utList = new  za_SelectList_Construct('select_list_utilisateur', 'Liste des utilisateurs', 10, 1000, 'utilisateur_list', za_data.selectLineDetails_utilisateur);
		menuUtilisateur.AddChild(mu_utList);
		// MENU
		// details
		var mu_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
			// details
			var mu_md_details = new za_UtilisateurDetails_Construct('details_categorie_prix', 'Détails de la catégorie sélectionnée');
			mu_menuDetails.AddChild(mu_md_details);
		menuUtilisateur.AddChild(mu_menuDetails);
		// recettes
		var mu_menuRecette = new za_Menu_Construct('menu_recette', 'Recettes');
			// MENU
			// details
			var mu_mr_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
			mu_menuRecette.AddChild(mu_mr_menuDetails);
			// commentaire
			var mu_mr_menuCommentaire = new za_Menu_Construct('menu_commentaire', 'Commentaire');
			mu_menuRecette.AddChild(mu_mr_menuCommentaire);
		menuUtilisateur.AddChild(mu_menuRecette);
		// commentaires
		var mu_menuCommentaire = new za_Menu_Construct('menu_commentaire', 'Commentaires');
			// MENU
			// details
			var mu_mc_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
			mu_menuCommentaire.AddChild(mu_mc_menuDetails);
			// recette
			var mu_mc_menuRecette = new za_Menu_Construct('menu_recette', 'Recette');
			mu_menuCommentaire.AddChild(mu_mc_menuRecette);
		menuUtilisateur.AddChild(mu_menuCommentaire);
	za_InitCBMenuUtilisateur(mu_utList, mu_md_details);
	return menuUtilisateur;
}

function za_CreateMenuRecette()
{
	// menu recette
	var menuRecette = new za_Menu_Construct('menu_recette', 'Menu des recettes');
		// select list
		var mr_recList = new  za_SelectList_Construct('select_list_recette', 'Liste des recettes', 10, 1000, 'recette_list', za_data.selectLineDetails_recette);
		menuRecette.AddChild(mr_recList);
		// MENU
		// details
		var mr_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
		menuRecette.AddChild(mr_menuDetails);
		// utilisateur
		var mr_menuUtilisateur = new za_Menu_Construct('menu_utilisateur', 'Utilisateur');
		menuRecette.AddChild(mr_menuUtilisateur);
		// commentaire
		var mr_menuCommentaire = new za_Menu_Construct('menu_commentaire', 'Commentaires');
			// MENU
			// details
			var mr_mc_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
			mr_menuCommentaire.AddChild(mr_mc_menuDetails);
			// utilisateur
			var mr_mc_menuUtilisateur = new za_Menu_Construct('menu_utilisateur', 'Utilisateur');
			mr_menuCommentaire.AddChild(mr_mc_menuUtilisateur);
		menuRecette.AddChild(mr_menuCommentaire);
		// FILTER
		var mr_menuFilter = new za_Menu_Construct('menu_filter', 'Filtrer');
			// MENU
			// categorie
			var mr_mf_menuCategorie = new za_Menu_Construct('menu_categorie', 'Filtrer par catégories');
				// MENU
				// details
				var mr_mf_mc_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
				mr_mf_menuCategorie.AddChild(mr_mf_mc_menuDetails);
				// sous categories
				var mr_mf_mc_menuSousCategorie = new za_Menu_Construct('menu_sous_categorie', 'Filtrer par sous catégories');
					// MENU
					// details
					var mr_mf_mc_msc_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
					mr_mf_mc_menuSousCategorie.AddChild(mr_mf_mc_msc_menuDetails);
				mr_mf_menuCategorie.AddChild(mr_mf_mc_menuSousCategorie);
			mr_menuFilter.AddChild(mr_mf_menuCategorie);
			// categorie difficulte
			var mr_mf_menuCategorieDiff = new za_Menu_Construct('menu_categorie_diff', 'Filtrer par catégories de difficulté');
				// MENU
				// details
				var mr_mf_mcd_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
				mr_mf_menuCategorieDiff.AddChild(mr_mf_mcd_menuDetails);
			mr_menuFilter.AddChild(mr_mf_menuCategorieDiff);
			// categorie prix
			var mr_mf_menuCategoriePrix = new za_Menu_Construct('menu_categorie_prix', 'Filtrer par catégories de prix');
				// MENU
				// details
				var mr_mf_mcp_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
				mr_mf_menuCategoriePrix.AddChild(mr_mf_mcp_menuDetails);
			mr_menuFilter.AddChild(mr_mf_menuCategoriePrix);
			// utilisateur
			var mr_mf_menuUtilisateur = new za_Menu_Construct('menu_utilisateur', 'Filtrer par utilisateurs');
				// MENU
				// details
				var mr_mf_mu_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
				mr_mf_menuUtilisateur.AddChild(mr_mf_mu_menuDetails);
			mr_menuFilter.AddChild(mr_mf_menuUtilisateur);
		menuRecette.AddChild(mr_menuFilter);
	return menuRecette;
}

function za_CreateMenuCommentaire()
{
	// menu commentaire
	var menuCommentaire = new za_Menu_Construct('menu_commentaire', 'Menu des commentaires');
		// select list
		var mc_comList = new  za_SelectList_Construct('select_list_commentaire', 'Liste des commentaires', 10, 700, 'commentaire_list', za_data.selectLineDetails_commentaire);
		menuCommentaire.AddChild(mc_comList);
		// MENU
		// details
		var mc_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
		menuCommentaire.AddChild(mc_menuDetails);
		// utilisateur
		var mc_menuUtilisateur = new za_Menu_Construct('menu_utilisateur', 'Utilisateur');
		menuCommentaire.AddChild(mc_menuUtilisateur);
		// recette
		var mc_menuRecette = new za_Menu_Construct('menu_recette', 'Recette');
		menuCommentaire.AddChild(mc_menuRecette);
		// FILTER
		var mc_menuFilter = new za_Menu_Construct('menu_filter', 'Filtrer');
			// utilisateur
			var mc_mf_menuUtilisateur = new za_Menu_Construct('menu_utilisateur', 'Filtrer par utilisateurs');
				// MENU
				// details
				var mc_mf_mu_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
				mc_mf_menuUtilisateur.AddChild(mc_mf_mu_menuDetails);
			mc_menuFilter.AddChild(mc_mf_menuUtilisateur);
			// recette
			var mc_mf_menuRecette = new za_Menu_Construct('menu_recette', 'Filtrer par recettes');
				// MENU
				// details
				var mc_mf_mr_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
				mc_mf_menuRecette.AddChild(mc_mf_mr_menuDetails);
			mc_menuFilter.AddChild(mc_mf_menuRecette);
		menuCommentaire.AddChild(mc_menuFilter);
	return menuCommentaire;
}

/* FIN INIT ***************************************************/
