
/**************************************************************/
/* AJAX														  */
/**************************************************************/
function za_Ajax(type, data, succesFct, errorFct)
{
	var metaData =
	{
		page : 'zone_administration_ajax',
		type : type,
		data : data
	}
	$.ajax
	({
		type : 'POST',
		url : '',
		data : metaData,
		success : succesFct,
		error : errorFct
	});
}


/**************************************************************/
/* OBJECTS													  */
/**************************************************************/
/* UTIL *******************************************************/
var za_ExtendClass = function(child, parent)
{
	var ProtoConst = function(){};
	ProtoConst.prototype = parent.prototype;
	child.prototype = new ProtoConst();
};

/* FIN UTIL ***************************************************/


/* BASE *******************************************************/
// constructor
var za_ElementBase_Construct = function(name, fsName)
{
	// attributs
	this.name = name;
	this.fsName = fsName;
	this.parent = null;
	this.enabled = false;
	this.CreateDOMElementBase();
};
za_ElementBase_Construct.prototype.SetParent = function(parent)
{
	this.parent = parent;
};

// enable / disable
za_ElementBase_Construct.prototype.EnableBase = function()
{
	this.parent.DOMElement.append(this.DOMElement);
	this.enabled = true;
};
za_ElementBase_Construct.prototype.DisableBase = function()
{
	this.DOMElement.detach();
	this.enabled = false;
};

// DOM
za_ElementBase_Construct.prototype.CreateDOMElementBase = function()
{
	this.DOMElement = $('<fieldset />').append($('<legend />').text(this.fsName));
};

/* FIN BASE ***************************************************/


/* MENU *******************************************************/
//constructor
var za_Menu_Construct = function(name, fsName)
{
	// attributs
	this.constructor(name, fsName);
	this.opened = false;
	this.elements = {};
	this.SetDOMElement();
};
za_ExtendClass(za_Menu_Construct, za_ElementBase_Construct);

// constant
za_Menu_Construct.prototype.CLOSED_COLOR = 'orange';
za_Menu_Construct.prototype.OPENED_COLOR = 'green';
za_Menu_Construct.prototype.MOUSE_OVER_COLOR = 'red';
za_Menu_Construct.prototype.MOUSE_OUT_COLOR = 'black';

// enable / disable
za_Menu_Construct.prototype.Enable = function()
{
	this.EnableBase();
	for (var key in this.elements)
		if (this.opened) this.elements[key].Enable();
};

za_Menu_Construct.prototype.Disable = function()
{
	this.DisableBase();
	for (var key in this.elements)
		if (this.opened) this.elements[key].Disable();
};

// children
za_Menu_Construct.prototype.AddChild = function(child)
{
	child.SetParent(this);
	this.elements[child.name] = child;
};

// DOM
za_Menu_Construct.prototype.SetDOMElement = function()
{
	// DOM events
	var self = this;
	this.DOMElement.find('> legend').attr('class', 'za_legend_menu')
	// mouse over legend
	.mouseover(function()
	{
		$(this).css('color', self.MOUSE_OVER_COLOR);
		$(this).css('cursor', 'pointer');
	})
	// mouse out legend
	.mouseout(function()
	{
		$(this).css('color', self.MOUSE_OUT_COLOR);
		$(this).css('cursor', 'default');
	})
	// click legend
	.click(function(){self.onClickLegend();});
};

za_Menu_Construct.prototype.SetDOMElementOpened = function()
{
	if (this.opened)
		this.DOMElement.find('> legend').css('background-color', this.OPENED_COLOR);
	else
		this.DOMElement.find('> legend').css('background-color', this.CLOSED_COLOR);
}

// input
za_Menu_Construct.prototype.onClickLegend = function()
{
	this.opened = !this.opened;
	for (var key in this.elements)
	{
		if (this.opened)
			this.elements[key].Enable();
		else
			this.elements[key].Disable();
	}
	this.SetDOMElementOpened();
};

/* FIN MENU ***************************************************/


/* DETAILS ****************************************************/
//constructor
var za_Details_Construct = function(name, fsName)
{
	// attributs
	this.constructor(name, fsName);
	this.SetDOMElement();
};
za_ExtendClass(za_Details_Construct, za_ElementBase_Construct);

//enable / disable
za_Details_Construct.prototype.Enable = function()
{
	this.EnableBase();
};

za_Details_Construct.prototype.Disable = function()
{
	this.DisableBase();
};

//DOM
za_Details_Construct.prototype.SetDOMElement = function()
{
	this.DOMElement.append($('<h4 />').text(this.fsName));
};

/* FIN DETAILS ************************************************/


/* SELECT LIST ************************************************/
//constructor
var za_SelectList_Construct = function(name, fsName, size, type, header)
{
	// attributs
	this.constructor(name, fsName);
	this.size = size;
	this.type = type;
	this.header = header;
	this.alone = true;
	this.data = [];
	this.ajaxData = {};
	this.selectedOption = -1;
	this.selectCB = {};
	this.parentCB = {};
	this.SetDOMElement();
};
za_ExtendClass(za_SelectList_Construct, za_ElementBase_Construct);

// constant
za_SelectList_Construct.prototype.LOAD_MESSAGE = 'Chargement...';
za_SelectList_Construct.prototype.EMPTY_MESSAGE = 'Liste vide...';
za_SelectList_Construct.prototype.ERROR_MESSAGE = 'Erreur interne : ';

//enable / disable
za_SelectList_Construct.prototype.Enable = function()
{
	this.EnableBase();
	this.InitSelect(this.LOAD_MESSAGE);
	this.data = [];
	this.ajaxData = {};
	this.selectedOption = -1;
	this.InitSelectedParents();
	this.Ajax();
};

za_SelectList_Construct.prototype.Disable = function()
{
	this.DisableBase();
	this.Select(-1);
	this.InitSelect(null);
};

// select
za_SelectList_Construct.prototype.Select = function(id)
{
	this.selectedOption = id;
	
	// select call backs
	for (var key in this.selectCB)
	{
		var selectCB = this.selectCB[key];
		if (selectCB.element.enabled)
			selectCB.cb.call(selectCB.element, this);
	}
}

za_SelectList_Construct.prototype.AddSelectCB = function(key, element, cb)
{
	var newCB =
	{
			element : element,
			cb : cb
	};
	this.selectCB[key] = newCB;
}

za_SelectList_Construct.prototype.ParentSelected = function(parent, parentName, name, ajax = true)
{
	var id = parent.selectedOption;
	if (!id || (id == -1))
		this.ValueSelected(-1, name, ajax);
	else if (id && (id != -1))
		this.ValueSelected(parent.data[id][parentName], name, ajax);
}

za_SelectList_Construct.prototype.ValueSelected = function(val, name, ajax)
{
	this.AddSelection(val, name);
	if (ajax)
	{
		this.data = [];
		this.Ajax();
	}
}

za_SelectList_Construct.prototype.AddSelection = function(val, name)
{
	if ((!val || (val == -1)) && this.ajaxData[name])
		delete this.ajaxData[name];
	else if (val && (val != -1))
		this.ajaxData[name] = val;
}

za_SelectList_Construct.prototype.AddParentCB = function(key, parent, cb)
{
	var newCB =
	{
			parent : parent,
			cb : cb
	};
	this.parentCB[key] = newCB;
}

za_SelectList_Construct.prototype.InitSelectedParents = function()
{
	// parent call backs
	for (var key in this.parentCB)
	{
		var parentCB = this.parentCB[key];
		if (parentCB.parent.enabled)
			parentCB.cb.call(this, parentCB.parent);
	}
}

// ajax
za_SelectList_Construct.prototype.Ajax = function()
{
	if (this.alone && $.isEmptyObject(this.ajaxData))
		this.ajaxData.empty = true;
	var self = this;
	za_Ajax(this.type, this.ajaxData,
	function(resp)
	{
		self.data = JSON.parse(resp);
		self.InitSelectData();
	},
	function(resp)
	{
		self.InitSelect(self.ERROR_MESSAGE + resp);
	});
}

//DOM
za_SelectList_Construct.prototype.SetDOMElement = function()
{
	var self = this;
	var select = $('<select />').attr('size', this.size).attr('multiple', 'multiple').attr('class', 'za_salect_list')
	// change selected option
	.change(function()
	{
		var val = $(this).find('> option:selected').val();
		self.Select(val);
	});
	this.DOMElement.append(select);
};

za_SelectList_Construct.prototype.InitSelect = function(message)
{
	var select = this.DOMElement.find('> select');
	select.find('> option').remove();
	if (message != null)
		select.append($('<option />').attr('value', -1).text(message));
};

za_SelectList_Construct.prototype.InitSelectData = function()
{
	this.InitSelect(null);
	var select = this.DOMElement.find('> select');
	select.append($('<option />').attr('value', -1).append(this.CreateTabLineHeader()));
	for (var i = 0 ; i < this.data.length ; ++i)
		select.append($('<option />').attr('value', i).append(this.CreateTabLine(i)));
};

za_SelectList_Construct.prototype.CreateTabLineHeader = function()
{
	var row = $('<div />');
	for (var i = 0 ; i < this.header.length ; ++i)
		row.append($('<div />').css('max-width', this.header[i].size + 'px').css('min-width', this.header[i].size + 'px')
							   .css('font-weight', 'bold')
							   .css('font-style', 'italic')
							   .css('height', 22)
							   .css('font-size', '1.2em')
							   .text(this.header[i].type));
	return $('<div />').attr('class', 'za_tableau').append(row);
}

za_SelectList_Construct.prototype.CreateTabLine = function(idData)
{
	var row = $('<div />');
	for (var i = 0 ; i < this.header.length ; ++i)
	{
		var d = $('<div />').css('max-width', this.header[i].size + 'px').css('min-width', this.header[i].size + 'px');
		if (this.data[idData][this.header[i].type])
			d.text(this.data[idData][this.header[i].type]);
		else
			d.text('');
		row.append(d);
	}
	return $('<div />').attr('class', 'za_tableau').append(row);
}

/* FIN SELECT LIST ********************************************/


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
		{type:'date_inscription', size:100},
		{type:'login', size:110},
		{type:'nom', size:120},
		{type:'prenom', size:120},
		{type:'email', size:200}
	 ];
	this.selectLineDetails_recette =
	[
		{type:'id', size:50},
		{type:'titre', size:150},
		{type:'date_creation', size:100},
		{type:'date_maj', size:100},
		{type:'nb_personne', size:100},
		{type:'temps_cuisson', size:100},
		{type:'temps_preparation', size:100}
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
function za_InitCBMenuCategorie(cat, scat)
{
	// sous categorie
	cat.AddSelectCB('sous_categorie_cb', scat, function(parent)
	{
		this.ParentSelected(parent, 'id', 'id_categorie');
	});
	scat.alone = false;
	scat.AddParentCB('categorie_cb', cat, function(parent)
	{
		this.ParentSelected(parent, 'id', 'id_categorie', false);
	});
}

function za_InitCBMenuSousCategorie(scat, catFilter)
{
	// filtre categorie
	catFilter.AddSelectCB('sous_categorie_cb', scat, function(parent)
	{
		this.ParentSelected(parent, 'id', 'id_categorie');
	});
	scat.AddParentCB('categorie_cb', catFilter, function(parent)
	{
		this.ParentSelected(parent, 'id', 'id_categorie', false);
	});
}


// MENU
function za_CreateMenuCategorie()
{
	// menu categorie
	var menuCategorie = new za_Menu_Construct('menu_categorie', 'Menu des catégories');
		// categorie select list
		var mc_catList = new  za_SelectList_Construct('select_list_categorie', 'Liste des catégories', 7, 'categorie_list', za_data.selectLineDetails_categorie);
		menuCategorie.AddChild(mc_catList);
		// MENU
		// details
		var mc_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
			// details
			var mc_md_details = new za_Details_Construct('details_categorie', 'Détails de la catégorie sélectionnée');
			mc_menuDetails.AddChild(mc_md_details);
		menuCategorie.AddChild(mc_menuDetails);
		// sous categories
		var mc_menuSousCategorie = new za_Menu_Construct('menu_sous_categorie', 'Sous catégories');
			// sous categorie select list
			var mc_msc_scatList = new  za_SelectList_Construct('select_list_sous_categorie', 'Liste des sous catégories', 7, 'sous_categorie_list', za_data.selectLineDetails_sousCategorie);
			mc_menuSousCategorie.AddChild(mc_msc_scatList);
			// MENU
			// details
			var mc_msc_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
				// details
				var mc_msc_md_details = new za_Details_Construct('details_categorie', 'Détails de la sous catégorie sélectionnée');
				mc_msc_menuDetails.AddChild(mc_msc_md_details);
			mc_menuSousCategorie.AddChild(mc_msc_menuDetails);
		menuCategorie.AddChild(mc_menuSousCategorie);
		za_InitCBMenuCategorie(mc_catList, mc_msc_scatList);
	return menuCategorie;
}

function za_CreateMenuSousCategorie()
{
	// menu sous categories
	var menuSousCategorie = new za_Menu_Construct('menu_sous_categorie', 'Menu des sous catégories');
		// sous categorie select list
		var msc_scatList = new  za_SelectList_Construct('select_list_sous_categorie', 'Liste des sous catégories', 7, 'sous_categorie_list', za_data.selectLineDetails_sousCategorie);
		menuSousCategorie.AddChild(msc_scatList);
		// MENU
		// details
		var msc_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
		menuSousCategorie.AddChild(msc_menuDetails);
		// FILTER
		var msc_menuFilter = new za_Menu_Construct('menu_filter', 'Filtrer');
			// MENU
			// categorie
			var msc_mf_menuCategorie = new za_Menu_Construct('menu_categorie', 'Catégories');
				// categorie select list
				var msc_mf_mc_catList = new  za_SelectList_Construct('select_list_categorie', 'Filtrer par catégories', 7, 'categorie_list', za_data.selectLineDetails_categorie);
				msc_mf_menuCategorie.AddChild(msc_mf_mc_catList);
				// MENU
				// details
				var msc_mf_mc_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
				msc_mf_menuCategorie.AddChild(msc_mf_mc_menuDetails);
			msc_menuFilter.AddChild(msc_mf_menuCategorie);
		menuSousCategorie.AddChild(msc_menuFilter);
		za_InitCBMenuSousCategorie(msc_scatList, msc_mf_mc_catList);
	return menuSousCategorie;
}

function za_CreateMenuCategorieDiff()
{
	// menu categorie difficulte
	var menuCategorieDiff = new za_Menu_Construct('menu_categorie_diff', 'Menu des catégories de difficulté');
		// select list
		var mcd_catList = new  za_SelectList_Construct('select_list_categorie', 'Liste des catégories', 7, 'categorie_diff_list', za_data.selectLineDetails_categorie);
		menuCategorieDiff.AddChild(mcd_catList);
		// MENU
		// details
		var mcd_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
		menuCategorieDiff.AddChild(mcd_menuDetails);
	return menuCategorieDiff;
}

function za_CreateMenuCategoriePrix()
{
	// menu categorie difficulte
	var menuCategoriePrix = new za_Menu_Construct('menu_categorie_prix', 'Menu des catégories de prix');
		// select list
		var mcp_catList = new  za_SelectList_Construct('select_list_categorie', 'Liste des catégories', 7, 'categorie_prix_list', za_data.selectLineDetails_categorie);
		menuCategoriePrix.AddChild(mcp_catList);
		// MENU
		// details
		var mcp_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
		menuCategoriePrix.AddChild(mcp_menuDetails);
	return menuCategoriePrix;
}

function za_CreateMenuUtilisateur()
{
	// menu utilisateur
	var menuUtilisateur = new za_Menu_Construct('menu_utilisateur', 'Menu des utilisateurs');
		// select list
		var mu_utList = new  za_SelectList_Construct('select_list_utilisateur', 'Liste des utilisateurs', 10, 'utilisateur_list', za_data.selectLineDetails_utilisateur);
		menuUtilisateur.AddChild(mu_utList);
		// MENU
		// details
		var mu_menuDetails = new za_Menu_Construct('menu_details', 'Détails');
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
	return menuUtilisateur;
}

function za_CreateMenuRecette()
{
	// menu recette
	var menuRecette = new za_Menu_Construct('menu_recette', 'Menu des recettes');
		// select list
		var mr_recList = new  za_SelectList_Construct('select_list_recette', 'Liste des recettes', 10, 'recette_list', za_data.selectLineDetails_recette);
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
		var mc_comList = new  za_SelectList_Construct('select_list_commentaire', 'Liste des commentaires', 10, 'commentaire_list', za_data.selectLineDetails_commentaire);
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

// init menu
function za_InitMenu()
{
	// create menu
	za_data.menu.menu_categorie = za_CreateMenuCategorie();
	za_data.menu.menu_sous_categorie = za_CreateMenuSousCategorie();
	za_data.menu.menu_categorie_diff = za_CreateMenuCategorieDiff();
	za_data.menu.menu_categorie_prix = za_CreateMenuCategoriePrix();
	za_data.menu.menu_utilisateur = za_CreateMenuUtilisateur();
	za_data.menu.menu_recette = za_CreateMenuRecette();
	za_data.menu.menu_commentaire = za_CreateMenuCommentaire();
	
	// init DOM
	var za_section = $('section.section_zone_administration');
	for (var key in za_data.menu)
		za_section.append(za_data.menu[key].DOMElement);
}

/* FIN INIT ***************************************************/


/**************************************************************/
/* DOCUMENT PRET											  */
/**************************************************************/
$(document).ready(function()
{
	// menu
	za_InitMenu();
});
