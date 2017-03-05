<?php

/**
 *  Main point application
 *  includes all requirements
 *  init Server
 *  run Server
 *  @data   2017
 *
 */

require_once("./api.php");

$server = new Server();
$server->run();
