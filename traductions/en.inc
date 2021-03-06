<?php
 
// fichier de langues en anglais

// Index
define("_ACCUEIL","Home");
define("_BIENVENUE","Welcome on the website of our project BTG (Better Than Google), a multilingual semantic search engine based on the referencing of concepts rather than words.");
define("_PROMOTION","Discover the revolutionary search engine which will be the most used of the internet in a couple of weeks...");
define("_MORE_INFO","More informations");
define("_IMPORT_TITLE","Import your ontoterminology");
define("_IMPORT_TEXT","To use our website the first step is to import an ontoterminology, you can import your own ontoterminology to adapt the website as you need.");
define("_ADD_TITLE","Add your articles");
define("_ADD_TEXT","In a few clicks only, you can add your articles on the website, they will be directly referenced by the current ontoterminology according to the selected language.");
define("_SEARCH_TITLE","Search a concept");
define("_SEARCH_TEXT","When you have imported your ontoterminology and added your articles, you can start a search! The searches are done by concept and not with the keywords, it will allows you to have better searches results.");

// Shared
define("_NAME","Name");
define("_FILE","File");
define("_DATABASE","Database");
define("_BACKBUTTON","Go back");

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
define("_ERRORFILETYPE", "File format not accepted");
define("_ERRORFILEALREADYDB","File already in database");
define("_UNKNOWNERROR","Unknown error");
define("_MISSINGINFORM1","No ");
define("_MISSINGINFORM2"," were specified");
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
define("_LISTARTICLES","Articles found");
define("_LISTREFERENCES","References");

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
define("_CONFIRM","Confirmation");

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
define("_STATUS","Status");
define("_DATABASE_MANAGEMENT","Database management");
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
define("_SERVER_CONNECTION","Connection to the server");
define("_DATABASECREATE_SUCCESS","The database has been successfully created");

?>
