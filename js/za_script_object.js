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
