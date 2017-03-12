<?php

/**
 *  Core AkroApi constant path definitions
 *  and files includes
 *  @date   2017
 *
 */

if (!defined ( "PATH_CURRENT" ) ) {
	define ("PATH_CURRENT", "." . PATH_SEP );
}

define ("PATH_CORE_LIBS", PATH_CORE . "libs" . PATH_SEP);
define ("PATH_CORE_CONTROLLER", PATH_CORE . "controllers" . PATH_SEP);
define ("PATH_CORE_INTERNAL_MODULES", PATH_CORE . "internalmodules" . PATH_SEP);

if (!defined ( "ADMIN_LOGIN" ) ) {
    define ("ADMIN_LOGIN", "admin");
}

if (!defined ( "ADMIN_PASSWORD" ) ) {
    define ("ADMIN_PASSWORD", "admin");
}

require_once(PATH_CORE_LIBS . "sqlAdvanced.class.php");
require_once(PATH_CORE_LIBS . "sql.class.php");
require_once(PATH_CORE_LIBS . "logger.class.php");
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
