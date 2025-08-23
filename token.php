<?php

require_once('../../config.php');
require_once(__DIR__ . '/oauth2-server-php/src/OAuth2/Autoloader.php');
OAuth2\Autoloader::register();
require_once(__DIR__ . '/classes/utils.php');

use OAuth2\Request;
use OAuth2\Response;
use local_oauth2_server\utils;

defined('MOODLE_INTERNAL') || die();

$server = utils::getServer();

$request = Request::createFromGlobals();
$response = new Response();

$server->handleTokenRequest($request, $response)->send();
