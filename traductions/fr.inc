<?php
 
// fichier de langues en français

// Index
define("_ACCUEIL","Accueil");
define("_BIENVENUE","Bienvenue sur le site de notre projet BTG (Better Than Google), un moteur de recherche sémantique multilingue basé sur les référencements de concepts et non de mots.");
define("_PROMOTION","Découvrez le moteur de recherche révolutionnaire qui deviendra le plus utilisé de l'Internet d'ici quelques semaines...");
define("_MORE_INFO","Plus d'infos");
define("_IMPORT_TITLE","Importez votre ontoterminologie");
define("_IMPORT_TEXT","Afin d'utiliser notre site la première étape est d'ajouter une ontoterminologie, vous pouvez importer votre propre ontotermonologie afin d'adapter le site a vos besoins.");
define("_ADD_TITLE","Ajoutez vos articles");
define("_ADD_TEXT","En quelques clics seulement, vous pouvez ajouter vos articles sur le site, ils seront directement référencés par l'ontoterminologie actuelle suivant la langue sélectionné.");
define("_SEARCH_TITLE","Rechercher un concept");
define("_SEARCH_TEXT","Lorsque vous avez importé une ontoterminologie et ajouté vos articles, vous pouvez lancer une recherche ! Les recherches se font sur des concepts et pas sur les mot-clés, cela vous permet d'avoir des résultats plus pertinents.");

// Shared
define("_NAME","Nom");
define("_FILE","Fichier");
define("_DATABASE","Base de données");
define("_BACKBUTTON","Retour");

// Shared (forms)
define("_FORMSUBMIT","Confirmer");
define("_FORMRESET","Annuler");
define("_FORMCANCEL","Abandonner");
define("_FORMREQUESTED","Champ requis");
define("_FORMERROR","Il y a des erreurs dans le formulaire");

// Shared (errors)
define("_ERROR","Erreur");
define("_ERRORFORMHANDLING","Erreur lors du traitement du formulaire");
define("_WATCHLOGS","Regardez les logs pour plus d\'information");
define("_NOFILEERROR","Aucun fichier choisi");
define("_PARSEERROR","Erreur lors du parsing (le fichier n\'est pas correct)");
define("_ENCODINGERROR","Erreur d'encodage (UTF-8 nécessaire)");
define("_UNKNOWNERROR","Erreur inconnue");
define("_MISSINGINFORM1","Aucun ");
define("_MISSINGINFORM2"," n'a été spécifié");
function _composeMisingError($m){return _MISSINGINFORM1.strtolower($m)._MISSINGINFORM2;}
define("_ERRORLANGUAGES","Aucune langue trouvée dans la base de données");
define("_IMPORTONTO","Essayez d'importer une ontoterminologie pour régler le problème");

// Header
define("_RECHERCHER","Rechercher");
define("_ARTICLES","Articles");
define("_ARTICLES_NEW","Nouvel article");
define("_ONTO_NEW","Nouvelle ontoterminologie");
define("_MAINTENANCE","Maintenance");

// Footer
define("_WHY","BTG est un projet réalisé dans le cadre de la L3 Informatique.");
define("_FULL_CODE_1","Le code complet est disponible sur GitHub à ");
define("_FULL_CODE_2","cette adresse");
define("_ICON","Icon made by");
define("_FROM","from");
define("_VECTOR","Vector images by");

// Search
define("_SEARCH","Rechercher");
define("_CONCEPTS","Concepts");
define("_TERMS","Termes");
define("_LISTARTICLES","Articles trouvés");
define("_LISTREFERENCES","Références");

// Create article
define("_CREATEARTICLE","Créer un nouvel article");
define("_CHOOSENAME","Choisir un nom");
define("_CHOOSEFILE","Choisir un fichier");
define("_LANGUAGE","Langue");
define("_OTHERLANGUAGE","autre (le texte ne sera pas référencé)");
define("_CREATESUCCES","L\'article a été créé avec succès");
define("_LINKARTICLE","Accéder à l\'article");

// Create onto
define("_CREATEONTO","Créer une nouvelle ontoterminologie");
define("_ASKREPLACE","Êtes-vous sûr de vouloir charger une nouvelle ontoterminologie? Cela entraînera la suppression totale de l'ancienne.");
define("_CONFIRM","Confirmation");

// Show article
define("_REFERENCE","Références");
define("_EDIT","Editer");
define("_DELETE","Supprimer");
define("_NO_PDF","Ce navigateur ne permet pas de visualiser les pdf: ");
define("_PDF_DL","Télécharger le pdf");
define("_FILE_NOT_FOUND","Fichier introuvable sur le disque.");
define("_WHY_ERROR"," Aller dans l\'onglet Maintenance pour plus d\'information.");

// Edit articles
define("_EDITARTICLE","Modifier l'article");
define("_EDITSUCCES","L\'article a été modifié avec succès");

// Maintenance
define("_STATUS","Statut");
define("_DATABASE_MANAGEMENT","Gérer BDD");
define("_ONTO","Ontoterminologie");
define("_ADVANCED","Avancé");
define("_SYSTEM", "Système");
define("_SERVUSER", "Propriétaire du service");
define("_NETWORK", "Réseau");
define("_SERVERIP", "Adresse IP serveur");
define("_CLIENTIP", "Adresse IP client");
define("_ARTICLES_ALL","Articles totaux: ");
define("_ARTICLES_NO_REF","Articles non référencés: ");
define("_LOCATION","Emplacement: ");
define("_ERROR_DISK_FILE","Erreurs de correspondance avec les fichiers du disque: ");
define("_ROOT_NUMBERS","Nombre de racines: ");
define("_ERROR_BUILD","Erreurs de construction: ");
define("_MISSING_FILES","Fichiers manquant sur le disque:");
define("_EXCESS_FILES","Fichiers en trop sur le disque:");
define("_SERVER_CONNECTION","Connexion au serveur");

?>
