<?php

namespace local_oauth2_server;

use OAuth2\Storage\UserCredentialsInterface;

class MoodleUserStorage implements UserCredentialsInterface {
    public function checkUserCredentials($username, $password) {
        global $DB;
        if ($user = $DB->get_record('user', ['username' => $username, 'deleted' => 0])) {
            return validate_internal_user_password($user, $password);
        }
        return false;
    }
    public function getUserDetails($username) {
        global $DB;
        return $DB->get_record('user', ['username' => $username, 'deleted' => 0], '*', MUST_EXIST);
    }
}
