<?php

namespace local_oauth2_server;

use OAuth2\Storage\ClientCredentialsInterface;

class MoodleClientStorage implements ClientCredentialsInterface {
    public function checkClientCredentials($client_id, $client_secret = null) {
        global $DB;
        $client = $DB->get_record('local_oauth2_server_clients', ['client_id' => $client_id]);
        return $client && $client->client_secret === $client_secret;
    }

    public function isPublicClient($client_id) {
        return false;
    }

    public function getClientDetails($client_id) {
        global $DB;
        return (array) $DB->get_record('local_oauth2_server_clients', ['client_id' => $client_id], '*', IGNORE_MISSING);
    }

    public function getClientScope($client_id) {
        global $DB;
        $client = $DB->get_record('local_oauth2_server_clients', ['client_id' => $client_id]);
        return $client ? null : null;
    }

    public function checkRestrictedGrantType($client_id, $grant_type) {
        return true;
    }
}
