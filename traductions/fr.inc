<?php
 
// fichier de langues en français

// Index
define("_ACCUEIL","Accueil");
define("_BIENVENUE","Bienvenue sur le site de notre projet BTG (Better Than Google), un moteur de recherche sémantique multilingue basé sur les référencements de concepts et non de mots.");
define("_PROMOTION","Découvrez le moteur de recherche révolutionnaire qui deviendra le plus utilisé de l'Internet d'ici quelques semaines...");
define("_MORE_INFO","Plus d'infos");

// Shared
define("_NAME","Nom");
define("_FILE","Fichier");

// Shared (forms)
define("_FORMSUBMIT","Confirmer");
define("_FORMRESET","Annuler");
define("_FORMCANCEL","Abandonner");
define("_FORMREQUESTED","Champ requis");
define("_FORMERROR","Il y a des erreurs dans le formulaire");

// Shared (errors)
define("_ERROR","Erreur");
define("_NOFILEERROR","Aucun fichier choisi");
define("_PARSEERROR","Erreur lors du parsing (le fichier n'est pas correct)");
define("_ENCODINGERROR","Erreur d'encodage (UTF-8 nécessaire)");
define("_UNKNOWNERROR","Erreur inconnue");
define("_MISSINGINFORM1","aucun ");
define("_MISSINGINFORM2"," n'a été spécifié");
function _composeMisingError($m){return _MISSINGINFORM1.strtolower($m)._MISSINGINFORM2;}

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
define("_ICON","Icône fait par");
define("_FROM","de");
define("_VECTOR","Images vectorielles par");

// Search
define("_SEARCH","Rechercher");
define("_CONCEPTS","Concepts");
define("_TERMS","Termes");

// Create article
define("_CREATEARTICLE","Créer un nouvel article");
define("_CHOOSENAME","Choisir un nom");
define("_CHOOSEFILE","Choisir un fichier");
define("_LANGUAGE","Langue");
define("_OTHERLANGUAGE","autre (le texte ne sera pas référencé)");

// Create onto
define("_CREATEONTO","Créer une nouvelle ontoterminologie");
define("_ASKREPLACE","Êtes-vous sûr de vouloir charger une nouvelle ontoterminologie? Cela entraînera la suppression totale de l'ancienne.");

// Show article
define("_REFERENCE","Références");
define("_EDIT","Editer");
define("_DELETE","Supprimer");

// Edit articles
define("_EDITARTICLE","Modifier l'article");

// Maintenance
define("_ONTO","Ontoterminologie");
define("_ADVANCED","Avancé");
define("_SYSTEM", "Système");
define("_SERVUSER", "Propriétaire du service");
define("_NETWORK", "Réseau");
define("_SERVERIP", "Adresse IP serveur");
define("_CLIENTIP", "Adresse IP client");

?>