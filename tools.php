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
	
function processContent($article){
	if($article->type == "pdf"){
		$parser = new Smalot\PdfParser\Parser();
		$pdf = $parser->parseFile($article->chemin);
		$text = $pdf->getText();
		$text = parseContentPdf($text);
	}elseif($article->type == "html"){
		//Non testé
		$text = file_get_contents($article->chemin);
		// Si le fichier est mal encodé
		if(!mb_detect_encoding($text, 'UTF-8', true)){
			return 'encoding_error';
		}else{
			$text = parseContentHtml($text);
		}
	}elseif($article->type == "txt"){
		$text = file_get_contents($article->chemin);
		if(!mb_detect_encoding($text, 'UTF-8', true)){
			return 'encoding_error';
		}
	}
	return $text;
}

function parseContentPdf($pText){
	//Il faudrait grace à une regex identifier les titres, les identifier grace a des caractères [[titre]] par exemple pour qu'ils montent dans le référencement (1 occurence dans le titre = 2 occurences par exemple)
	//Remplacer les \n par des ' ' pour espacer les titres
	
	$text = str_replace(["'","&#39;"], "' ", $pText); // on ajoute un ' ' derrière les "'" (avec le caractère html)
	$text = preg_replace('/\n+/', '', $text); // on efface les retours à la ligne
	$text = preg_replace('(\(|\))', '', $text); // on efface les parenthèses
	$text = preg_replace('(\.)', '', $text); // on efface les points
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
	
	$text = str_replace(["'","&#39;"], "' ", $text); // on ajoute un ' ' derrière les "'" (avec le caractère html)
	$text = preg_replace('/\n+/', '', $text); // on efface les retours à la ligne
	$text = preg_replace('(\(|\))', '', $text); // on efface les parenthèses
	$text = preg_replace('(\.)', '', $text); // on efface les points
	$textArray = explode(' ', $text);
	$textArray = array_filter($textArray); // on retire les éléments vides du tableau (revient à supprimer les suite d'espace)
	$text = implode(' ', $textArray);
	
	return $text;
}
	
function countWords($text){
	//return str_word_count($text); // ? -> compte bizarrement
	return count(explode(' ', $text));
}

?>
