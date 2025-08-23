<?php

namespace local_oauth2_server;

require_once(__DIR__ . '/storage/MoodleAuthCodeStorage.php');
require_once(__DIR__ . '/storage/MoodleClientStorage.php');
require_once(__DIR__ . '/storage/MoodleUserStorage.php');
require_once(__DIR__ . '/storage/MoodleAccessTokenStorage.php');

use OAuth2\Server;
use OAuth2\GrantType\AuthorizationCode;
use OAuth2\GrantType\RefreshToken;

class utils {
	public static function getServer(): Server {
		$storage = [
			'client_credentials'    => new MoodleClientStorage(),
			'user_credentials'      => new MoodleUserStorage(),
			'authorization_code'    => new MoodleAuthCodeStorage(),
			'access_token'          => new MoodleAccessTokenStorage()
		];

		$server = new Server($storage);
		$server->setConfig('enforce_state', false);

        $server->addGrantType(new AuthorizationCode(new MoodleAuthCodeStorage()));

		return $server;
	}
}
