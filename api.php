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

define ("PATH_CORE", PATH_CURRENT . "core" . PATH_SEP );
// define ("PATH_CORE_LIBS", PATH_CURRENT . "libs" . PATH_SEP );
define ("PATH_CORE_LIBS", PATH_CORE . "libs" . PATH_SEP );
define ("PATH_CORE_CONTROLLER", PATH_CORE . "controller" . PATH_SEP );
define ("PATH_CORE_INTERNAL_MODULES", PATH_CORE . "internalmodules" . PATH_SEP );

define ("PATH_CUSTOM", PATH_CURRENT. "custom" . PATH_SEP);
define ("PATH_MODULES", PATH_CURRENT . "modules" . PATH_SEP );
define ("PATH_CUSTOM_CONTROLLER", PATH_CUSTOM . "controller" . PATH_SEP);


define ("ADMIN_LOGIN", "admin");
define ("ADMIN_PASSWORD", "admin");


// Inclusion des fichiers libs
require_once(PATH_CONFIGS . "db.php");
require_once(PATH_CORE_LIBS . "sqlAdvanced.class.php");
require_once(PATH_CORE_LIBS . "sql.class.php");
require_once(PATH_CORE_LIBS . "sessiondb.class.php");
require_once(PATH_CORE_LIBS . "request.class.php");
require_once(PATH_CORE_LIBS . "dataAdapter.class.php");
require_once(PATH_CORE_LIBS . "OrmNode.class.php");
require_once(PATH_CORE_LIBS . "helper.class.php");
require_once(PATH_CORE_LIBS . "core.controller.class.php");
require_once(PATH_CORE_LIBS . "moduleManager.class.php");
require_once(PATH_CORE_LIBS . "dataNode.class.php");
require_once(PATH_CORE_LIBS . "users.class.php");
require_once(PATH_CORE_LIBS . "phpMailer.class.php");
require_once(PATH_CORE_LIBS . "myMail.class.php");
require_once(PATH_CORE_LIBS . "users.class.php");

require_once(PATH_CORE_LIBS . "autoloader.php");
