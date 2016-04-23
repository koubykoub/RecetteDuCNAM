
/**************************************************************/
/* INIT														  */
/**************************************************************/
// tab config
function za_TabConfig(sizes, data)
{
	this.sizes = sizes;
	this.data = data;
}

// lists states
function za_ListState()
{
	this.selected = -1;
	this.data = [];
}

// call back
function za_CallBack(evtCB)
{
	var self = this;
	this.subCB = {};
	this.eventCB = evtCB;
	this.cb = function()
	{
		self.eventCB(this);
		for (var title in self.subCB)
			self.subCB[title]();
	}
	this.AddCB = function(title, CB)
	{
		self.subCB[title] = CB;
	}
	this.RemoveCB = function(title)
	{
		delete self.subCB[title];
	}
}

// donnees de la zone d'administration
function za_Data()
{
	// enum
	this.type =
	{
		'CATEGORIE' : 0,
		'SOUS_CATEGORIE' : 1,
		'CATEGORIE_DIFF' : 2,
		'CATEGORIE_PRIX' : 3
	};
	
	// configuration ligne de tableau
	this.tabConfig = [];
	this.tabConfig[this.type.CATEGORIE] = new za_TabConfig([50, 330], ['id', 'intitule']);
	this.tabConfig[this.type.SOUS_CATEGORIE] = new za_TabConfig([50, 50, 280], ['id', 'id_categorie', 'intitule']);
	this.tabConfig[this.type.CATEGORIE_DIFF] = new za_TabConfig([50, 330], ['id', 'intitule']);
	this.tabConfig[this.type.CATEGORIE_PRIX] = new za_TabConfig([50, 330], ['id', 'intitule']);
	
	// etats
	this.listState = [];
	for (var i = 0 ; i < Object.keys(this.type).length ; ++i)
		this.listState[this.listState.length] = new za_ListState();
	
	// call back
	// on change
	this.onChangeCB = [];
	this.onChangeCB[this.type.CATEGORIE] = new za_CallBack(function(obj){za_data.listState[za_data.type.CATEGORIE].selected = $(obj).val();});
	this.onChangeCB[this.type.CATEGORIE].AddCB('load_sous_categorie', za_LoadSousCategorieList);
	this.onChangeCB[this.type.SOUS_CATEGORIE] = new za_CallBack(function(obj){za_data.listState[za_data.type.SOUS_CATEGORIE].selected = $(obj).val();});
	this.onChangeCB[this.type.CATEGORIE_DIFF] = new za_CallBack(function(obj){za_data.listState[za_data.type.CATEGORIE_DIFF].selected = $(obj).val();});
	this.onChangeCB[this.type.CATEGORIE_PRIX] = new za_CallBack(function(obj){za_data.listState[za_data.type.CATEGORIE_PRIX].selected = $(obj).val();});
	
}
var za_data = new za_Data();

function za_Init()
{
	// lists
	// categorie
	za_LoadCategorieList();
	za_GetSelectList('za_menu_categorie').on('change', za_data.onChangeCB[za_data.type.CATEGORIE].cb);
	za_LoadSousCategorieList();
	za_LoadCategorieDiffList();
	za_LoadCategoriePrixList();
}


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
/* SELECT													  */
/**************************************************************/
function za_GetLigneTableau(sizes, data)
{
	var row = $('<div />');
	for (var i = 0 ; i < sizes.length ; ++i)
		row.append($('<div style="width: ' + sizes[i] + 'px"/>').text(data[i]));
	return $('<div />').attr('class', 'za_tableau').append(row);
}

function za_GetSelectOptions(type, data)
{
	var options = [];
	var sizes = za_data.tabConfig[type].sizes;
	var dataTypes = za_data.tabConfig[type].data;
	for (var i = 0 ; i < data.length ; ++i)
	{
		var dataTab = [];
		for (var j = 0 ; j < dataTypes.length ; ++j)
			dataTab[dataTab.length] = data[i][dataTypes[j]];
		var option = $('<option />').attr('value', i).append(za_GetLigneTableau(sizes, dataTab));
		options[options.length] = option;
	}
	return options;
}


/**************************************************************/
/* LISTES													  */
/**************************************************************/
// general
function za_GetSelectList(id)
{
	return $('fieldset#' + id + ' > select');
}

function za_ResetSelectList(id, option)
{
	var select = za_GetSelectList(id);
	select.empty();
	if (option != null)
		select.append($('<option />').text(option));
	return select;
}

// categorie
function za_LoadCategorieList_Loaded(resp)
{
	var select = za_ResetSelectList('za_menu_categorie', null);
	za_data.listState[za_data.type.CATEGORIE].data = JSON.parse(resp);
	select.append(za_GetSelectOptions(za_data.type.CATEGORIE, za_data.listState[za_data.type.CATEGORIE].data));
}
function za_LoadCategorieList_LoadeError(resp)
{
	var select = za_ResetSelectList('za_menu_categorie', 'Erreur de chargement\n' + resp);
}
function za_LoadCategorieList()
{
	var select = za_ResetSelectList('za_menu_categorie', 'chargement...');
	za_Ajax('categorie_list', {}, za_LoadCategorieList_Loaded, za_LoadCategorieList_LoadeError);
}

// sous categorie
function za_LoadSousCategorieList_Loaded(resp)
{
	var select = za_ResetSelectList('za_menu_sous_categorie', null);
	za_data.listState[za_data.type.SOUS_CATEGORIE].data = JSON.parse(resp);
	select.append(za_GetSelectOptions(za_data.type.SOUS_CATEGORIE, za_data.listState[za_data.type.SOUS_CATEGORIE].data));
}
function za_LoadSousCategorieList_LoadeError(resp)
{
	var select = za_ResetSelectList('za_menu_sous_categorie', 'Erreur de chargement\n' + resp);
}
function za_LoadSousCategorieList()
{
	var select = za_ResetSelectList('za_menu_sous_categorie', 'chargement...');
	if (za_data.listState[za_data.type.CATEGORIE].selected != -1)
		za_Ajax('sous_categorie_list', {'id_categorie' : za_data.listState[za_data.type.CATEGORIE].data[za_data.listState[za_data.type.CATEGORIE].selected].id}, za_LoadSousCategorieList_Loaded, za_LoadSousCategorieList_LoadeError);
}

// categorie difficulte
function za_LoadCategorieDiffList_Loaded(resp)
{
	var select = za_ResetSelectList('za_menu_categorie_diff', null);
	za_data.listState[za_data.type.CATEGORIE_DIFF].data = JSON.parse(resp);
	select.append(za_GetSelectOptions(za_data.type.CATEGORIE_DIFF, za_data.listState[za_data.type.CATEGORIE_DIFF].data));
}
function za_LoadCategorieDiffList_LoadeError(resp)
{
	var select = za_ResetSelectList('za_menu_categorie_diff', 'Erreur de chargement\n' + resp);
}
function za_LoadCategorieDiffList()
{
	var select = za_ResetSelectList('za_menu_categorie_diff', 'chargement...');
	za_Ajax('categorie_diff_list', {}, za_LoadCategorieDiffList_Loaded, za_LoadCategorieDiffList_LoadeError);
}

//categorie prix
function za_LoadCategoriePrixList_Loaded(resp)
{
	var select = za_ResetSelectList('za_menu_categorie_prix', null);
	za_data.listState[za_data.type.CATEGORIE_PRIX].data = JSON.parse(resp);
	select.append(za_GetSelectOptions(za_data.type.CATEGORIE_PRIX, za_data.listState[za_data.type.CATEGORIE_PRIX].data));
}
function za_LoadCategoriePrixList_LoadeError(resp)
{
	var select = za_ResetSelectList('za_menu_categorie_prix', 'Erreur de chargement\n' + resp);
}
function za_LoadCategoriePrixList()
{
	var select = za_ResetSelectList('za_menu_categorie_prix', 'chargement...');
	za_Ajax('categorie_prix_list', {}, za_LoadCategoriePrixList_Loaded, za_LoadCategoriePrixList_LoadeError);
}


/**************************************************************/
/* DOCUMENT PRET											  */
/**************************************************************/
$(document).ready(function()
{
	// init zone d'administration
	za_Init();
});
