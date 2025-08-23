<?php

namespace local_oauth2_server;

use OAuth2\Storage\AccessTokenInterface;
use stdClass;

class MoodleAccessTokenStorage implements AccessTokenInterface {
    public function getAccessToken($access_token) {
        global $DB;
        if ($token = $DB->get_record('local_oauth2_server_access_tokens', ['access_token' => $access_token], '*', IGNORE_MISSING)) {
            unset($token->id);
            return (array)$token;
        } else {
            return false;
        }
    }

    public function setAccessToken($access_token, $client_id, $user_id, $expires, $scope = null) {
        global $DB;
        $record = new stdClass();
        $record->access_token = $access_token;
        $record->client_id = $client_id;
        $record->user_id = $user_id;
        $record->expires = $expires;
        $record->scope = $scope;
        $DB->insert_record('local_oauth2_server_access_tokens', $record);
    }
}
