<?php
 
// fichier de langues en anglais

// Index
define("_ACCUEIL","Home");
define("_BIENVENUE","Welcome on the website of our project BTG (Better Than Google), a multilingual semantic search engine based on the referencing of concepts rather than words.");
define("_PROMOTION","Discover the revolutionary search engine which will be the most used of the internet in a couple of weeks...");
define("_MORE_INFO","More informations");

// Shared
define("_NAME","Name");
define("_FILE","File");

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
define("_RECHERCHER","Search");
define("_ARTICLES","Articles");
define("_ARTICLES_NEW","New article");
define("_ONTO_NEW","New ontoterminology");
define("_MAINTENANCE","Maintenance");

// Footer
define("_WHY","BTG is a project realised as a part of our third year of computer science license.");
define("_FULL_CODE_1","The entire code is avaible on GitHub at ");
define("_FULL_CODE_2","this adress");
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
define("_REFERENCE","References");
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
define("_ARTCLES_ALL","Overall articles: ");
define("_ARTICLES_NO_REF","Articles not referenced: ");
define("_LOCATION","Location: ");
define("_ERROR_DISK_FILE","Connection errors with disk files: ");
define("_ROOT_NUMBERS","Root number: ");
define("_ERROR_BUILD","Build errors: ");
define("_MISSING_FILES","Files missing on the disk:");
define("_EXCESS_FILES","Files in excess on the disk:");

?>
