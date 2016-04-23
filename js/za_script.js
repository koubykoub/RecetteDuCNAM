/**************************************************************/
/* ZONE D'ADMINISTRATION									  */
/**************************************************************/
// init
function za_init()
{
	$('#zone_administration').jstree(
	{
		'core' : {'data' :
		[
		 	// categories
		 	{
		 		'text' : 'Catégories',
		 		'children' :
		 		[
		 		 	// categorie
		 		 	{
		 		 		'text' : 'Catégories',
		 		 	},
		 		 	
		 		 	// categorie difficulte
		 		 	{
		 		 		'text' : 'Catégories de difficulté'
		 		 	},
		 		 	
		 		 	// categorie prix
		 		 	{
		 		 		'text' : 'Catégories de prix'
		 		 	}
		 		 ]
		 	},
		      
		 	// utilisateurs
		 	{
		 		'text' : 'Utilisateurs',
		 		'id' : 'utilisateur'
		 	},
		 	
		 	// recettes
		 	{
		 		'text' : 'Recettes'
		 	},
		 	
		 	// commentaires
		 	{
		 		'text' : 'Commentaires'
		 	}
	    ]}
	});
	
	$('#zone_administration2').jstree(
	{
		'core' : {'data' :
		[
		 	// categories
		 	{
		 		'text' : 'Catégories',
		 		'children' :
		 		[
		 		 	// categorie
		 		 	{
		 		 		'text' : 'Catégories',
		 		 	},
		 		 	
		 		 	// categorie difficulte
		 		 	{
		 		 		'text' : 'Catégories de difficulté'
		 		 	},
		 		 	
		 		 	// categorie prix
		 		 	{
		 		 		'text' : 'Catégories de prix'
		 		 	}
		 		 ]
		 	},
		      
		 	// utilisateurs
		 	{
		 		'text' : 'Utilisateurs',
		 		'id' : 'utilisateur'
		 	},
		 	
		 	// recettes
		 	{
		 		'text' : 'Recettes'
		 	},
		 	
		 	// commentaires
		 	{
		 		'text' : 'Commentaires'
		 	}
	    ]}
	});
	
	$('#zone_administration').on("changed.jstree", function (e, data) {
	    console.log("The selected nodes are:");
	    console.log(data.selected);
	    $('li#utilisateur').append($('<div />').attr('id', 'div_utilisateur'));
	    $('#div_utilisateur').jstree(
		{
			'core' : {'data' :
			[
			 	// utilisateurs
			 	{
			 		'text' : 'Utilisateurs',
			 		'id' : 'x'
			 	},
			 	
			 	// recettes
			 	{
			 		'text' : 'Recettes',
			 		'id' : 'y'
			 	},
			 	
			 	// commentaires
			 	{
			 		'text' : 'Commentaires',
			 		'id' : 'z'
			 	}
		    ]}
		});
	});
	
	
}

function za_init2()
{
	$.jstree.plugins.addHTML = function (options, parent) {
	    this.redraw_node = function(obj, deep,
	                                callback, force_draw) {
	        obj = parent.redraw_node.call(
	            this, obj, deep, callback, force_draw
	        );
	        if (obj) {
	            var node = this.get_node(jQuery(obj).attr('id'));
	            if (node && 
	                node.data &&
	                ( "addHTML" in node.data ) ) {
	                jQuery(obj).append(
	                    "<div style='margin-left: 50px'>" +
	                        node.data.addHTML +
	                    "</div>"
	                );
	            }
	        }
	        return obj;
	    };
	};
	$.jstree.defaults.addHTML = {};
	
	var div2 = $('<div />').attr('id', 'za2').jstree(
	{
		'core' : {'data' :
		[
		 	// utilisateurs
		 	{
		 		'text' : 'Utilisateurs',
		 	},
		 	
		 	// recettes
		 	{
		 		'text' : 'Recettes'
		 	},
		 	
		 	// commentaires
		 	{
		 		'text' : 'Commentaires'
		 	}
	    ]}
	});
	
	var div = $('<div />').attr('id', 'za').jstree(
	{
		'core' : {'data' :
		[
		 	// categories
		 	{
		 		'text' : 'Catégories',
		 		'children' :
		 		[
		 		 	// categorie
		 		 	{
		 		 		'text' : 'Catégories',
		 		 	},
		 		 	
		 		 	// categorie difficulte
		 		 	{
		 		 		'text' : 'Catégories de difficulté'
		 		 	},
		 		 	
		 		 	// categorie prix
		 		 	{
		 		 		'text' : 'Catégories de prix'
		 		 	}
		 		 ]
		 	},
		      
		 	// utilisateurs
		 	{
		 		'text' : 'Utilisateurs',
		 		'data' :
		 		{
		 			'addHTML' : div2
		 		}
		 	},
		 	
		 	// recettes
		 	{
		 		'text' : 'Recettes'
		 	},
		 	
		 	// commentaires
		 	{
		 		'text' : 'Commentaires'
		 	}
	    ]}
	});
	
	
	
	$('#zone_administration').append(div);
}

function za_init3()
{
	multiLineMarkup='<div id="markup"></div><div>of</div><div>markup</div>';

	data = [
	    {text: "My Node", data: {addHTML: "some HTML to append"}},
	    {text: "My Node", data: {addHTML: multiLineMarkup}},
	    {text: "My Parent Node", data: {addHTML: "$10"}, children: [
	            {text: "My child Node",
	             data: {addHTML: multiLineMarkup},
	             id: "aChild"},
	            {text: "My child Node", data: {addHTML: "foobar"}}
	        ]
	    },
	    {text: "No addHTML in data", data: {}},
	    {text: "No data"},
	    {text: "Zero (false) value addHTML", data: { addHTML: 0}},
	    {text: "My Node", data: {addHTML: "$10"}}
	];

	$.jstree.plugins.addHTML = function (options, parent) {
	    this.redraw_node = function(obj, deep,
	                                callback, force_draw) {
	        obj = parent.redraw_node.call(
	            this, obj, deep, callback, force_draw
	        );
	        if (obj) {
	            var node = this.get_node(jQuery(obj).attr('id'));
	            if (node && 
	                node.data &&
	                ( "addHTML" in node.data ) ) {
	                jQuery(obj).append(
	                    "<div style='margin-left: 50px'>" +
	                        node.data.addHTML +
	                    "</div>"
	                );
	            }
	        }
	        return obj;
	    };
	};

	$.jstree.defaults.addHTML = {};

	$("#zone_administration").jstree({
	    plugins: ["addHTML"],
	    core : {
	        'data' : data,
	        themes: {
	            responsive: false,
	        }
	    }
	});

	
	var div = $('<div />').attr('id', 'za').jstree(
	{
		'core' : {'data' :
		[
		 	// categories
		 	{
		 		'text' : 'Catégories',
		 		'children' :
		 		[
		 		 	// categorie
		 		 	{
		 		 		'text' : 'Catégories',
		 		 	},
		 		 	
		 		 	// categorie difficulte
		 		 	{
		 		 		'text' : 'Catégories de difficulté'
		 		 	},
		 		 	
		 		 	// categorie prix
		 		 	{
		 		 		'text' : 'Catégories de prix'
		 		 	}
		 		 ]
		 	},
		      
		 	// utilisateurs
		 	{
		 		'text' : 'Utilisateurs'
		 	},
		 	
		 	// recettes
		 	{
		 		'text' : 'Recettes'
		 	},
		 	
		 	// commentaires
		 	{
		 		'text' : 'Commentaires'
		 	}
	    ]}
	});
	div2 = $(div).clone();
	$('#zone_administration2').append(div);
	$('#zone_administration3').append(div2);
	$('#markup').append($(div).clone());
}


/**************************************************************/
/* DOCUMENT PRET											  */
/**************************************************************/
$(document).ready(function()
{
	// init zone d'administration
	//za_init();
	//za_init2();
	//za_init3();
});
