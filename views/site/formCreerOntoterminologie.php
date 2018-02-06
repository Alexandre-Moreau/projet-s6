<?php
	// Le fichier test.xml contient un document XML avec un élément racine
	// et au moins un élément /[racine]/title.

	if (file_exists('sieges.xml')) {
	    $xml = simplexml_load_file('sieges.xml');
	    //var_dump($xml);

	    //	echo "Nombre de concepts: " . count($xml->concept) . "<br/>";
	    //print_r($xml->concept[0]);
	    
	    foreach($xml->concept as $concept){
	    	echo $concept['name'] . "<br/>";
	    }

	} else {
	    exit('Echec lors de l\'ouverture du fichier .xml.');
	}
?>