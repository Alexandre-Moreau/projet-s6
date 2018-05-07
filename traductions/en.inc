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
define("_DATABASE","Base de données");

// Shared (forms)
define("_FORMSUBMIT","Submit");
define("_FORMRESET","Reset");
define("_FORMCANCEL","Cancel");
define("_FORMREQUESTED","Requested field");
define("_FORMERROR","Errors in form");

// Shared (errors)
define("_ERROR","Error");
define("_ERRORFORMHANDLING","Error in form handling");
define("_WATCHLOGS","Watch logs for more information");
define("_NOFILEERROR","No file chosen");
define("_PARSEERROR","Error during parsing (file is not correct)");
define("_ENCODINGERROR","Encoding erro (must be in UTF-8)");
define("_UNKNOWNERROR","Unknown error");
define("_MISSINGINFORM1","No ");
define("_MISSINGINFORM2"," where specified");
function _composeMisingError($m){return _MISSINGINFORM1.strtolower($m)._MISSINGINFORM2;}
define("_ERRORLANGUAGES","No languages found in database");
define("_IMPORTONTO","Try importing an ontoterminology to solve the problem");

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

// Create onto
define("_CREATEONTO","Create a new ontoterminology");
define("_ASKREPLACE","Are you sure you want to load a new ontoterminology? That will cause the suppression of the last one.");

// Show Article
define("_REFERENCE","References");
define("_EDIT","Edit");
define("_DELETE","Delete");

// Edit articles
define("_EDITARTICLE","Edit article");

// Maintenance
define("_ONTO","Ontoterminology");
define("_ADVANCED","Advanced");
define("_SYSTEM", "System");
define("_SERVUSER", "Service owner");
define("_NETWORK", "Network");
define("_SERVERIP", "Server IP address");
define("_CLIENTIP", "Client IP address");

?>