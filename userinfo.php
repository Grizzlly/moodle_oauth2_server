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

if (!$server->verifyResourceRequest($request, $response)) {
    $response->send();
    exit;
}

$token = $server->getAccessTokenData($request);
$user_id = $token['user_id'] ?? null;

if (!$user_id) {
    http_response_code(401);
    echo json_encode(['error' => 'No user associated with token']);
    exit;
}

global $DB;
$user = $DB->get_record('user', ['id' => $user_id, 'deleted' => 0], '*', MUST_EXIST);

$fields = $DB->get_records('user_info_field', null, 'id ASC', 'id, shortname');
$customdata = [];

if ($fields) {
    list($insql, $params) = $DB->get_in_or_equal(array_keys($fields));
    $params[] = $user_id;

    $records = $DB->get_records_select(
        'user_info_data',
        "fieldid $insql AND userid = ?",
        $params,
        '',
        'fieldid, data'
    );

    foreach ($records as $record) {
        if (isset($fields[$record->fieldid])) {
            $shortname = $fields[$record->fieldid]->shortname;
            $customdata[$shortname] = $record->data;
        }
    }
}

$output = array_merge([
    'sub'       => $user->id,
    'username'  => $user->username,
    'email'     => $user->email,
    'firstname' => $user->firstname,
    'lastname'  => $user->lastname
], $customdata);

header('Content-Type: application/json');
echo json_encode($output);
