<?php

/**
 * @brief		ensemble des inclusions nécessaires a l'application
 * @author		Artiom FEDOROV
 *
 */

// Definitions des Constantes
define ("PATH_SEP", '/');	

// Permet la surcharge en amont de path_current pour que tout s'include correctement
if (!defined ( "PATH_CURRENT" ) ) {
	define ("PATH_CURRENT", "." . PATH_SEP );
}

define ("PATH_CONFIGS", PATH_CURRENT. "config" . PATH_SEP);	
define ("PATH_LIBS", PATH_CURRENT . "libs" . PATH_SEP );
define ("LIBS_PATH", PATH_CURRENT . "libs" . PATH_SEP );
define ("PATH_FONTS", PATH_CURRENT."public" . PATH_SEP . "fonts" . PATH_SEP);
define ("PATH_MODULES", PATH_CURRENT . "modules" . PATH_SEP );
define ("PATH_CORE", PATH_CURRENT . "core" . PATH_SEP );
define ("PATH_CORE_CONTROLLER", PATH_CORE . "controller" . PATH_SEP );	
define ("PATH_CORE_STD_MODULES", PATH_CORE_CONTROLLER . "module" .PATH_SEP );	
define ("PATH_CORE_VIEWS", PATH_CORE . "views" . PATH_SEP );
define ("PATH_CUSTOM", PATH_CURRENT. "custom" . PATH_SEP);	
define ("PATH_CUSTOM_CONTROLLER", PATH_CUSTOM . "controller" . PATH_SEP);	
define ("PATH_CUSTOM_VIEWS", PATH_CUSTOM . "views" . PATH_SEP);
define ("PATH_CORE_INTERNAL_MODULES", PATH_CORE . "internalmodules" . PATH_SEP );	

define ("PATH_CORE_RESSOURCES_JS", PATH_CORE . "ressources" . PATH_SEP . "js". PATH_SEP);		
define ("URL_CORE_RESSOURCES_JS", "core" . PATH_SEP . "ressources" . PATH_SEP . "js". PATH_SEP);

define ("ADMIN_LOGIN", "admin");
define ("ADMIN_PASSWORD", "admin");


// Inclusion des fichiers libs
require_once(PATH_CONFIGS . "db.php");
require_once(PATH_LIBS . "sqlAdvanced.class.php");		
require_once(PATH_LIBS . "sql.class.php");
require_once(PATH_LIBS . "request.class.php");
require_once(PATH_LIBS . "dataAdapter.class.php");
require_once(PATH_LIBS . "OrmNode.class.php");
require_once(PATH_LIBS . "helper.class.php");	
require_once(PATH_LIBS . "html.render.class.php");	
require_once(PATH_LIBS . "core.controller.class.php");
require_once(PATH_LIBS . "moduleManager.class.php");
require_once(PATH_LIBS . "dataNode.class.php");
require_once(PATH_LIBS . "users.class.php");
require_once(PATH_LIBS . "phpMailer.class.php");
require_once(PATH_LIBS . "myMail.class.php");
require_once(PATH_LIBS . "simpleCoords.class.php");
	
require_once(PATH_LIBS . "autoloader.php");

