<?php

defined('MOODLE_INTERNAL') || die();

$capabilities = [
    'local/oauth2_server:manage_oauth2_clients' => [
        'riskbitmask' => RISK_SPAM | RISK_PERSONAL | RISK_XSS,
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => [
            'manager' => CAP_ALLOW,
        ],
    ],
];
