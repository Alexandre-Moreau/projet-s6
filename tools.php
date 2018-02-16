<?php

/*function __autoload($name) {
	echo "|".$name.",";
	if (strpos($name,'Controller') !== FALSE){
		$dir = 'controllers\\';
		$file = $name;
	}else{
		$dir = substr($name, 0,strrpos($name, '\\')).'\\';
		$file = explode('\\', $name)[1] ;
	}
	if (strpos($name,'Model') !== FALSE){
		$dir = 'models\\';
	}
	if (explode("\\", $name)[0] == "root"){
		$dir = "";
		$name = substr($name, strpos($name, "\\") + 1);
	}
	include_once $dir.lcfirst($file).".php";
}*/

function cleanString($text) {
	//https://stackoverflow.com/questions/14114411/remove-all-special-characters-from-a-string
    $utf8 = array(
        '/[áàâãªä]/u'   =>   'a',
        '/[ÁÀÂÃÄ]/u'    =>   'A',
        '/[ÍÌÎÏ]/u'     =>   'I',
        '/[íìîï]/u'     =>   'i',
        '/[éèêë]/u'     =>   'e',
        '/[ÉÈÊË]/u'     =>   'E',
        '/[óòôõºö]/u'   =>   'o',
        '/[ÓÒÔÕÖ]/u'    =>   'O',
        '/[úùûü]/u'     =>   'u',
        '/[ÚÙÛÜ]/u'     =>   'U',
        '/ç/'           =>   'c',
        '/Ç/'           =>   'C',
        '/ñ/'           =>   'n',
        '/Ñ/'           =>   'N',
        '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
        '/[’‘‹›‚]/u'    =>   '', // Literally a single quote
        '/[“”«»„]/u'    =>   '', // Double quote
        '/ /'           =>   '', // nonbreaking space (equiv. to 0x160)
    );
    return preg_replace(array_keys($utf8), array_values($utf8), $text);
}

?>
