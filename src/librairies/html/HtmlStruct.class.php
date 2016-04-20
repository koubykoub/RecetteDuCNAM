<?php
	class HtmlStruct
	{
		// balises principales
		public static function DebutHtml($titre, array $styles, array $scripts)
		{
			?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $titre; ?></title>
		
		<!-- style -->
		<?php foreach ($styles as $css) { ?>
			<link type="text/css" rel="stylesheet" href="<?php echo $css; ?>" />
		<?php } ?>
		
		<!-- scripts -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<?php foreach ($scripts as $js) { ?>
			<script type="text/javascript" src="<?php echo $js; ?>"></script>
		<?php } ?>
	</head>

	<body>
			<?php
		}
		
		public static function DebutHeader($class = null)
		{
			echo '
			<header' . self::GetAttrStr('class', $class) . '>
			';
		}
		public static function FinHeader($clear = false)
		{
			echo '
			</header>' . ($clear ? '<br clear="all" />' : '') .'
			';
		}
		
		public static function DebutSection($class = null)
		{
			echo '
			<section' . self::GetAttrStr('class', $class) . '>
			';
		}
		public static function FinSection($clear = false)
		{
			echo '
			</section>' . ($clear ? '<br clear="all" />' : '') .'
			';
		}
		
		public static function DebutFooter($class = null)
		{
			echo '
			<footer' . self::GetAttrStr('class', $class) . '>
			';
		}
		public static function FinFooter($clear = false)
		{
			echo '
			</footer>' . ($clear ? '<br clear="all" />' : '') .'
			';
		}
		
		public static function DebutArticle($class = null)
		{
			echo '
			<article' . self::GetAttrStr('class', $class) . '>
			';
		}
		public static function FinArticle($clear = false)
		{
			echo '
			</article>' . ($clear ? '<br clear="all" />' : '') .'
			';
		}
		
		public static function DebutNav($class = null)
		{
			echo '
			<nav' . self::GetAttrStr('class', $class) . '>
			';
		}
		public static function FinNav($clear = false)
		{
			echo '
			</nav>' . ($clear ? '<br clear="all" />' : '') .'
			';
		}
		
		public static function DebutDiv($class = null)
		{
			echo '
			<div' . self::GetAttrStr('class', $class) . '>
			';
		}
		public static function FinDiv($clear = false)
		{
			echo '
			</div>' . ($clear ? '<br clear="all" />' : '') .'
			';
		}
		
		public static function Titre($size, $titre, $class = null)
		{
			echo '
			<h' . $size . self::GetAttrStr('class', $class) . '>' . $titre . '</h' . $size . '>
			';
		}
		
		public static function FinHtml()
		{
			?>
	</body>
</html>
			<?php
		}
		
		
		// fonctions utilitaires
		private static function GetAttrStr($attrName, $attr)
		{
			return is_null($attr) ? '' : ' ' . $attrName . '="' . $attr . '"';
		}
		
	}
	
?>
