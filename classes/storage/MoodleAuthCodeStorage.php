<?php

namespace local_oauth2_server;

use OAuth2\Storage\AuthorizationCodeInterface;
use stdClass;

class MoodleAuthCodeStorage implements AuthorizationCodeInterface {

    public function getAuthorizationCode($code) {
        global $DB;

        if ($authcode = $DB->get_record('local_oauth2_server_auth_codes', ['auth_code' => $code])) {
            unset($authcode->id);
            return (array)$authcode;
        } else {
            return false;
        }
    }

    public function setAuthorizationCode($code, $client_id, $user_id, $redirect_uri, $expires, $scope = null) {
        global $DB;
        $record = new stdClass();
        $record->auth_code = $code;
        $record->client_id = $client_id;
        $record->user_id = $user_id;
        $record->redirect_uri = $redirect_uri;
        $record->expires = $expires;
        $record->scope = $scope;
        $DB->insert_record('local_oauth2_server_auth_codes', $record);
    }

    public function expireAuthorizationCode($code) {
        global $DB;
        $DB->delete_records('local_oauth2_server_auth_codes', ['auth_code' => $code]);
    }
}
