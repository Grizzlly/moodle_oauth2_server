<?php

require_once('../../config.php');
require_once(__DIR__ . '/oauth2-server-php/src/OAuth2/Autoloader.php');
OAuth2\Autoloader::register();
require_once(__DIR__ . '/classes/utils.php');

use OAuth2\Request;
use OAuth2\Response;
use local_oauth2_server\utils;

require_login();

$clientid = required_param('client_id', PARAM_TEXT);
$responsetype = required_param('response_type', PARAM_TEXT);
$scope = optional_param('scope', false, PARAM_TEXT);
$state = optional_param('state', false, PARAM_TEXT);
$url = new moodle_url('/local/oauth2/login.php', ['client_id' => $clientid, 'response_type' => $responsetype]);

if ($scope) {
    $url->param('scope', $scope);
}

if ($state) {
    $url->param('state', $state);
}

$PAGE->set_url($url);
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('login');

$server = utils::getServer();

$request = Request::createFromGlobals();
$response = new Response();

$isauthorized = true; // Hell yeah

if (!$server->validateAuthorizeRequest($request, $response)) {
    $response->send();
    die();
}

$server->handleAuthorizeRequest($request, $response, $isauthorized, $USER->id);
$response->send();
