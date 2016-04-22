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
	
	$('#zone_administration').on("changed.jstree", function (e, data) {
	    console.log("The selected nodes are:");
	    console.log(data.selected);
	  });
}

function test()
{
	$('#zone_administration').jstree(
	{
		'core' : {'data' :
		{
			'url' : '//www.jstree.com/fiddle/',
			"data" : function (node) {
		          return { "id" : node.id };
		        }
	 	}
	}});
}

/**************************************************************/
/* DOCUMENT PRET											  */
/**************************************************************/
$(document).ready(function()
{
	// init zone d'administration
	za_init();
});
