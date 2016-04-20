<?php
	if (isset($_FILES['avatar']))
	{
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
		
		$success = FALSE;
		if (!$error)
		{
			/*$handle = fopen($_FILES['avatar']['tmp_name'], 'rb');
			$handle2 = fopen(dirname(__FILE__).'/image.png', 'wb');
			fwrite($handle2, fread($handle, filesize($_FILES['avatar']['tmp_name'])));
			fclose($handle);
			fclose($handle2);*/
			
			if (move_uploaded_file($_FILES['avatar']['tmp_name'], 'image.png'))
			{
				$message .= 'image déplacée<br />';
				$success = TRUE;
			}
		}
		
		/*$success = FALSE;
		$handle = fopen($_FILES['avatar']['tmp_name'], 'r');
		if ($stream === FALSE)
			$message .= 'Echec de l\'upload !<br />';
		else
		{
			$success = TRUE;
			$message .= 'Upload effectué avec succès !<br />';
			
			//image
			fclose($handle);
		}*/
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
	<img alt="" src="getImage.php">
	<?php } ?>
	</p>
	
	<!-- retour a l'index -->
	<form method="POST" action="index.html" enctype="multipart/form-data">
	     <input type="submit" name="envoyer" value="Retour au menu">
	</form>
	
</body>
</html>
