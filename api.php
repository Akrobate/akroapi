<?php

/**
 * @brief		ensemble des inclusions nécessaires a l'application
 * @author		Artiom FEDOROV
 *
 */

///////////////////////////////////////////////////////////////////////////////////
/////////////////////////// MUST BE SET FOR THE CORE AKROAPI //////////////////////
///////////////////////////////////////////////////////////////////////////////////

// Definitions des Constantes
define ("PATH_SEP", '/');

// Permet la surcharge en amont de path_current pour que tout s'include correctement
if (!defined ( "PATH_CURRENT" ) ) {
	define ("PATH_CURRENT", "." . PATH_SEP );
}
define ("PATH_CONFIGS", PATH_CURRENT. "config" . PATH_SEP);
define ("PATH_CORE", PATH_CURRENT . "core" . PATH_SEP );
define ("PATH_MODULES", PATH_CURRENT . "modules" . PATH_SEP );
define ("PATH_CONTROLLER", PATH_CURRENT . "controllers" . PATH_SEP);

///////////////////////////////////////////////////////////////////////////////////
/////////////////////////// MUST BE SET FOR THE CORE AKROAPI //////////////////////
///////////////////////////////////////////////////////////////////////////////////

// Inclusion des fichiers libs
require_once(PATH_CONFIGS . "db.php");
// Include of akroApi Core
require_once(PATH_CORE . "api.php");
// Include of akroApi Core simple Server
require_once(PATH_CORE . "server.php");
