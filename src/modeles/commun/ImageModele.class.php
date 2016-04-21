<?php
	// include
	include_once (dirname(__FILE__) . '/ModeleBase.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/exception/ImageException.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAOUtilisateur.class.php');
	include_once (dirname(__FILE__) . '/../../librairies/dao/DAORecette.class.php');

	// gestionnaire d'image
	class ImageModele extends ModeleBase
	{
		// creation / mise a jour / destruction des images
		public static function ImageUtilisateur($imageInfo, $utilisateur)
		{
			$daoUt = new DAOUtilisateur(parent::GetConnexion());
			return self::ImageDAO($imageInfo, $utilisateur, $daoUt, 'ut');
		}
		
		public static function ImageRecette($imageInfo, $recette)
		{
			$daoRec = new DAORecette(parent::GetConnexion());
			return self::ImageDAO($imageInfo, $recette, $daoRec, 'rec');
		}
		
		
		// private
		private static function ImageDAO($imageInfo, $obj, $dao, $prefix)
		{
			// creation / mise a jour
			if ($imageInfo['error'] == UPLOAD_ERR_OK)
			{
				// verification de l'existance de l'image
				$res = $dao->RetrievePhoto($obj);
				if (is_null($res['photo']))
				{
					// creation de l'image et enregistrement de son nom dans l'utilisateur
					$filename = self::GetUniqFileName($prefix);
					self::CreateImage($imageInfo['tmp_name'], $filename);
					$id = $dao->UpdatePhoto($obj, $filename);
					return $dao->RetrieveById($id);
				}
				else
					// mise a jour de l'image existante
					self::CreateImage($imageInfo['tmp_name'], $res['photo']);
			}
				
			// destruction
			elseif ($imageInfo['error'] == UPLOAD_ERR_NO_FILE)
			{
				// verification de l'existance de l'image
				$res = $dao->RetrievePhoto($obj);
				if (!is_null($res['photo']))
				{
					// destruction de l'image et effacement de son nom dans l'utilisateur
					self::DestroyImage($res['photo']);
					$id = $dao->UpdatePhoto($obj, null);
					return $dao->RetrieveById($id);
				}
			}
				
			return $obj;
		}
		
		private static function CreateImage($source, $dest)
		{
			if (!move_uploaded_file($source, IMAGE_CHEMIN . $dest))
				throw new ImageCreationExcep();
		}
		
		private static function DestroyImage($image)
		{
			unlink(IMAGE_CHEMIN . $image);
		}
		
		private static function GetUniqFileName($prefix)
		{
			return uniqid($prefix . '_', TRUE) . '.png';
		}
		
	}
	