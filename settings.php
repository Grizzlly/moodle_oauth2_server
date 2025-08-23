<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_oauth2_server', get_string('pluginname', 'local_oauth2_server'));
    $ADMIN->add('localplugins', $settings);
}
