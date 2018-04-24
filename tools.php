<?php
	
use Fukuball\Jieba\Jieba;
use Fukuball\Jieba\Finalseg;

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

function printJsVar($name, $value){
	// Fonction anonyme récursive
	$printRecursiveJsVar = function($a) use(&$printRecursiveJsVar) {
		if(is_array($a)){
			echo '{';
			foreach($a as $key=>$value){
				echo $key.': ';
				$printRecursiveJsVar($value);
				echo ', ';
			}
			echo '}';
		}else{
			if(is_string($a)){
				echo '\''.$a.'\'';
			}else{
				echo $a;
			}
		}
	};
	echo 'var '.$name.' = ';
	$printRecursiveJsVar($value);
	echo ';';
}

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

function keepOnlyText($pText){
	$text = str_replace(["'","&#39;"], "\' ", $pText); // on ajoute un ' ' derrière les "'" (avec le caractère html)
	$text = preg_replace('/\n+/', '', $text); // on efface les retours à la ligne
	$text = preg_replace('(\(|\))', '', $text); // on efface les parenthèses
	$text = str_replace('.', '' , $text); // on efface les points
	$text = str_replace(',', '' , $text); // on efface les virgules
	return $text;
}
	
function processContent($article){
	$text = 'Error_processContent';
	if($article->type == "pdf"){
		$parser = new Smalot\PdfParser\Parser();
		$pdf = $parser->parseFile($article->chemin);
		$text = $pdf->getText();
		$text = parseContentText($text);
	}else if($article->type == "html"){
		//Non testé
		$text = file_get_contents($article->chemin);
		// Si le fichier est mal encodé
		if(!mb_detect_encoding($text, 'UTF-8', true)){
			return 'encoding_error';
		}else{
			$text = parseContentHtml($text);
		}
	}else if($article->type == "txt"){
		$text = file_get_contents($article->chemin);
		if(!mb_detect_encoding($text, 'UTF-8', true)){
			return 'encoding_error';
		}else{
			$text = parseContentText($text);
		}
	}
	return $text;
}

function parseContentText($pText){
	//Il faudrait grace à une regex identifier les titres, les identifier grace a des caractères [[titre]] par exemple pour qu'ils montent dans le référencement (1 occurence dans le titre = 2 occurences par exemple)
	//Remplacer les \n par des ' ' pour espacer les titres
	
	$text = keepOnlyText($pText);
	$textArray = explode(' ', $text);
	$textArray = array_filter($textArray); // on retire les éléments vides du tableau (revient à supprimer les suite d'espace)
	$text = implode(' ', $textArray);
	return $text;
}

function parseContentHtml($pText){
	//Gérer d'autres trucs que juste le contenu des balises p du body?
	//Gérer les listes peut être
	//Gérer les <h> avec des [[ ]] ( voir parseContentPdf)
	
	// Traitement des erreurs de parsing
	libxml_use_internal_errors(true);
	
	$xml = simplexml_load_string($pText);
	
	if(!$xml) {
		return 'parsing_error';
	}
	
	$text = '';
	foreach($xml->body->p as $p){
		$text .= (string)$p.' ';
	}
	
	$text = keepOnlyText($text);
	$textArray = explode(' ', $text);
	$textArray = array_filter($textArray); // on retire les éléments vides du tableau (revient à supprimer les suite d'espace)
	$text = implode(' ', $textArray);
	
	return $text;
}
	
function countWords($text, $langue){
	//return str_word_count($text); // ? -> compte bizarrement
	if($langue->nom != 'cn'){
		return count(explode(' ', $text));
	}else{
		return count(separeMotsChinois($text));
	}
}

function separeMotsChinois($text){
	ini_set('memory_limit', '1024M');

	Jieba::init();
	Finalseg::init();

	return Jieba::cut($text);
}

?>
