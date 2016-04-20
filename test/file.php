<?php
	if (isset($_FILES['avatar']))
	{ 
	     /*$dossier = 'upload/';
	     $fichier = basename($_FILES['avatar']['name']);
	     if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
	     {
	          echo 'Upload effectué avec succès !';
	     }
	     else //Sinon (la fonction renvoie FALSE).
	     {
	          echo 'Echec de l\'upload !';
	     }*/
		
		
		/*$dir = 'upload/';
		$fileName = $_FILES['avatar']['name'];
		$message = 'Fichier trouve : '.$fileName.'<br />';
		if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dir . $fileName)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
		{
			$message .= 'Upload effectué avec succès !';
		}
		else //Sinon (la fonction renvoie FALSE).
		{
			$message .= 'Echec de l\'upload !';
		}*/
		
		
		
		
		$name = $_FILES['avatar']['name'];
		$type = $_FILES['avatar']['type'];
		$size = $_FILES['avatar']['size'];
		$tmp_name = $_FILES['avatar']['tmp_name'];
		$error = $_FILES['avatar']['error'];
		
		$message = 'name : ' . $name . '<br />';
		$message .= 'type : ' . $type . '<br />';
		$message .= 'size : ' . $size . '<br />';
		$message .= 'tmp_name : ' . $tmp_name . '<br />';
		$message .= 'error : ' . $error . '<br />';
		$message .= 'upload : ' . is_uploaded_file($_FILES['avatar']['tmp_name']) . '<br />';
		
		
		//if(move_uploaded_file($_FILES['avatar']['tmp_name'], 'upload/file.txt')) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
		//if (copy($_FILES['avatar']['tmp_name'], 'upload/file.txt')) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
		
		$success = FALSE;
		$handle = fopen($_FILES['avatar']['tmp_name'], 'r');
		if ($stream === FALSE)
			$message .= 'Echec de l\'upload !<br />';
		else
		{
			$success = TRUE;
			$message .= 'Upload effectué avec succès !<br />';
			
			//image
			fclose($handle);
		}
	}
	else 
	{
		$message = 'Fichier non trouve !';
	}
	$message .= '<br />';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Contenu du fichier</title>
</head>

<body>

	<!-- message -->
	<p>
	<?php echo $message; ?>
	<?php if ($success) { ?>
	<?php echo stream_get_contents($handle); ?>
	<?php } ?>
	</p>
	
	<!-- retour a l'index -->
	<form method="POST" action="index.html" enctype="multipart/form-data">
	     <input type="submit" name="envoyer" value="Retour au menu">
	</form>
	
</body>
</html>
