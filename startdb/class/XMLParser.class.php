<?php
	class XMLParser
	{
		// parse XML
		static public function XMLToArray($file)
		{
			$sxi = new SimpleXmlIterator($file, null, true);
			return XMLParser::SxiToArray($sxi);
		}
		
		// private methods
		static private function SxiToArray($sxi)
		{
			$a = array();
			for($sxi->rewind() ; $sxi->valid() ; $sxi->next())
			{
				if(!array_key_exists($sxi->key(), $a))
					$a[$sxi->key()] = array();
				if($sxi->hasChildren())
					$a[$sxi->key()][] = XMLParser::SxiToArray($sxi->current());
				else
					$a[$sxi->key()][] = strval($sxi->current());
			}
			return $a;
		}
	}
	
?>
