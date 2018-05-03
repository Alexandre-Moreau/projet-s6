<?php
 
// fichier de langues en chinois

// Index
define("_ACCUEIL","主页");
define("_BIENVENUE","欢迎访问BTG (Better Than Google), 基于概念引用(非单词引用)的多语种语义搜索引擎。");
define("_PROMOTION","在未来几周里，这将成为在互联网上使用最多的革命性搜索引擎");
define("_MORE_INFO","更多信息");
define("_IMPORT_TITLE","Importez votre ontoterminologie");
define("_IMPORT_TEXT","Afin d'utiliser notre site la première étape est d'ajouter une ontoterminologie, vous pouvez importer votre propre ontotermonologie afin d'adapter le site a vos besoins.");
define("_ADD_TITLE","Ajoutez vos articles");
define("_ADD_TEXT","En quelques clics seulement, vous pouvez ajouter vos articles sur le site, ils seront directement référencés par l'ontoterminologie actuelle suivant la langue sélectionné.");
define("_SEARCH_TITLE","Rechercher un concept");
define("_SEARCH_TEXT","Lorsque vous avez importé une ontoterminologie et ajouté vos articles, vous pouvez lancer une recherche !Les recherches se font sur des concepts et pas sur les mot-clés, cela vous permet d'avoir des résultats plus pertinents.");

// Shared
define("_NAME","Name");
define("_FILE","File");
define("_DATABASE","Base de données");
define("_BACKBUTTON","Retour");

// Shared (forms)
define("_FORMSUBMIT","Submit");
define("_FORMRESET","Reset");
define("_FORMCANCEL","Cancel");
define("_FORMREQUESTED","Requested field");
define("_FORMERROR","Errors in form");

// Shared (errors)
define("_ERROR","Error");
define("_NOFILEERROR","No file chosen");
define("_PARSEERROR","Error during parsing (file is not correct)");
define("_ENCODINGERROR","Encoding erro (must be in UTF-8)");
define("_UNKNOWNERROR","Unknown error");
define("_MISSINGINFORM1","no ");
define("_MISSINGINFORM2"," where specified");
function _composeMisingError($m){return _MISSINGINFORM1.strtolower($m)._MISSINGINFORM2;}

// Header
define("_RECHERCHER","搜索");
define("_ARTICLES","文章");
define("_ARTICLES_NEW","新文章");
define("_ONTO_NEW","新的术语");
define("_MAINTENANCE","维护");

// Footer
define("_WHY","BTG由萨瓦大学三年级计算机系实现");
define("_FULL_CODE_1","你可以通过以下链接在GitHub上获取全部代码");
define("_FULL_CODE_2","链接");
define("_ICON","Icon made by");
define("_FROM","from");
define("_VECTOR","Vector images by");

// Search
define("_SEARCH","Search");
define("_CONCEPTS","Concepts");
define("_TERMS","Terms");

// Create article
define("_CREATEARTICLE","Create a new article");
define("_CHOOSENAME","Choose a name");
define("_CHOOSEFILE","Choose file");
define("_LANGUAGE","Language");
define("_OTHERLANGUAGE","other (the text will not be referenced)");
define("_CREATESUCCES","The article was successfully created");
define("_LINKARTICLE","To the article");

// Create onto
define("_CREATEONTO","Create a new ontoterminology");
define("_ASKREPLACE","Are you sure you want to load a new ontoterminology? That will cause the suppression of the last one.");
define("_COMFIRM","Confirmation");

// Show Article
define("_REFERENCE","引用");
define("_EDIT","Edit");
define("_DELETE","Delete");
define("_NO_PDF","This browser does not allow to visualize pdf: ");
define("_PDF_DL","Download pdf");
define("_FILE_NOT_FOUND","File not found on the disk.");
define("_WHY_ERROR"," Go to the Maintenance tab for more information.");

// Edit articles
define("_EDITARTICLE","Edit article");
define("_EDITSUCCES","The article was succesfully edited");

// Maintenance
define("_ONTO","Ontoterminology");
define("_ADVANCED","Advanced");
define("_SYSTEM", "System");
define("_SERVUSER", "Service owner");
define("_NETWORK", "Network");
define("_SERVERIP", "Server IP address");
define("_CLIENTIP", "Client IP address");
define("_ARTICLES_ALL","Overall articles: ");
define("_ARTICLES_NO_REF","Articles not referenced: ");
define("_LOCATION","Location: ");
define("_ERROR_DISK_FILE","Connection errors with disk files: ");
define("_ROOT_NUMBERS","Root number: ");
define("_ERROR_BUILD","Build errors: ");
define("_MISSING_FILES","Files missing on the disk:");
define("_EXCESS_FILES","Files in excess on the disk:");
define("_SERVER_CONNECTION","Connexion au serveur");

?>
