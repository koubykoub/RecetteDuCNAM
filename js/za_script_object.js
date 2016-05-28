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
	this.parentCB = {};
	this.CreateDOMElementBase();
	this.SetDOMElement();
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

// parent
za_ElementBase_Construct.prototype.AddParentCB = function(key, parent, cb)
{
	var newCB =
	{
			parent : parent,
			cb : cb
	};
	this.parentCB[key] = newCB;
};

za_ElementBase_Construct.prototype.InitSelectedParents = function()
{
	// parent call backs
	for (var key in this.parentCB)
	{
		var parentCB = this.parentCB[key];
		if (parentCB.parent.enabled)
			parentCB.cb(this, parentCB.parent);
	}
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
	za_ElementBase_Construct.call(this, name, fsName);
	this.opened = false;
	this.elements = {};
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
};

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


/* SELECT LIST ************************************************/
//constructor
var za_SelectList_Construct = function(name, fsName, size, width, type, header)
{
	// attributs
	this.size = size;
	this.width = width;
	this.type = type;
	this.header = header;
	this.alone = true;
	this.data = [];
	this.ajaxData = {};
	this.selectedOption = -1;
	this.selectCB = {};
	za_ElementBase_Construct.call(this, name, fsName);
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
			selectCB.cb(selectCB.element, this);
	}
};

za_SelectList_Construct.prototype.AddSelectCB = function(key, element, cb)
{
	var newCB =
	{
			element : element,
			cb : cb
	};
	this.selectCB[key] = newCB;
};

za_SelectList_Construct.prototype.ParentSelected = function(parent, parentName, name, ajax = true)
{
	var id = parent.selectedOption;
	if (!id || (id == -1))
		this.ValueSelected(-1, name, ajax);
	else if (id && (id != -1))
		this.ValueSelected(parent.data[id][parentName], name, ajax);
	this.Select(-1);
};

za_SelectList_Construct.prototype.ValueSelected = function(val, name, ajax)
{
	this.AddSelection(val, name);
	if (ajax)
	{
		this.data = [];
		this.Ajax();
	}
};

za_SelectList_Construct.prototype.AddSelection = function(val, name)
{
	if ((!val || (val == -1)) && this.ajaxData[name])
		delete this.ajaxData[name];
	else if (val && (val != -1))
		this.ajaxData[name] = val;
};

za_SelectList_Construct.prototype.GetSelectedValue = function()
{
	if (this.selectedOption != -1)
		return this.data[this.selectedOption];
	return null;
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
};

//DOM
za_SelectList_Construct.prototype.SetDOMElement = function()
{
	var self = this;
	var select = $('<select />').attr('size', this.size).attr('multiple', 'multiple').attr('class', 'za_salect_list').css('width', this.width)
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
		select.append($('<option />').attr('value', -1).css('width', this.width).text(message));
};

za_SelectList_Construct.prototype.InitSelectData = function()
{
	this.InitSelect(null);
	var select = this.DOMElement.find('> select');
	select.append($('<option />').attr('value', -1).css('width', this.width).append(this.CreateTabLineHeader()));
	for (var i = 0 ; i < this.data.length ; ++i)
		select.append($('<option />').attr('value', i).css('width', this.width).append(this.CreateTabLine(i)));
};

za_SelectList_Construct.prototype.CreateTabLineHeader = function()
{
	var row = $('<div />');
	for (var i = 0 ; i < this.header.length ; ++i)
	{
		row.append($('<div />').css('max-width', this.header[i].size + 'px').css('min-width', this.header[i].size + 'px')
							   .css('font-weight', 'bold')
							   .css('font-style', 'italic')
							   .css('height', 22)
							   .css('font-size', '1.2em')
							   .text(this.header[i].type));
	}
	return $('<div />').attr('class', 'za_tableau').append(row);
};

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
};

/* FIN SELECT LIST ********************************************/


/* DETAILS ****************************************************/

/* BASE *******************************************************/
//constructor
var za_Details_Construct = function(name, fsName)
{
	// attributs
	za_ElementBase_Construct.call(this, name, fsName);
};
za_ExtendClass(za_Details_Construct, za_ElementBase_Construct);

// value
za_Details_Construct.prototype.SetValue = function(val)
{
	this.SetDOMValue(val);
};

//enable / disable
za_Details_Construct.prototype.Enable = function()
{
	this.EnableBase();
	this.InitSelectedParents();
};

za_Details_Construct.prototype.Disable = function()
{
	this.DisableBase();
};

//DOM
za_Details_Construct.prototype.SetDOMValue = function(val)
{
	if (val && (val != null))
		this.SetDOMWithValue(val);
	else
		this.SetDOMWithoutValue();
};

/* FIN BASE ***************************************************/

/* CATEGORIE **************************************************/
//constructor
var za_CategorieDetails_Construct = function(name, fsName)
{
	za_Details_Construct.call(this, name, fsName);
};
za_ExtendClass(za_CategorieDetails_Construct, za_Details_Construct);

//DOM
za_CategorieDetails_Construct.prototype.GetIdInput = function()
{
	var nid = this.name + '_detail_id';
	var inputId = this.DOMElement.find('input#' + nid);
	return inputId;
}

za_CategorieDetails_Construct.prototype.GetIntituleInput = function()
{
	var nint = this.name + '_detail_intitule';
	var inputIntitule = this.DOMElement.find('input#' + nint);
	return inputIntitule;
}

za_CategorieDetails_Construct.prototype.SetDOMElement = function()
{
	var nid = this.name + '_detail_id';
	var nint = this.name + '_detail_intitule';
	var idInput = $('<input />').attr('type', 'text').attr('readonly', 'readonly').attr('id', nid);
	var intituleInput = $('<input />').attr('type', 'text').attr('id', nint);
	this.DOMElement.append('id : ').append(idInput).append($('<br />'));
	this.DOMElement.append('intitule : ').append(intituleInput);
};

za_CategorieDetails_Construct.prototype.SetDOMWithValue = function(val)
{
	var idInput = this.GetIdInput();
	var intituleInput = this.GetIntituleInput();
	idInput.val(val.id);
	intituleInput.val(val.intitule);
};

za_CategorieDetails_Construct.prototype.SetDOMWithoutValue = function()
{
	var idInput = this.GetIdInput();
	var intituleInput = this.GetIntituleInput();
	idInput.val('');
	intituleInput.val('');
};

/* FIN CATEGORIE **********************************************/

/* SOUS CATEGORIE *********************************************/
//constructor
var za_SousCategorieDetails_Construct = function(name, fsName)
{
	za_CategorieDetails_Construct.call(this, name, fsName);
};
za_ExtendClass(za_SousCategorieDetails_Construct, za_CategorieDetails_Construct);

// value
za_CategorieDetails_Construct.prototype.GetIdCategorieInput = function()
{
	var nidc = this.name + '_detail_id_categorie';
	var idcInput = this.DOMElement.find('input#' + nidc);
	return idcInput;
}

//DOM
za_SousCategorieDetails_Construct.prototype.SetDOMElement = function()
{
	var nid = this.name + '_detail_id';
	var nidc = this.name + '_detail_id_categorie';
	var nint = this.name + '_detail_intitule';
	var inputId = $('<input />').attr('type', 'text').attr('readonly', 'readonly').attr('id', nid);
	var inputIdc = $('<input />').attr('type', 'text').attr('readonly', 'readonly').attr('id', nidc);
	var inputIntitule = $('<input />').attr('type', 'text').attr('id', nint);
	this.DOMElement.append('id : ').append(inputId).append($('<br />'));
	this.DOMElement.append('id catégorie : ').append(inputIdc).append($('<br />'));
	this.DOMElement.append('intitule : ').append(inputIntitule);
};

za_SousCategorieDetails_Construct.prototype.SetDOMWithValue = function(val)
{
	var idInput = this.GetIdInput();
	var idcInput = this.GetIdCategorieInput();
	var intituleInput = this.GetIntituleInput();
	idInput.val(val.id);
	idcInput.val(val.id_categorie);
	intituleInput.val(val.intitule);
};

za_SousCategorieDetails_Construct.prototype.SetDOMWithoutValue = function()
{
	var idInput = this.GetIdInput();
	var idcInput = this.GetIdCategorieInput();
	var intituleInput = this.GetIntituleInput();
	idInput.val('');
	idcInput.val('');
	intituleInput.val('');
};

/* FIN SOUS CATEGORIE *****************************************/

/* UTILISATEUR ************************************************/
//constructor
var za_UtilisateurDetails_Construct = function(name, fsName)
{
	za_Details_Construct.call(this, name, fsName);
};
za_ExtendClass(za_UtilisateurDetails_Construct, za_Details_Construct);

//DOM
za_UtilisateurDetails_Construct.prototype.GetIdInput = function()
{
	var nid = this.name + '_detail_id';
	var idInput = this.DOMElement.find('input#' + nid);
	return idInput;
}

za_UtilisateurDetails_Construct.prototype.GetLoginInput = function()
{
	var nlog = this.name + '_detail_login';
	var loginInput = this.DOMElement.find('input#' + nlog);
	return loginInput;
}

za_UtilisateurDetails_Construct.prototype.GetMDPInput = function()
{
	var nmdp = this.name + '_detail_mdp';
	var mdpInput = this.DOMElement.find('input#' + nmdp);
	return mdpInput;
}

za_UtilisateurDetails_Construct.prototype.GetNomInput = function()
{
	var nn = this.name + '_detail_nom';
	var nomInput = this.DOMElement.find('input#' + nn);
	return nomInput;
}

za_UtilisateurDetails_Construct.prototype.GetPrenomInput = function()
{
	var npn = this.name + '_detail_prenom';
	var prenomInput = this.DOMElement.find('input#' + npn);
	return prenomInput;
}

za_UtilisateurDetails_Construct.prototype.GetEmailInput = function()
{
	var nem = this.name + '_detail_email';
	var emailInput = this.DOMElement.find('input#' + nem);
	return emailInput;
}

za_UtilisateurDetails_Construct.prototype.GetDateInput = function()
{
	var nd = this.name + '_detail_date';
	var dateInput = this.DOMElement.find('input#' + nd);
	return dateInput;
}

za_UtilisateurDetails_Construct.prototype.GetPhotoInput = function()
{
	var np = this.name + '_detail_photo';
	var photoInput = this.DOMElement.find('input#' + np);
	return photoInput;
}

za_UtilisateurDetails_Construct.prototype.GetAdminInput = function()
{
	var na = this.name + '_detail_admin';
	var adminInput = this.DOMElement.find('input#' + na);
	return adminInput;
}

za_UtilisateurDetails_Construct.prototype.SetDOMElement = function()
{
	// name id
	var nid = this.name + '_detail_id';
	var nlog = this.name + '_detail_login';
	var nmdp = this.name + '_detail_mdp';
	var nn = this.name + '_detail_nom';
	var npn = this.name + '_detail_prenom';
	var nem = this.name + '_detail_email';
	var nd = this.name + '_detail_date';
	var np = this.name + '_detail_photo';
	var na = this.name + '_detail_admin';
	
	// create input
	var idInput = $('<input />').attr('type', 'text').attr('readonly', 'readonly').attr('id', nid);
	var loginInput = $('<input />').attr('type', 'text').attr('id', nlog);
	var mdpInput = $('<input />').attr('type', 'text').attr('id', nmdp);
	var nomInput = $('<input />').attr('type', 'text').attr('id', nn);
	var prenomInput = $('<input />').attr('type', 'text').attr('id', npn);
	var emailInput = $('<input />').attr('type', 'text').attr('id', nem);
	var dateInput = $('<input />').attr('type', 'text').attr('readonly', 'readonly').attr('id', nd);
	var photoInput = $('<input />').attr('type', 'text').attr('readonly', 'readonly').attr('id', np);
	var adminInput = $('<input />').attr('type', 'text').attr('readonly', 'readonly').attr('id', na);
	
	// set DOM
	this.DOMElement.append('id : ').append(idInput).append($('<br />'));
	this.DOMElement.append('login : ').append(loginInput).append($('<br />'));
	this.DOMElement.append('mdp : ').append(mdpInput).append($('<br />'));
	this.DOMElement.append('nom : ').append(nomInput).append($('<br />'));
	this.DOMElement.append('prenom : ').append(prenomInput).append($('<br />'));
	this.DOMElement.append('email : ').append(emailInput).append($('<br />'));
	this.DOMElement.append('date : ').append(dateInput).append($('<br />'));
	this.DOMElement.append('photo : ').append(photoInput).append($('<br />'));
	this.DOMElement.append('admin : ').append(adminInput).append($('<br />'));
};

za_UtilisateurDetails_Construct.prototype.SetDOMWithValue = function(val)
{
	// get inputs
	var idInput = this.GetIdInput();
	var loginInput = this.GetLoginInput();
	var mdpInput = this.GetMDPInput();
	var nomInput = this.GetNomInput();
	var prenomInput = this.GetPrenomInput();
	var emailInput = this.GetEmailInput();
	var dateInput = this.GetDateInput();
	var photoInput = this.GetPhotoInput();
	var adminInput = this.GetAdminInput();
	
	// fill inputs
	idInput.val(val.id);
	loginInput.val(val.login);
	mdpInput.val(val.mdp);
	nomInput.val(val.nom);
	prenomInput.val(val.prenom);
	emailInput.val(val.email ? val.email : '');
	dateInput.val(val.date_inscription);
	photoInput.val(val.photo ? val.photo : '');
	adminInput.val(val.admin);
};

za_UtilisateurDetails_Construct.prototype.SetDOMWithoutValue = function()
{
	// get inputs
	var idInput = this.GetIdInput();
	var loginInput = this.GetLoginInput();
	var mdpInput = this.GetMDPInput();
	var nomInput = this.GetNomInput();
	var prenomInput = this.GetPrenomInput();
	var emailInput = this.GetEmailInput();
	var dateInput = this.GetDateInput();
	var photoInput = this.GetPhotoInput();
	var adminInput = this.GetAdminInput();
	
	// fill inputs
	idInput.val('');
	loginInput.val('');
	mdpInput.val('');
	nomInput.val('');
	prenomInput.val('');
	emailInput.val('');
	dateInput.val('');
	photoInput.val('');
	adminInput.val('');
};

/* FIN UTILISATEUR ********************************************/

/* FIN DETAILS ************************************************/
